<?php

namespace App\Filament\Pages;

use App\Models\EmailFolder;
use App\Models\EmailLabel;
use App\Models\EmailMessage;
use App\Models\ReplyTemplate;
use App\Models\Setting;
use App\Services\Mailbox as MailboxService;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Mailbox extends Page
{
    use WithFileUploads;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static ?string $navigationLabel = 'Postafiók';

    protected static ?string $title = 'Postafiók';

    protected static ?string $slug = 'mailbox';

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.mailbox';

    public ?int $selectedFolderId = null;

    public bool $starredView = false;

    /**
     * Mobil nézeten (lg alatt) a mappa/címke oldalsáv alapból rejtett
     * kihúzható fiókként (drawer) jelenik meg, ahogy a Gmail mobil app is
     * teszi — ez tárolja, hogy éppen nyitva van-e.
     */
    public bool $sidebarOpen = false;

    public ?int $selectedMessageId = null;

    /** @var array<int, int> */
    public array $selected = [];

    public bool $labelPickerOpen = false;

    public string $search = '';

    public bool $showNewFolder = false;

    public string $newFolderName = '';

    public bool $showNewLabel = false;

    public string $newLabelName = '';

    // --- Levélszerkesztő (lebegő panel) ---

    public ?string $composeMode = null; // new | reply | forward

    public ?int $composeOriginalId = null;

    /** @var array<int, array{name: ?string, email: string}> */
    public array $composeTo = [];

    public string $composeToInput = '';

    public string $composeSubject = '';

    public string $composeBody = '';

    public ?string $composeThreadId = null;

    public bool $composeMinimized = false;

    public bool $templateMenuOpen = false;

    /** @var array<int, TemporaryUploadedFile> */
    public array $composeAttachments = [];

    /** @var array<int, array{path: string, filename: string, mime: ?string, size: ?int}> */
    public array $composeAttachmentFiles = [];

    // --- Beállítások (lebegő párbeszédablak) ---

    public bool $settingsOpen = false;

    public string $settingsTab = 'signature';

    public bool $signatureAuto = true;

    public bool $autoReplyEnabled = false;

    public ?string $autoReplyStart = null;

    public ?string $autoReplyEnd = null;

    public string $autoReplyMessage = '';

    public string $newTemplateName = '';

    public string $newTemplateBody = '';

    /**
     * Mobil nézeten (lg alatt) egyszerre csak egy panel látszik —
     * ez tárolja, melyik: 'folders' | 'messages' | 'reading'.
     */
    public string $mobileView = 'folders';

    public function mount(): void
    {
        $this->selectedFolderId = EmailFolder::inbox()->id;
    }

    public function getHeading(): string
    {
        return '';
    }

    /**
     * @return array<int, mixed>
     */
    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function toggleSidebar(): void
    {
        $this->sidebarOpen = ! $this->sidebarOpen;
    }

    // --- Mappák / nézetek ---

    public function getFolders(): Collection
    {
        return EmailFolder::withCount(['messages' => fn ($query) => $query->where('status', 'unread')])
            ->orderBy('order')
            ->get();
    }

    public function getFolderMessages(): Collection
    {
        $query = $this->starredView
            ? EmailMessage::query()
                ->where('starred', true)
                ->whereRelation('folder', 'key', '!=', 'trash')
            : EmailMessage::query()->where('folder_id', $this->selectedFolderId);

        return $query
            ->with('labels')
            ->withCount('attachments')
            ->when(filled($this->search), function ($query) {
                $term = '%'.$this->search.'%';

                $query->where(function ($query) use ($term) {
                    $query->where('subject', 'like', $term)
                        ->orWhere('from_name', 'like', $term)
                        ->orWhere('from_email', 'like', $term)
                        ->orWhere('body_text', 'like', $term);
                });
            })
            ->orderByDesc('created_at')
            ->get();
    }

    public function getSelectedMessage(): ?EmailMessage
    {
        return $this->selectedMessageId ? EmailMessage::with('labels', 'attachments')->find($this->selectedMessageId) : null;
    }

    public function getCurrentTitle(): string
    {
        if ($this->starredView) {
            return 'Csillagozott';
        }

        return $this->getFolders()->firstWhere('id', $this->selectedFolderId)?->name ?? '';
    }

    public function selectFolder(int $folderId): void
    {
        $this->selectedFolderId = $folderId;
        $this->starredView = false;
        $this->selectedMessageId = null;
        $this->selected = [];
        $this->mobileView = 'messages';
        $this->sidebarOpen = false;
    }

    public function goStarred(): void
    {
        $this->starredView = true;
        $this->selectedMessageId = null;
        $this->selected = [];
        $this->mobileView = 'messages';
        $this->sidebarOpen = false;
    }

    public function selectMessage(int $messageId): void
    {
        $this->selectedMessageId = $messageId;
        $this->labelPickerOpen = false;
        $this->mobileView = 'reading';

        $this->getSelectedMessage()?->markAsRead();
    }

    public function backToFolders(): void
    {
        $this->mobileView = 'folders';
    }

    public function backToMessages(): void
    {
        $this->mobileView = 'messages';
    }

    public function openNewFolder(): void
    {
        $this->newFolderName = '';
        $this->showNewFolder = true;
    }

    public function closeNewFolder(): void
    {
        $this->showNewFolder = false;
    }

    public function createFolder(): void
    {
        $data = $this->validate([
            'newFolderName' => ['required', 'string', 'max:255'],
        ]);

        $maxOrder = EmailFolder::max('order') ?? 0;

        EmailFolder::create([
            'name' => $data['newFolderName'],
            'type' => 'custom',
            'order' => $maxOrder + 1,
        ]);

        $this->showNewFolder = false;

        Notification::make()->title('Mappa létrehozva')->success()->send();
    }

    /**
     * @return array<int, string>
     */
    public function getMoveTargetFolders(): array
    {
        return EmailFolder::orderBy('order')->pluck('name', 'id')->all();
    }

    public function moveSelectedMessageToFolder(mixed $folderId): void
    {
        if (! is_numeric($folderId)) {
            return;
        }

        $message = $this->getSelectedMessage();

        if (! $message) {
            return;
        }

        $message->update(['folder_id' => (int) $folderId]);

        Notification::make()->title('Levél áthelyezve')->success()->send();
    }

    public function deleteSelectedMessage(): void
    {
        $message = $this->getSelectedMessage();

        if (! $message) {
            return;
        }

        $trash = EmailFolder::trash();

        if ($message->folder_id === $trash->id) {
            $message->delete();
        } else {
            $message->update(['folder_id' => $trash->id]);
        }

        $this->selectedMessageId = null;
        $this->mobileView = 'messages';

        Notification::make()->title('Levél törölve')->success()->send();
    }

    public function getMessageSnippet(EmailMessage $message): string
    {
        $text = $message->body_text ?: strip_tags((string) $message->body_html);
        $text = trim(preg_replace('/\s+/', ' ', $text) ?? '');

        return Str::limit($text, 70);
    }

    public function formatFileSize(?int $bytes): string
    {
        if (! $bytes) {
            return '';
        }

        if ($bytes < 1024) {
            return $bytes.' B';
        }

        if ($bytes < 1024 * 1024) {
            return round($bytes / 1024).' KB';
        }

        return round($bytes / (1024 * 1024), 1).' MB';
    }

    // --- Csillagozás és tömeges műveletek ---

    public function toggleStar(int $messageId): void
    {
        $message = EmailMessage::find($messageId);
        $message?->update(['starred' => ! $message->starred]);
    }

    public function toggleSelect(int $messageId): void
    {
        if (in_array($messageId, $this->selected, true)) {
            $this->selected = array_values(array_diff($this->selected, [$messageId]));
        } else {
            $this->selected[] = $messageId;
        }
    }

    public function toggleSelectAll(): void
    {
        $ids = $this->getFolderMessages()->pluck('id')->all();
        $allSelected = count($ids) > 0 && empty(array_diff($ids, $this->selected));

        $this->selected = $allSelected ? [] : $ids;
    }

    public function bulkMarkRead(): void
    {
        EmailMessage::whereIn('id', $this->selected)->update(['status' => 'read']);
        $this->selected = [];
    }

    public function bulkStar(): void
    {
        EmailMessage::whereIn('id', $this->selected)->update(['starred' => true]);
        $this->selected = [];
    }

    public function bulkTrash(): void
    {
        EmailMessage::whereIn('id', $this->selected)->update(['folder_id' => EmailFolder::trash()->id]);
        $this->selected = [];
    }

    // --- Címkék ---

    public function getLabels(): Collection
    {
        return EmailLabel::orderBy('id')->get();
    }

    public function toggleAddLabel(): void
    {
        $this->showNewLabel = ! $this->showNewLabel;
        $this->newLabelName = '';
    }

    public function addLabel(): void
    {
        $data = $this->validate([
            'newLabelName' => ['required', 'string', 'max:255'],
        ]);

        EmailLabel::create([
            'name' => $data['newLabelName'],
            'color' => EmailLabel::count() % 2 === 0 ? 'blue' : 'rose',
        ]);

        $this->showNewLabel = false;
        $this->newLabelName = '';
    }

    public function removeLabel(int $labelId): void
    {
        EmailLabel::find($labelId)?->delete();
    }

    public function toggleLabelPicker(): void
    {
        $this->labelPickerOpen = ! $this->labelPickerOpen;
    }

    public function toggleMessageLabel(int $labelId): void
    {
        $this->getSelectedMessage()?->labels()->toggle($labelId);
    }

    // --- Levélszerkesztő ---

    public function openComposeNew(): void
    {
        $this->resetComposeState();
        $this->composeMode = 'new';
        $this->composeBody = $this->signatureBlock();
        $this->sidebarOpen = false;
    }

    public function openReply(): void
    {
        $original = $this->getSelectedMessage();

        if (! $original) {
            return;
        }

        $this->resetComposeState();
        $this->composeMode = 'reply';
        $this->composeOriginalId = $original->id;
        $this->composeTo = [['name' => $original->from_name, 'email' => $original->from_email]];
        $this->composeSubject = MailboxService::buildReplySubject((string) $original->subject);
        $this->composeThreadId = $original->thread_id;
        $this->composeBody = $this->signatureBlock();
    }

    public function openForward(): void
    {
        $original = $this->getSelectedMessage();

        if (! $original) {
            return;
        }

        $this->resetComposeState();
        $this->composeMode = 'forward';
        $this->composeOriginalId = $original->id;
        $this->composeSubject = MailboxService::buildForwardSubject((string) $original->subject);
        $this->composeBody = $this->signatureBlock();
    }

    public function toggleComposeMinimize(): void
    {
        $this->composeMinimized = ! $this->composeMinimized;
    }

    public function discardCompose(): void
    {
        $this->resetComposeState();
    }

    public function addTypedRecipient(): void
    {
        $email = trim($this->composeToInput);

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        $exists = collect($this->composeTo)->contains(fn (array $c) => mb_strtolower($c['email']) === mb_strtolower($email));

        if (! $exists) {
            $this->composeTo[] = ['name' => null, 'email' => $email];
        }

        $this->composeToInput = '';
    }

    public function pickContact(string $email, ?string $name = null): void
    {
        $exists = collect($this->composeTo)->contains(fn (array $c) => mb_strtolower($c['email']) === mb_strtolower($email));

        if (! $exists) {
            $this->composeTo[] = ['name' => $name, 'email' => $email];
        }

        $this->composeToInput = '';
    }

    public function removeRecipient(int $index): void
    {
        unset($this->composeTo[$index]);
        $this->composeTo = array_values($this->composeTo);
    }

    /**
     * @return array<int, array{name: string, email: string}>
     */
    public function getContactMatches(): array
    {
        return MailboxService::contactSuggestions(
            $this->composeToInput,
            array_column($this->composeTo, 'email'),
        );
    }

    public function toggleTemplateMenu(): void
    {
        $this->templateMenuOpen = ! $this->templateMenuOpen;
    }

    public function insertTemplate(int $templateId): void
    {
        $template = ReplyTemplate::find($templateId);

        if (! $template) {
            return;
        }

        $this->composeBody = $this->composeBody !== ''
            ? $this->composeBody."\n\n".$template->body
            : $template->body;

        $this->templateMenuOpen = false;
    }

    public function updatedComposeAttachments(): void
    {
        foreach ($this->composeAttachments as $file) {
            if (! $file) {
                continue;
            }

            $path = $file->store('email-attachments/compose', 'local');

            $this->composeAttachmentFiles[] = [
                'path' => $path,
                'filename' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ];
        }

        $this->composeAttachments = [];
    }

    public function removeComposeAttachment(int $index): void
    {
        if (! isset($this->composeAttachmentFiles[$index])) {
            return;
        }

        Storage::disk('local')->delete($this->composeAttachmentFiles[$index]['path']);

        unset($this->composeAttachmentFiles[$index]);
        $this->composeAttachmentFiles = array_values($this->composeAttachmentFiles);
    }

    public function sendCompose(): void
    {
        $this->addTypedRecipient();

        $data = $this->validate([
            'composeSubject' => ['required', 'string', 'max:255'],
            'composeBody' => ['required', 'string'],
            'composeAttachments.*' => ['nullable', 'file', 'max:20480'],
        ]);

        if (empty($this->composeTo)) {
            $this->addError('composeToInput', 'Adj meg legalább egy címzettet.');

            return;
        }

        $bodyHtml = nl2br(e($data['composeBody']));

        $original = $this->composeOriginalId ? EmailMessage::find($this->composeOriginalId) : null;

        if ($original) {
            $bodyHtml .= $this->composeMode === 'forward'
                ? MailboxService::buildForwardBody($original)
                : MailboxService::buildReplyBody($original);
        }

        MailboxService::send(
            to: $this->composeTo,
            subject: $data['composeSubject'],
            bodyHtml: $bodyHtml,
            threadId: $this->composeThreadId,
            inReplyTo: $this->composeMode === 'reply' ? $original?->message_id_header : null,
            attachments: $this->composeAttachmentFiles,
        );

        $this->resetComposeState(deleteStagedAttachments: false);

        Notification::make()->title('Levél elküldve')->success()->send();
    }

    private function resetComposeState(bool $deleteStagedAttachments = true): void
    {
        if ($deleteStagedAttachments) {
            foreach ($this->composeAttachmentFiles as $file) {
                Storage::disk('local')->delete($file['path']);
            }
        }

        $this->composeMode = null;
        $this->composeOriginalId = null;
        $this->composeTo = [];
        $this->composeToInput = '';
        $this->composeSubject = '';
        $this->composeBody = '';
        $this->composeThreadId = null;
        $this->composeMinimized = false;
        $this->composeAttachments = [];
        $this->composeAttachmentFiles = [];
        $this->templateMenuOpen = false;
    }

    private function signatureBlock(): string
    {
        if (! Setting::getBool('email_signature_auto', true)) {
            return '';
        }

        $signature = MailboxService::signatureAsPlainText();

        return $signature === '' ? '' : "\n\n{$signature}";
    }

    // --- Beállítások ---

    public function openSettings(): void
    {
        $this->signatureAuto = Setting::getBool('email_signature_auto', true);
        $this->autoReplyEnabled = Setting::getBool('autoresponder_enabled', false);
        $this->autoReplyStart = Setting::get('autoresponder_start') ?: null;
        $this->autoReplyEnd = Setting::get('autoresponder_end') ?: null;
        $this->autoReplyMessage = (string) Setting::get('autoresponder_message', '');
        $this->settingsTab = 'signature';
        $this->settingsOpen = true;
        $this->sidebarOpen = false;
    }

    public function closeSettings(): void
    {
        $this->settingsOpen = false;
    }

    public function tabSignature(): void
    {
        $this->settingsTab = 'signature';
    }

    public function tabAutoReply(): void
    {
        $this->settingsTab = 'autoreply';
    }

    public function tabTemplates(): void
    {
        $this->settingsTab = 'templates';
    }

    public function updatedSignatureAuto(): void
    {
        Setting::set('email_signature_auto', $this->signatureAuto ? '1' : '0');
    }

    public function updatedAutoReplyEnabled(): void
    {
        Setting::set('autoresponder_enabled', $this->autoReplyEnabled ? '1' : '0');
    }

    public function updatedAutoReplyStart(): void
    {
        Setting::set('autoresponder_start', (string) $this->autoReplyStart);
    }

    public function updatedAutoReplyEnd(): void
    {
        Setting::set('autoresponder_end', (string) $this->autoReplyEnd);
    }

    public function updatedAutoReplyMessage(): void
    {
        Setting::set('autoresponder_message', $this->autoReplyMessage);
    }

    public function getEmailSignature(): string
    {
        return (string) Setting::get('email_signature', '');
    }

    public function getTemplates(): Collection
    {
        return ReplyTemplate::orderBy('id')->get();
    }

    public function addTemplate(): void
    {
        $data = $this->validate([
            'newTemplateName' => ['required', 'string', 'max:255'],
            'newTemplateBody' => ['required', 'string', 'max:5000'],
        ]);

        ReplyTemplate::create([
            'name' => $data['newTemplateName'],
            'body' => $data['newTemplateBody'],
        ]);

        $this->newTemplateName = '';
        $this->newTemplateBody = '';
    }

    public function deleteTemplate(int $templateId): void
    {
        ReplyTemplate::find($templateId)?->delete();
    }
}
