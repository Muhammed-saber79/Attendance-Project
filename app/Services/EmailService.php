<?php


namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendReplyEmail ($data)
    {
        try {
            if ($data['type'] == 'notification') {
                Mail::send('Mail.notification', ['data' => $data], function ($mail) use ($data) {
                    $mail->to($data['email'])
                        ->subject(@$data['title']);
                });
            } else {
                Mail::send('Mail.decision', ['data' => $data], function ($mail) use ($data) {
                    $mail->to($data['email'])
                        ->subject($data['title']);
                });
            }

            return ['status' => true];
        } catch (\Exception $e) {
            return ['status' => false, 'error' => $e->getMessage()];
        }
    }
}
