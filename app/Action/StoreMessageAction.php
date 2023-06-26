<?php

namespace App\Action;

use App\Models\Message;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Log;
use RuntimeException;

class StoreMessageAction implements Action
{
    public function __construct(private string $message, private ?string $colleagueEmail = null)
    {
    }

    /**
     * @throws RuntimeException
     */
    public function handle(): array
    {
        if (!is_null($this->colleagueEmail) && !$this->validateEmail()) {
            Log::warning('Invalid colleague email given');
            throw new RuntimeException('Invalid colleague email given');
        }

        $password = Str::random();

        $message = Message::create([
            'message' => Crypt::encrypt($this->message),
            'colleague_email' => $this->colleagueEmail,
            'password_hash' => Hash::make($password),
        ]);

        return [$message, $password];
    }

    private function validateEmail(): bool
    {
        $colleagues = (new FetchColleaguesAction())->handle();

        foreach ($colleagues as $colleague) {
            if ($colleague['email'] === $this->colleagueEmail) {
                return true;
            }
        }

        return false;
    }
}
