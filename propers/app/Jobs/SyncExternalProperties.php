<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncExternalProperties implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $externalResponse = Http::get('https://example.com/api/properties');

        if ($externalResponse->successful()) {
            $properties = $externalResponse->json();

            // Call your own internal API endpoint
            $localResponse = Http::post(config('app.url') . '/api/sync-listings', [
                'listings' => $properties
            ]);

            if (!$localResponse->successful()) {
                \Log::error('Failed to sync listings: ' . $localResponse->body());
            }
        } else {
            \Log::error('Failed to fetch external listings: ' . $externalResponse->body());
        }
    }
}
