<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationCT extends Controller
{
    public function sendNotification(Request $request) {
        $fcm_data['to'] = $request->to;
        $fcm_data['data'] = $request->data;

        $response = Http::withHeaders([
            'Authorization' => 'key=AAAAGG77bCs:APA91bFCbOiqL8wHVoKAw5fmEbJ8C0XSZUDjddlkdbGToV2tyTpiC36Sf_siPSGtHyGUiXeFzjg0G1nEjRCZ1XYUPkv1S9M1mhHXmHMrYtB_MQt51c-Yu__QUSpw6QsqCfvH1OqVGHTv',
            'Content-Type' => 'application/json'
        ])->post('https://fcm.googleapis.com/fcm/send', $fcm_data);

        return response()->json([ 'success' => true ]);
      }
}
