<?php

namespace Tests\Feature;

use App\Livewire\QuoteRequestWizard;
use Livewire\Livewire;
use Tests\TestCase;

class QuoteRequestWizardTest extends TestCase
{
    public function test_submission_validates_every_step_even_when_called_directly(): void
    {
        Livewire::test(QuoteRequestWizard::class)
            ->set('gdpr_consent', true)
            ->call('submit')
            ->assertHasErrors([
                'name',
                'email',
                'phone',
                'requested_system',
            ]);
    }
}
