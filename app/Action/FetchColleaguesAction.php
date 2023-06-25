<?php

namespace App\Action;

use Illuminate\Support\Facades\Http;
use JsonException;

class FetchColleaguesAction implements Action
{
    /**
     * @throws JsonException
     */
    public function handle(): array
    {
        $response = HTTP::accept('application/json')
            ->get(config('colleagues.api_url'));

        if ($response->successful()) {
            return json_decode($response->body(), true, 512, JSON_THROW_ON_ERROR);
        }

        return [];
    }
}
