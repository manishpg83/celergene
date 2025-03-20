<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\OrderInvoice;

class DebtorReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $debtors;

    public function __construct($debtors)
    {
        $this->debtors = $debtors;
    }

    public function build()
    {
        return $this->subject('Debtors Reminder: Unpaid Invoices')
                    ->view('admin.emails.debtor-reminder')
                    ->with(['debtors' => $this->debtors]);
    }
}