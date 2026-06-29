<?php

namespace App\Mail;

use App\Models\UserPackage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public UserPackage $userPackage)
    {
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Your INSPIN Order is Confirmed',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.purchase-confirmation',
            with: ['userPackage' => $this->userPackage],
        );
    }

    public function attachments()
    {
        return [];
    }
}
