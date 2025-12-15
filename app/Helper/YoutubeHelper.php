<?php

namespace App\Helper;

use DateInterval;
use Illuminate\Support\Facades\Http;

class YoutubeHelper
{
    public static function extractId($url)
    {
        // Handle various YouTube URL formats
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
        if (preg_match($pattern, $url, $match)) {
            return $match[1];
        }
        // If it's already an ID (11 chars)
        if (strlen($url) === 11) {
            return $url;
        }

        return null;
    }

    public static function getDuration($videoId)
    {
        try {
            // Attempt to scrape the duration from the video page
            // This is a fallback if no API key is available
            $url = 'https://www.youtube.com/watch?v='.$videoId;

            // Use a user agent to avoid being blocked
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            ])->get($url);

            if ($response->successful()) {
                $body = $response->body();

                // Look for duration in meta tag
                // <meta itemprop="duration" content="PT4M13S">
                if (preg_match('/itemprop="duration" content="([^"]+)"/', $body, $matches)) {
                    $durationIso = $matches[1];

                    return self::convertIsoToMinutes($durationIso);
                }

                // Alternative: Look for "lengthSeconds":"253"
                if (preg_match('/"lengthSeconds":"(\d+)"/', $body, $matches)) {
                    $seconds = (int) $matches[1];

                    return round($seconds / 60);
                }
            }
        } catch (\Exception $e) {
            // Log error or ignore
        }

        return 0;
    }

    private static function convertIsoToMinutes($isoDuration)
    {
        try {
            $interval = new DateInterval($isoDuration);
            $minutes = ($interval->h * 60) + $interval->i + ($interval->s / 60);

            return round($minutes);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
