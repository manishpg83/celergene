<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderInvoice;
use Carbon\Carbon;
use App\Mail\DebtorReminderMail;
use Illuminate\Support\Facades\Mail;

class SendDebtorReminderMail extends Command
{
    protected $signature = 'debtors:remind';

    protected $description = 'Send a reminder email to admin about unpaid invoices';

    public function handle()
    {
        $oneWeekAgo = Carbon::now()->subWeek();

        $debtors = OrderInvoice::with(['customer', 'createdBy', 'order'])
            ->whereHas('order', function ($query) {
                $query->whereHas('payments', function ($q) {
                    $q->where('status', 'pending');
                })->orWhereDoesntHave('payments');
            })
            ->where('created_at', '<=', $oneWeekAgo)
            ->get();

        $debtors->each(function ($invoice) {
            $invoice->overdue_days = (int)Carbon::parse($invoice->created_at)->diffInDays(now());
        });

        $adminEmail = env('ADMIN_EMAIL', 'developer@predsolutions.com');

        if ($debtors->count() > 0) {
            Mail::to($adminEmail)->send(new DebtorReminderMail($debtors));
            $this->info('Reminder email sent successfully.');
        } else {
            $this->info('No overdue invoices found.');
        }
    }
}
