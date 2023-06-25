<?php

namespace Tests\Browser;

use App\Action\StoreMessageAction;
use App\Models\Message;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewMessageTest extends DuskTestCase
{
    use DatabaseTruncation;

    public function testCanUnlockMessage(): void
    {
        $messageContent = 'Hallo dit is een donders mooi test bericht';

        [$message, $password] = (new StoreMessageAction($messageContent))->handle();

        $this->browse(function (Browser $browser) use ($message, $password, $messageContent) {
            $browser->visitRoute('messages.show', ['message' => $message])
                    ->assertSee('Vul het wachtwoord in')
                    ->type('@password', $password)
                    ->click('@show-message')
                    ->waitForText($messageContent)
                    ->assertSee($messageContent);
        });
    }

    public function testCannotUnlockWithIncorrectPassword(): void
    {
        $messageContent = 'Hallo dit is een donders mooi test bericht';

        [$message, $password] = (new StoreMessageAction($messageContent))->handle();

        $this->browse(function (Browser $browser) use ($message) {
            $browser->visitRoute('messages.show', ['message' => $message])
                ->assertSee('Vul het wachtwoord in')
                ->type('@password', 'A')
                ->click('@show-message')
                ->waitForText('Verkeerd wachtwoord ingevoerd!')
                ->assertSee('Verkeerd wachtwoord ingevoerd!');
        });
    }

    public function testCanDeleteMessage(): void
    {
        $messageContent = 'Hallo dit is een donders mooi test bericht';

        [$message, $password] = (new StoreMessageAction($messageContent))->handle();

        $this->browse(function (Browser $browser) use ($message, $password, $messageContent) {
            $browser->visitRoute('messages.show', ['message' => $message])
                ->assertSee('Vul het wachtwoord in')
                ->type('@password', $password)
                ->click('@show-message')
                ->waitForText($messageContent)
                ->assertSee($messageContent)
                ->click('@delete-message')
                ->waitForRoute('messages.create');
        });

        $this->assertSame(null, Message::query()->where('id', $message->id)->first());
    }
}
