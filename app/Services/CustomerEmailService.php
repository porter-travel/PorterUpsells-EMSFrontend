<?php

namespace App\Services;

use App\Jobs\TrackEmailSends;
use App\Models\CustomerEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CustomerEmailService {
    public function setupEmailSchedule($params) {
        foreach ($params['days'] as $email) {
            $customer_email = new CustomerEmail(['booking_id' => $params['booking']->id]);

            if (is_numeric($email)) {
                $customer_email->email_type = 'pre-arrival';
                $customer_email->scheduled_at = Carbon::createFromFormat('Y-m-d', $params['arrival_date'])->subDays($email);
            } else {
                $customer_email->email_type = $email;
                $customer_email->scheduled_at = Carbon::now();
                Mail::to($params['email_address'])->send(new \App\Mail\CustomerEmail($params['hotel'], $params['content']));
                $customer_email->sent_at = Carbon::now();
                TrackEmailSends::dispatch($params['hotel']->id);
            }

            $customer_email->save();
        }
    }
}
