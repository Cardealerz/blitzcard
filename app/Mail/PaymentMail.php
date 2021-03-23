<?php

namespace App\Mail;

use App\Models\PayHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payHistory;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PayHistory $payHistory, $subject)
    {
        $this->payHistory = $payHistory;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('mails.payment_review');
    }
}
