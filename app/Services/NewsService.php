<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('NEWS_API_KEY', 'a31c0c0912e744f98c6f4ca8a7c7d318');
    }

    public function getTopHeadlines($country = 'us', $limit = 1)
    {
        try {
            $response = Http::get('https://newsapi.org/v2/top-headlines', [
                'country' => $country,
                'apiKey' => $this->apiKey,
            ]);

            if ($response->successful()) {
                return $response->json()['articles'] ?? [];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
