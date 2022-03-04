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
            'Authorization' => 'key=AAAAbuzphk8:APA91bHu2-MEMfW1UlZwLQRjczUhGQRy9Vuse8un-DJTpW7M5_igZ-L9GpXXU3OV_7AVjbZ9coRTtjpIeXNqUlDhoz0sC5jbV3j5e3urlclhDtDtBQ2DDybYCNHdmR5QRm-7RHFJMB_Y',
            'Content-Type' => 'application/json'
        ])->post('https://fcm.googleapis.com/fcm/send', $fcm_data);

        return response()->json([ 'success' => true ]);
      }
}
