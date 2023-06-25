<?php

namespace App\Models;

use App\Traits\HashidsRoutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $message
 * @property string|null $colleague_email
 * @property string $password_hash
 */
class Message extends Model
{
    use HasFactory;
    use HashidsRoutable;

    protected $fillable = [
        'message',
        'colleague_email',
        'password_hash',
    ];

    public function isExpired(): bool
    {
        return $this->created_at->diffInHours(Carbon::now()) > 48;
    }
}
