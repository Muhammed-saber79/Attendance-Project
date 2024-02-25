<?php


namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendReplyEmail ($data)
    {
        try {
            $view = 'Mail.' . $data['type'];
            if (isset($data['pdfPath'])) {
                Mail::send($view, ['data' => $data], function ($mail) use ($data) {
                    $mail->to($data['email'])
                        ->subject(@$data['title']);

                    $mail->attach($data['pdfPath'], [
                        'as' => 'attachment.pdf',
                        'mime' => 'application/pdf',
                    ]);
                });
            } else {
                Mail::send($view, ['data' => $data], function ($mail) use ($data) {
                    $mail->to($data['email'])
                        ->subject(@$data['title']);
                });
            }

            return ['status' => true];
        } catch (\Exception $e) {
            return ['status' => false, 'error' => $e->getMessage()];
        }
    }
}
