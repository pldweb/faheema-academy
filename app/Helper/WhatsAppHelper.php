<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppHelper
{
    // Gowa pribadi
    public static function sendGowa($target, $message)
    {
        $formattedTarget = self::formatPhoneNumber($target);
        $url = env('API_WA_GOWA').'/send/message';

        $message .= "\n";
        $message .= '_Dikirim dari '.env('APP_URL').'_';

        $response = Http::post($url, [
            'phone' => $formattedTarget,
            'message' => $message,
            'is_forwarded' => false,
            'duration' => 0,
        ]);

        Log::info('Response GOWA: ', $response->json());

        return $response->successful();
    }

    // Pushwa.com
    public static function sendNotification($target, $message)
    {
        $token = env('PUSHWA_TOKEN') ?? '8SFPdJDflXk3HjIeCEGNoYAVZMyw4i2cTgnpU7tR';

        $formattedTarget = self::formatPhoneNumber($target);

        if (! $formattedTarget) {
            Log::warning("Gagal kirim WA: Nomor HP tidak valid ($target)");

            return false;
        }

        $data = [
            'token' => $token,
            'target' => '+6295365441554',
            'type' => 'text',
            'delay' => '1',
            'message' => $message,
        ];

        try {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://dash.pushwa.com/api/kirimPesan',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0, // Timeout 30 detik
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            //            if ($err) {
            //                Log::error("WhatsApp CURL Error: " . $err);
            //                return false;
            //            }

            //            Log::info("PushWA Response untuk $formattedTarget: " . $response);

            //            $jsonResp = json_decode($response, true);

            //            if (isset($jsonResp['status']) && $jsonResp['status'] == false) {
            //                Log::error("Gagal dari API WA: " . $response);
            //                return false;
            //            }

            return $response;

        } catch (\Exception $e) {
            Log::error('Gagal kirim WA: '.$e->getMessage());

            return false;
        }
    }

    public static function formatPhoneNumber($number)
    {
        $number = preg_replace('/\D/', '', $number);

        // Nomor kurang dari 9 digit → invalid
        if (strlen($number) < 9) {
            return null;
        }

        // Case 1: 08xxxx → ubah jadi 628xxxx
        if (substr($number, 0, 2) === '08') {
            $number = '62'.substr($number, 1);
        }

        // Case 2: 8xxxx → ubah jadi 628xxxx
        if (substr($number, 0, 1) === '8') {
            $number = '62'.$number;
        }

        // Jika nomor tanpa 0/8/62 → paksa jadi format internasional
        if (substr($number, 0, 2) !== '62') {
            $number = '62'.ltrim($number, '0');
        }

        return $number.'@s.whatsapp.net';
    }

    public static function formatNomorHp($number)
    {
        $number = preg_replace('/\D/', '', $number);

        // Nomor kurang dari 9 digit → invalid
        if (strlen($number) < 9) {
            return null;
        }

        // Case 1: 08xxxx → ubah jadi 628xxxx
        if (substr($number, 0, 2) === '08') {
            $number = '62'.substr($number, 1);
        }

        // Case 2: 8xxxx → ubah jadi 628xxxx
        if (substr($number, 0, 1) === '8') {
            $number = '62'.$number;
        }

        // Jika nomor tanpa 0/8/62 → paksa jadi format internasional
        if (substr($number, 0, 2) !== '62') {
            $number = '62'.ltrim($number, '0');
        }

        return $number;
    }
}
