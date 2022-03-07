<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class NotificationCT extends Controller
{
    public function sendNotification(Request $request) {
        $fcm_data['to'] = $request->to;

        if (isset($request['data'])) {
            $fcm_data['data'] = $request->data;
        } else {
            $body['title'] = $request->title;
            $body['body'] = $request->body;
            $fcm_data['data'] = $body;
        }

        $response = Http::withHeaders([
            'Authorization' => 'key=AAAAGG77bCs:APA91bFCbOiqL8wHVoKAw5fmEbJ8C0XSZUDjddlkdbGToV2tyTpiC36Sf_siPSGtHyGUiXeFzjg0G1nEjRCZ1XYUPkv1S9M1mhHXmHMrYtB_MQt51c-Yu__QUSpw6QsqCfvH1OqVGHTv',
            'Content-Type' => 'application/json'
        ])->post('https://fcm.googleapis.com/fcm/send', $fcm_data);

        if (isset($request['data'])) {
            return response()->json([ 'success' => true ]);
        } else {
            Alert::success('Berhasil', 'Anda berhasil mengirimkan notifikasi');
            return redirect()->to('/admin/notification');
        }
    }

    public function index() {
        $model['base_url'] = '/admin/notification/';
        $model['firebase_url'] = '/admin/notification/send';
        return view('admin.notification.index', compact('model'));
    }
}
