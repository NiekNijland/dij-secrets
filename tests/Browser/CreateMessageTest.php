<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateMessageTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function testCanLoadCreatePage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('messages.create'))
                ->assertSee('Maak een bericht');
        });
    }

    public function testCanCreateMessage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('messages.create'))
                ->type('@message', 'Hallo dit is een bericht')
                ->click('@encrypt-message')
                ->waitForText('Gelukt! Je bericht is nu opgeslagen.')
                ->assertSee('Gelukt! Je bericht is nu opgeslagen.');
        });
    }

    public function testCannotCreateWithoutMessage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('messages.create'))
                ->type('@message', '')
                ->click('@encrypt-message')
                ->pause(1000)
                ->assertDontSee('Gelukt! Je bericht is nu opgeslagen.');
        });
    }
}
