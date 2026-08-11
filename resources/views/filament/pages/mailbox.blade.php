@php
    $folderIcons = [
        'inbox' => 'heroicon-o-inbox',
        'sent' => 'heroicon-o-paper-airplane',
        'drafts' => 'heroicon-o-pencil-square',
        'trash' => 'heroicon-o-trash',
    ];
    $selectedMessage = $this->getSelectedMessage();
    $messages = $this->getFolderMessages();
    $messageIds = $messages->pluck('id');
    $selectAllChecked = $messageIds->isNotEmpty() && $messageIds->diff($selected)->isEmpty();
    $contactMatches = $this->getContactMatches();
    $templates = $this->getTemplates();
    $isListView = $mobileView !== 'reading';
    $isDetailView = $mobileView === 'reading' && $selectedMessage;
@endphp

<x-filament-panels::page full-height>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Serif+4:ital,wght@0,400;0,600;1,400&display=swap">
    <style>
        /* Gmail-szerű, teljes magasságú, oldal-görgetés nélküli elrendezés —
           a Filament oldal saját fejléc/margó-tere itt feleslegesen nagy volna. */
        .fi-page-header-main-ctn:has(.mailbox-app) { padding-block: 0.75rem !important; row-gap: 0 !important; }
        .fi-page-content:has(.mailbox-app) { row-gap: 0 !important; }
        .mailbox-app, .mailbox-app input, .mailbox-app textarea, .mailbox-app select, .mailbox-app button {
            font-family: 'Source Serif 4', ui-serif, Georgia, serif;
        }
        .mailbox-app ::selection { background: rgba(0,136,176,0.3); }
        .mailbox-app ::placeholder { color: rgba(32,30,29,0.5); opacity: 1; }
    </style>

    <div class="mailbox-app relative flex h-full min-h-0 w-full flex-col overflow-hidden rounded-lg ring-1 ring-black/10" style="background:#f3f2f2;color:#201e1d">
        {{-- Teljes szélességű felső sáv (kereső + felhasználó), a Gmail mintájára a mappasáv ÉS a tartalom felett --}}
        <div class="flex flex-none items-center gap-3 lg:gap-4" style="padding:10px 16px;border-bottom:1px solid rgba(32,30,29,0.08)">
            <button type="button" wire:click="toggleSidebar" class="flex shrink-0 items-center justify-center lg:hidden" style="background:none;border:none;cursor:pointer;color:#201e1d;padding:6px" aria-label="Menü">
                <x-filament::icon icon="heroicon-o-bars-3" class="h-5 w-5" />
            </button>
            <div class="flex flex-1 items-center gap-2.5" style="max-width:560px;background:#eae9e9;border-radius:20px;padding:9px 16px">
                <x-filament::icon icon="heroicon-o-magnifying-glass" class="h-4 w-4 shrink-0" style="color:rgba(32,30,29,0.55)" />
                <input type="search" wire:model.live.debounce.400ms="search" placeholder="Keresés levelekben és névjegyekben…" class="w-full min-w-0 flex-1" style="border:none;background:none;font-size:14px;color:#201e1d" />
            </div>
            <div class="flex-1"></div>
            <span class="hidden shrink-0 sm:inline" style="font-size:13px;color:rgba(32,30,29,0.6)">Ügyfélszolgálat</span>
            <span class="flex shrink-0 items-center justify-center rounded-full" style="width:34px;height:34px;background:#e9f8ff;color:#004961;font-size:13px;font-weight:600">ÜF</span>
        </div>

        {{-- Mappasáv + tartalom sor --}}
        <div class="flex min-h-0 flex-1">
            @if ($sidebarOpen)
                <div wire:click="toggleSidebar" class="fixed inset-0 z-40 lg:hidden" style="background:rgba(45,43,43,0.4)"></div>
            @endif

            {{-- Mappasáv: asztalon állandó oszlop, mobilon kihúzható fiók --}}
            <div
                class="{{ $sidebarOpen ? 'flex' : 'hidden' }} fixed inset-y-0 left-0 z-50 lg:static lg:z-auto lg:flex w-[260px] lg:w-[236px] shrink-0 flex-col gap-5 overflow-y-auto p-[14px] py-5"
                style="background:#f3f2f2;border-right:1px solid rgba(32,30,29,0.1)"
            >
                <button
                    type="button"
                    wire:click="openComposeNew"
                    class="flex items-center justify-center gap-2 text-white"
                    style="background:#0088b0;border:none;border-radius:20px;padding:12px 20px;font-weight:600;font-size:14px;cursor:pointer;box-shadow:0 3px 10px rgba(0,0,0,0.14)"
                >
                    <x-filament::icon icon="heroicon-o-plus" class="h-4 w-4" />
                    Új levél
                </button>

                <div class="flex flex-col gap-0.5">
                    <div
                        wire:click="goStarred"
                        class="flex cursor-pointer items-center gap-2.5"
                        style="padding:9px 12px;border-radius:16px;font-size:14px;background:{{ $starredView ? '#e9f8ff' : 'transparent' }};color:{{ $starredView ? '#004961' : '#201e1d' }};font-weight:{{ $starredView ? 600 : 400 }}"
                    >
                        <x-filament::icon icon="heroicon-o-star" class="h-4 w-4 shrink-0" />
                        <span class="flex-1 truncate">Csillagozott</span>
                    </div>

                    @foreach ($this->getFolders() as $folder)
                        @php($isActive = ! $starredView && $selectedFolderId === $folder->id)
                        <div
                            wire:click="selectFolder({{ $folder->id }})"
                            class="flex cursor-pointer items-center gap-2.5"
                            style="padding:9px 12px;border-radius:16px;font-size:14px;background:{{ $isActive ? '#e9f8ff' : 'transparent' }};color:{{ $isActive ? '#004961' : '#201e1d' }};font-weight:{{ $isActive ? 600 : 400 }}"
                        >
                            <x-filament::icon :icon="$folderIcons[$folder->key] ?? 'heroicon-o-folder'" class="h-4 w-4 shrink-0" />
                            <span class="flex-1 truncate">{{ $folder->name }}</span>
                            @if ($folder->messages_count > 0)
                                <span style="font-size:12px;font-weight:600">{{ $folder->messages_count }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-col gap-1.5">
                    <div class="flex items-center justify-between" style="padding:0 12px">
                        <span style="font-size:10px;letter-spacing:0.1em;text-transform:uppercase;color:rgba(32,30,29,0.55)">Címkék</span>
                        <button type="button" wire:click="toggleAddLabel" style="background:none;border:none;cursor:pointer;color:#0088b0;padding:2px" aria-label="Új címke">
                            <x-filament::icon icon="heroicon-o-plus" class="h-3.5 w-3.5" />
                        </button>
                    </div>

                    @foreach ($this->getLabels() as $label)
                        <div class="group flex items-center gap-2.5" style="padding:6px 12px;border-radius:14px;font-size:13px">
                            <x-filament::icon icon="heroicon-o-tag" class="h-3 w-3 shrink-0" />
                            <span class="flex-1 truncate">{{ $label->name }}</span>
                            <button type="button" wire:click="removeLabel({{ $label->id }})" class="shrink-0 opacity-0 transition-opacity group-hover:opacity-100" style="background:none;border:none;cursor:pointer;color:rgba(32,30,29,0.4);padding:2px">
                                <x-filament::icon icon="heroicon-o-x-mark" class="h-2.5 w-2.5" />
                            </button>
                        </div>
                    @endforeach

                    @if ($showNewLabel)
                        <div class="flex gap-1.5" style="padding:0 12px">
                            <input type="text" wire:model="newLabelName" placeholder="Címke neve" class="min-w-0 flex-1" style="font-size:12px;padding:5px 8px;border:1px solid rgba(32,30,29,0.16);border-radius:2px;background:#eae9e9;color:#201e1d" />
                            <button type="button" wire:click="addLabel" style="font-size:12px;padding:5px 10px;background:#0088b0;color:#f3f2f2;border:none;border-radius:2px;cursor:pointer">OK</button>
                        </div>
                        @error('newLabelName') <p class="text-xs text-danger-600" style="padding:0 12px">{{ $message }}</p> @enderror
                    @endif
                </div>

                <div class="flex-1"></div>

                <div wire:click="openSettings" class="flex cursor-pointer items-center gap-2.5" style="padding:9px 12px;border-radius:16px;color:rgba(32,30,29,0.7)">
                    <x-filament::icon icon="heroicon-o-adjustments-horizontal" class="h-4 w-4" />
                    <span style="font-size:14px">Beállítások</span>
                </div>
            </div>

            {{-- Tartalom: lista VAGY részletnézet, sosem mindkettő egyszerre (mint a Gmailben) --}}
            <div class="flex min-h-0 min-w-0 flex-1 flex-col">
                @if ($isListView)
                    <div class="flex min-h-0 flex-1 flex-col overflow-y-auto" style="padding:0 16px 20px">
                        @if (count($selected) > 0)
                            <div class="flex flex-none flex-wrap items-center gap-2 lg:gap-3.5" style="padding:10px 4px">
                                <input type="checkbox" wire:click="toggleSelectAll" @checked($selectAllChecked) class="h-4 w-4" style="accent-color:#0088b0" />
                                <span style="font-size:13px;color:rgba(32,30,29,0.6)">{{ count($selected) }} kijelölve</span>
                                <button type="button" wire:click="bulkMarkRead" class="flex items-center gap-1.5" style="background:none;border:none;cursor:pointer;color:#201e1d;font-size:13px;padding:6px 8px;border-radius:2px">
                                    <x-filament::icon icon="heroicon-o-check" class="h-3.5 w-3.5" />
                                    <span class="hidden sm:inline">Olvasottnak jelöl</span>
                                </button>
                                <button type="button" wire:click="bulkStar" class="flex items-center gap-1.5" style="background:none;border:none;cursor:pointer;color:#201e1d;font-size:13px;padding:6px 8px;border-radius:2px">
                                    <x-filament::icon icon="heroicon-o-star" class="h-3.5 w-3.5" />
                                    <span class="hidden sm:inline">Csillagozás</span>
                                </button>
                                <button type="button" wire:click="bulkTrash" class="flex items-center gap-1.5" style="background:none;border:none;cursor:pointer;color:#aa0b56;font-size:13px;padding:6px 8px;border-radius:2px">
                                    <x-filament::icon icon="heroicon-o-trash" class="h-3.5 w-3.5" />
                                    <span class="hidden sm:inline">Törlés</span>
                                </button>
                            </div>
                        @else
                            <div class="flex flex-none items-center gap-3.5" style="padding:10px 4px">
                                <input type="checkbox" wire:click="toggleSelectAll" @checked($selectAllChecked) class="h-4 w-4" style="accent-color:#0088b0" />
                                <h2 style="font-size:22px;margin:0">{{ $this->getCurrentTitle() }}</h2>
                            </div>
                        @endif

                        @forelse ($messages as $message)
                            <div
                                wire:click="selectMessage({{ $message->id }})"
                                wire:key="message-{{ $message->id }}"
                                class="flex cursor-pointer items-center gap-2 sm:gap-3.5"
                                style="padding:11px 4px;border-bottom:1px solid rgba(32,30,29,0.08);background:{{ in_array($message->id, $selected) ? '#eae9e9' : 'transparent' }}"
                            >
                                <input
                                    type="checkbox"
                                    wire:click.stop="toggleSelect({{ $message->id }})"
                                    @checked(in_array($message->id, $selected))
                                    class="h-4 w-4 shrink-0"
                                    style="accent-color:#0088b0"
                                />
                                <button type="button" wire:click.stop="toggleStar({{ $message->id }})" class="shrink-0" style="background:none;border:none;cursor:pointer;padding:2px;color: {{ $message->starred ? '#0088b0' : 'rgba(32,30,29,0.45)' }}">
                                    <x-filament::icon :icon="$message->starred ? 'heroicon-s-star' : 'heroicon-o-star'" class="h-4 w-4" />
                                </button>
                                <span class="w-[86px] shrink-0 truncate sm:w-[150px]" style="font-size:14px;font-weight:{{ $message->status === 'unread' ? 600 : 400 }}">
                                    {{ $message->direction === 'inbound' ? ($message->from_name ?: $message->from_email) : 'Címzett: '.($message->to[0] ?? '') }}
                                </span>
                                <div class="flex min-w-0 flex-1 items-baseline gap-2">
                                    <span class="shrink-0 truncate" style="font-size:14px;font-weight:{{ $message->status === 'unread' ? 600 : 400 }}">{{ $message->subject }}</span>
                                    <span class="hidden truncate sm:inline" style="font-size:13px;color:rgba(32,30,29,0.5)">— {{ $this->getMessageSnippet($message) }}</span>
                                </div>
                                <span class="hidden sm:contents">
                                    @foreach ($message->labels as $label)
                                        @php($style = $label->chipStyle())
                                        <span class="shrink-0" style="font-size:10px;letter-spacing:0.02em;padding:3px 9px;border-radius:2px;background:{{ $style['bg'] }};color:{{ $style['color'] }}">{{ $label->name }}</span>
                                    @endforeach
                                </span>
                                @if ($message->attachments_count > 0)
                                    <x-filament::icon icon="heroicon-o-paper-clip" class="h-3.5 w-3.5 shrink-0" style="color:rgba(32,30,29,0.5)" />
                                @endif
                                <span class="w-[42px] shrink-0 text-right sm:w-[70px]" style="font-size:12px;color:rgba(32,30,29,0.55)">{{ $message->created_at->format('m.d') }}</span>
                            </div>
                        @empty
                            <div style="padding:60px 4px;text-align:center;color:rgba(32,30,29,0.5);font-style:italic">
                                {{ filled($search) ? 'Nincs találat.' : 'Nincs levél ebben a mappában.' }}
                            </div>
                        @endforelse
                    </div>
                @endif

                @if ($isDetailView)
                    <div class="min-h-0 flex-1 overflow-y-auto px-4 lg:px-10" style="padding-top:8px;padding-bottom:40px">
                        <div class="flex items-center gap-3 lg:gap-4.5" style="padding:10px 0 22px">
                            <button type="button" wire:click="backToMessages" style="background:none;border:none;cursor:pointer;color:#201e1d;padding:4px" aria-label="Vissza a listához">
                                <x-filament::icon icon="heroicon-o-arrow-left" class="h-5 w-5" />
                            </button>
                            <h2 class="flex-1 truncate text-xl lg:text-2xl" style="margin:0">{{ $selectedMessage->subject }}</h2>
                            <button type="button" wire:click="toggleStar({{ $selectedMessage->id }})" style="background:none;border:none;cursor:pointer;padding:4px;color:{{ $selectedMessage->starred ? '#0088b0' : 'rgba(32,30,29,0.45)' }}">
                                <x-filament::icon :icon="$selectedMessage->starred ? 'heroicon-s-star' : 'heroicon-o-star'" class="h-4.5 w-4.5" />
                            </button>
                            <button type="button" wire:click="deleteSelectedMessage" wire:confirm="Biztosan törlöd ezt a levelet?" style="background:none;border:none;cursor:pointer;padding:4px;color:#aa0b56">
                                <x-filament::icon icon="heroicon-o-trash" class="h-4 w-4" />
                            </button>
                        </div>

                        <div class="flex items-start gap-3.5" style="margin-bottom:20px">
                            <span class="flex shrink-0 items-center justify-center rounded-full" style="width:40px;height:40px;background:#e9f8ff;color:#004961;font-size:14px;font-weight:600">
                                {{ mb_strtoupper(mb_substr($selectedMessage->from_name ?: $selectedMessage->from_email, 0, 1)) }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <div class="truncate" style="font-size:15px;font-weight:600">
                                    {{ $selectedMessage->from_name ?: $selectedMessage->from_email }}
                                    <span style="font-weight:400;color:rgba(32,30,29,0.55);font-size:13px">&lt;{{ $selectedMessage->from_email }}&gt;</span>
                                </div>
                                <div style="font-size:12px;color:rgba(32,30,29,0.5)">Címzett: én &middot; {{ $selectedMessage->created_at->format('Y-m-d H:i') }}</div>
                            </div>
                            <div class="relative flex shrink-0 items-center gap-1.5">
                                @foreach ($selectedMessage->labels as $label)
                                    @php($style = $label->chipStyle())
                                    <span class="hidden sm:inline" style="font-size:10px;letter-spacing:0.02em;padding:3px 9px;border-radius:2px;background:{{ $style['bg'] }};color:{{ $style['color'] }}">{{ $label->name }}</span>
                                @endforeach
                                <button type="button" wire:click="toggleLabelPicker" class="flex items-center justify-center" style="background:none;border:none;cursor:pointer;color:rgba(32,30,29,0.5);padding:2px" aria-label="Címke hozzáadása">
                                    <x-filament::icon icon="heroicon-o-plus" class="h-3 w-3" />
                                </button>

                                @if ($labelPickerOpen)
                                    @php($assignedIds = $selectedMessage->labels->pluck('id')->all())
                                    <div class="absolute right-0 top-full z-10 mt-1 min-w-[180px]" style="background:#f3f2f2;border-radius:2px;box-shadow:0 3px 10px rgba(0,0,0,0.16)">
                                        @forelse ($this->getLabels() as $label)
                                            <button type="button" wire:click="toggleMessageLabel({{ $label->id }})" class="flex w-full items-center gap-2 text-left" style="padding:9px 14px;font-size:13px;background:none;border:none;cursor:pointer">
                                                <x-filament::icon :icon="in_array($label->id, $assignedIds) ? 'heroicon-s-check-circle' : 'heroicon-o-plus-circle'" class="h-3.5 w-3.5" style="color:{{ in_array($label->id, $assignedIds) ? '#0088b0' : 'rgba(32,30,29,0.3)' }}" />
                                                {{ $label->name }}
                                            </button>
                                        @empty
                                            <p style="padding:9px 14px;font-size:13px;color:rgba(32,30,29,0.5)">Nincs még címke.</p>
                                        @endforelse
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($selectedMessage->attachments->isNotEmpty())
                            <div class="flex flex-wrap gap-2.5" style="margin-bottom:28px">
                                @foreach ($selectedMessage->attachments as $attachment)
                                    <span class="flex items-center gap-2" style="padding:8px 12px;background:#eae9e9;border-radius:2px;font-size:13px">
                                        <x-filament::icon icon="heroicon-o-paper-clip" class="h-3.5 w-3.5" style="color:rgba(32,30,29,0.55)" />
                                        {{ $attachment->filename }}
                                        <span style="color:rgba(32,30,29,0.5)">{{ $this->formatFileSize($attachment->size) }}</span>
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <iframe
                            sandbox=""
                            srcdoc="<style>body{margin:0;font-family:'Source Serif 4',ui-serif,Georgia,serif;font-size:15px;line-height:1.7;color:#201e1d;white-space:pre-wrap}</style>{{ $selectedMessage->body_html ?? nl2br(e($selectedMessage->body_text ?? '')) }}"
                            class="w-full bg-transparent"
                            style="border:none;min-height:16rem;max-width:680px;margin-bottom:24px"
                        ></iframe>

                        <div class="flex gap-2.5">
                            <button type="button" wire:click="openReply" class="flex items-center gap-2" style="background:transparent;border:1px solid rgba(32,30,29,0.16);border-radius:2px;padding:10px 20px;font-weight:600;font-size:14px;color:#201e1d;cursor:pointer">
                                <x-filament::icon icon="heroicon-o-arrow-uturn-left" class="h-3.5 w-3.5" />
                                Válasz
                            </button>
                            <button type="button" wire:click="openForward" class="flex items-center gap-2" style="background:transparent;border:1px solid rgba(32,30,29,0.16);border-radius:2px;padding:10px 20px;font-weight:600;font-size:14px;color:#201e1d;cursor:pointer">
                                <x-filament::icon icon="heroicon-o-arrow-uturn-right" class="h-3.5 w-3.5" />
                                Továbbítás
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Mobil FAB (lebegő "Új levél" gomb, mint a Gmail appban) --}}
        @unless ($composeMode || $sidebarOpen)
            <button
                type="button"
                wire:click="openComposeNew"
                class="fixed z-30 flex items-center justify-center rounded-full lg:hidden"
                style="bottom:20px;right:20px;width:56px;height:56px;background:#0088b0;color:#fff;border:none;box-shadow:0 4px 14px rgba(0,0,0,0.28)"
                aria-label="Új levél"
            >
                <x-filament::icon icon="heroicon-o-pencil-square" class="h-5 w-5" />
            </button>
        @endunless
    </div>

    {{-- Lebegő levélszerkesztő --}}
    @if ($composeMode)
        <div class="mailbox-app fixed bottom-0 z-[70] flex flex-col overflow-visible" style="right:30px;width:440px;max-width:calc(100vw - 2rem);background:#f3f2f2;border-radius:6px 6px 0 0;box-shadow:0 12px 32px rgba(45,43,43,0.22);max-height:80vh;color:#201e1d">
            <div wire:click="toggleComposeMinimize" class="flex cursor-pointer items-center gap-2.5" style="padding:12px 16px;background:#201e1d;color:#f3f2f2;border-radius:6px 6px 0 0">
                <span class="flex-1 truncate" style="font-size:13px;font-weight:600">
                    {{ match ($composeMode) {
                        'reply' => 'Válasz',
                        'forward' => 'Továbbítás',
                        default => 'Új levél',
                    } }}{{ $composeSubject ? ': '.$composeSubject : '' }}
                </span>
                <button type="button" wire:click.stop="toggleComposeMinimize" style="background:none;border:none;cursor:pointer;color:#f3f2f2;padding:4px">
                    <x-filament::icon icon="heroicon-o-minus" class="h-3.5 w-3.5" />
                </button>
                <button type="button" wire:click.stop="discardCompose" style="background:none;border:none;cursor:pointer;color:#f3f2f2;padding:4px">
                    <x-filament::icon icon="heroicon-o-x-mark" class="h-3.5 w-3.5" />
                </button>
            </div>

            @if (! $composeMinimized)
                <div class="flex flex-col overflow-y-auto">
                    <div class="relative flex flex-wrap items-center gap-1.5" style="padding:10px 16px;border-bottom:1px solid rgba(32,30,29,0.1)">
                        <span style="font-size:12px;color:rgba(32,30,29,0.5)">Címzett:</span>
                        @foreach ($composeTo as $index => $recipient)
                            <span class="flex items-center gap-1.5 rounded-full" style="font-size:12px;background:#eae9e9;padding:3px 8px">
                                {{ $recipient['name'] ?: $recipient['email'] }}
                                <button type="button" wire:click="removeRecipient({{ $index }})" style="background:none;border:none;cursor:pointer;color:rgba(32,30,29,0.5);padding:0;font-size:12px">×</button>
                            </span>
                        @endforeach
                        <input
                            type="text"
                            wire:model.live="composeToInput"
                            wire:keydown.enter.prevent="addTypedRecipient"
                            wire:keydown.comma.prevent="addTypedRecipient"
                            placeholder="név vagy e-mail"
                            class="min-w-[80px] flex-1"
                            style="border:none;background:none;font-size:13px;padding:4px"
                        />

                        @if ($composeToInput !== '' && count($contactMatches) > 0)
                            <div class="absolute left-4 right-4 top-full z-10 max-h-40 overflow-y-auto" style="background:#f3f2f2;box-shadow:0 3px 10px rgba(0,0,0,0.16);border-radius:2px">
                                @foreach ($contactMatches as $contact)
                                    <button type="button" wire:click="pickContact('{{ $contact['email'] }}', @js($contact['name']))" class="flex w-full flex-col items-start text-left" style="padding:9px 14px;font-size:13px;background:none;border:none;cursor:pointer">
                                        <span>{{ $contact['name'] }}</span>
                                        <span style="font-size:11px;color:rgba(32,30,29,0.5)">{{ $contact['email'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @error('composeToInput') <p class="text-xs text-danger-600" style="padding:6px 16px 0">{{ $message }}</p> @enderror

                    <input
                        type="text"
                        wire:model="composeSubject"
                        placeholder="Tárgy"
                        style="border:none;background:none;padding:12px 16px;font-size:14px;font-weight:600;border-bottom:1px solid rgba(32,30,29,0.1)"
                    />
                    @error('composeSubject') <p class="text-xs text-danger-600" style="padding:0 16px">{{ $message }}</p> @enderror

                    <textarea
                        wire:model="composeBody"
                        placeholder="Írja meg a levelet…"
                        rows="9"
                        style="border:none;background:none;padding:14px 16px;font-size:14px;line-height:1.6;min-height:200px;resize:vertical"
                    ></textarea>
                    @error('composeBody') <p class="text-xs text-danger-600" style="padding:0 16px">{{ $message }}</p> @enderror

                    @if (count($composeAttachmentFiles) > 0)
                        <div class="flex flex-wrap gap-2" style="padding:0 16px 10px">
                            @foreach ($composeAttachmentFiles as $index => $file)
                                <span class="flex items-center gap-1.5" style="font-size:12px;background:#eae9e9;padding:5px 9px;border-radius:2px">
                                    {{ $file['filename'] }}
                                    <span style="color:rgba(32,30,29,0.5)">{{ $this->formatFileSize($file['size']) }}</span>
                                    <button type="button" wire:click="removeComposeAttachment({{ $index }})" style="background:none;border:none;cursor:pointer;color:rgba(32,30,29,0.5)">×</button>
                                </span>
                            @endforeach
                        </div>
                    @endif
                    @error('composeAttachments.*') <p class="text-xs text-danger-600" style="padding:0 16px 6px">{{ $message }}</p> @enderror

                    <div class="relative flex items-center gap-4" style="padding:12px 16px;border-top:1px solid rgba(32,30,29,0.1)">
                        <button type="button" wire:click="sendCompose" wire:loading.attr="disabled" wire:target="sendCompose" class="disabled:opacity-60" style="background:#0088b0;color:#f3f2f2;border:none;border-radius:18px;padding:9px 22px;font-weight:600;font-size:13px;cursor:pointer">Küldés</button>

                        <button type="button" wire:click="toggleTemplateMenu" style="background:none;border:none;cursor:pointer;color:rgba(32,30,29,0.6);padding:4px" aria-label="Sablon beszúrása">
                            <x-filament::icon icon="heroicon-o-document-text" class="h-4 w-4" />
                        </button>

                        <label class="flex cursor-pointer items-center" style="color:rgba(32,30,29,0.6);padding:4px" aria-label="Melléklet">
                            <input type="file" multiple wire:model="composeAttachments" class="hidden" />
                            <x-filament::icon icon="heroicon-o-paper-clip" class="h-4 w-4" />
                        </label>

                        <div class="flex-1"></div>

                        <button type="button" wire:click="discardCompose" style="background:none;border:none;cursor:pointer;color:rgba(32,30,29,0.5);padding:4px" aria-label="Elvetés">
                            <x-filament::icon icon="heroicon-o-trash" class="h-3.5 w-3.5" />
                        </button>

                        @if ($templateMenuOpen)
                            <div class="absolute bottom-full z-10 mb-1 min-w-[220px]" style="left:52px;background:#f3f2f2;box-shadow:0 3px 10px rgba(0,0,0,0.16);border-radius:2px">
                                @forelse ($templates as $template)
                                    <button type="button" wire:click="insertTemplate({{ $template->id }})" class="block w-full text-left" style="padding:10px 14px;font-size:13px;background:none;border:none;cursor:pointer">
                                        {{ $template->name }}
                                    </button>
                                @empty
                                    <p style="padding:10px 14px;font-size:13px;color:rgba(32,30,29,0.5)">Nincs sablon.</p>
                                @endforelse
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- Beállítások --}}
    @if ($settingsOpen)
        <div class="mailbox-app fixed inset-0 z-[80] grid place-items-center p-5" style="background:rgba(45,43,43,0.5)" wire:click.self="closeSettings">
            <div class="flex w-full overflow-hidden" style="max-width:680px;background:#eae9e9;border-radius:4px;box-shadow:0 12px 32px rgba(45,43,43,0.22);max-height:82vh;color:#201e1d">
                <div class="flex w-[190px] shrink-0 flex-col gap-0.5" style="padding:20px 10px;background:#f3f2f2">
                    <div wire:click="tabSignature" class="cursor-pointer" style="padding:10px 14px;border-radius:16px;font-size:14px;background:{{ $settingsTab === 'signature' ? '#e9f8ff' : 'transparent' }};color:{{ $settingsTab === 'signature' ? '#004961' : '#201e1d' }};font-weight:{{ $settingsTab === 'signature' ? 600 : 400 }}">Aláírás</div>
                    <div wire:click="tabAutoReply" class="cursor-pointer" style="padding:10px 14px;border-radius:16px;font-size:14px;background:{{ $settingsTab === 'autoreply' ? '#e9f8ff' : 'transparent' }};color:{{ $settingsTab === 'autoreply' ? '#004961' : '#201e1d' }};font-weight:{{ $settingsTab === 'autoreply' ? 600 : 400 }}">Automatikus válasz</div>
                    <div wire:click="tabTemplates" class="cursor-pointer" style="padding:10px 14px;border-radius:16px;font-size:14px;background:{{ $settingsTab === 'templates' ? '#e9f8ff' : 'transparent' }};color:{{ $settingsTab === 'templates' ? '#004961' : '#201e1d' }};font-weight:{{ $settingsTab === 'templates' ? 600 : 400 }}">Sablonok</div>
                </div>

                <div class="flex-1 overflow-y-auto" style="padding:26px 28px">
                    @if ($settingsTab === 'signature')
                        <h3 style="margin:0 0 14px">Aláírás</h3>
                        <div class="prose prose-sm max-w-none" style="padding:10px 12px;font-size:14px;border:1px solid rgba(32,30,29,0.16);border-radius:2px;background:#f3f2f2">
                            {!! $this->getEmailSignature() ?: '<p style="color:rgba(32,30,29,0.5)">Nincs beállítva aláírás.</p>' !!}
                        </div>
                        <p class="mt-2 text-xs" style="color:rgba(32,30,29,0.5)">
                            A szöveg szerkesztése: <a href="{{ \App\Filament\Pages\SiteSettings::getUrl() }}" style="color:#0088b0">Beállítások → Email aláírás</a>.
                        </p>
                        <label class="flex cursor-pointer items-center gap-2" style="margin-top:14px;font-size:13px">
                            <input type="checkbox" wire:model.live="signatureAuto" class="h-4 w-4" style="accent-color:#0088b0" />
                            Automatikus csatolás minden új levélhez
                        </label>
                    @elseif ($settingsTab === 'autoreply')
                        <h3 style="margin:0 0 14px">Automatikus válasz</h3>
                        <label class="flex cursor-pointer items-center gap-2" style="font-size:13px;margin-bottom:16px">
                            <input type="checkbox" wire:model.live="autoReplyEnabled" class="h-4 w-4" style="accent-color:#0088b0" />
                            Automatikus válasz bekapcsolása
                        </label>
                        <div class="flex gap-3.5" style="margin-bottom:14px;opacity:{{ $autoReplyEnabled ? 1 : 0.45 }}">
                            <div class="flex-1">
                                <label class="block" style="font-size:12px;margin-bottom:5px;color:rgba(32,30,29,0.7)">Kezdete</label>
                                <input type="date" wire:model.live="autoReplyStart" :disabled="! $autoReplyEnabled" class="w-full" style="padding:7px 10px;font-size:13px;border:1px solid rgba(32,30,29,0.16);border-radius:2px;background:#f3f2f2" />
                            </div>
                            <div class="flex-1">
                                <label class="block" style="font-size:12px;margin-bottom:5px;color:rgba(32,30,29,0.7)">Vége</label>
                                <input type="date" wire:model.live="autoReplyEnd" :disabled="! $autoReplyEnabled" class="w-full" style="padding:7px 10px;font-size:13px;border:1px solid rgba(32,30,29,0.16);border-radius:2px;background:#f3f2f2" />
                            </div>
                        </div>
                        <textarea wire:model.live="autoReplyMessage" rows="5" :disabled="! $autoReplyEnabled" placeholder="Köszönjük megkeresését! Jelenleg szabadságon vagyunk…" class="w-full" style="padding:10px 12px;font-size:14px;border:1px solid rgba(32,30,29,0.16);border-radius:2px;background:#f3f2f2;resize:vertical;opacity:{{ $autoReplyEnabled ? 1 : 0.45 }}"></textarea>
                    @else
                        <h3 style="margin:0 0 14px">Sablonok</h3>
                        <div>
                            @forelse ($templates as $template)
                                <div class="flex items-start gap-2.5" style="padding:10px 0;border-bottom:1px solid rgba(32,30,29,0.1)">
                                    <div class="flex-1">
                                        <div style="font-size:14px;font-weight:600">{{ $template->name }}</div>
                                        <div class="whitespace-pre-wrap" style="font-size:12px;color:rgba(32,30,29,0.55)">{{ \Illuminate\Support\Str::limit($template->body, 90) }}</div>
                                    </div>
                                    <button type="button" wire:click="deleteTemplate({{ $template->id }})" style="background:none;border:none;cursor:pointer;color:#aa0b56;padding:4px">
                                        <x-filament::icon icon="heroicon-o-trash" class="h-3.5 w-3.5" />
                                    </button>
                                </div>
                            @empty
                                <p style="font-size:13px;color:rgba(32,30,29,0.5)">Nincs még sablon.</p>
                            @endforelse
                        </div>
                        <div style="margin-top:16px">
                            <input type="text" wire:model="newTemplateName" placeholder="Sablon neve" class="w-full" style="padding:8px 10px;font-size:13px;border:1px solid rgba(32,30,29,0.16);border-radius:2px;background:#f3f2f2;margin-bottom:8px" />
                            @error('newTemplateName') <p class="text-xs text-danger-600">{{ $message }}</p> @enderror
                            <textarea wire:model="newTemplateBody" rows="3" placeholder="Sablon szövege" class="w-full" style="padding:8px 10px;font-size:13px;border:1px solid rgba(32,30,29,0.16);border-radius:2px;background:#f3f2f2;resize:vertical;margin-bottom:8px"></textarea>
                            @error('newTemplateBody') <p class="text-xs text-danger-600">{{ $message }}</p> @enderror
                            <button type="button" wire:click="addTemplate" style="background:#0088b0;color:#f3f2f2;border:none;border-radius:2px;padding:8px 16px;font-weight:600;font-size:13px;cursor:pointer">Sablon hozzáadása</button>
                        </div>
                    @endif

                    <div class="flex justify-end" style="margin-top:24px">
                        <button type="button" wire:click="closeSettings" style="background:transparent;border:1px solid rgba(32,30,29,0.16);border-radius:2px;padding:9px 20px;font-weight:600;font-size:13px;cursor:pointer">Bezárás</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>
