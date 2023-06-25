<?php

namespace App\Action;

use App\Models\Message;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StoreMessageAction implements Action
{
    public function __construct(private string $message, private ?string $colleagueEmail)
    {
    }

    public function handle(): array
    {
        $password = Str::random();

        $message = Message::create([
            'message' => Crypt::encrypt($this->message),
            'colleague_email' => $this->colleagueEmail,
            'password_hash' => Hash::make($password),
        ]);

        return [$message, $password];
    }
}
