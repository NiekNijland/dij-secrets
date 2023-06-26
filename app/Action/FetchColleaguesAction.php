<?php

namespace App\Action;

use Exception;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use JsonException;

class FetchColleaguesAction implements Action
{
    public function handle(): array
    {
        try {
            $colleagues = Cache::remember('colleagues', config('colleagues.cache_lifetime'), function () {
                return $this->parseResult($this->callApi());
            });
        } catch (Exception $e) {
            Log::error('Error fetching colleagues from API: ' . $e->getMessage());
            return [];
        }

        return $colleagues;
    }

    /**
     * @throws RuntimeException
     */
    private function callApi(): string
    {
        $response = HTTP::accept('application/json')
            ->get(config('colleagues.api_url'));

        if (!$response->successful()) {
            throw new RuntimeException('Error fetching colleagues API');
        }

        return $response->body();
    }

    /**
     * @throws JsonException
     */
    private function parseResult(string $result): array
    {
        return json_decode(
            $result,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
