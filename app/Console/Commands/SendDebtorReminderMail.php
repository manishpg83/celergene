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

        $invoices = OrderInvoice::with(['customer', 'createdBy', 'order.payments'])
            ->where('created_at', '<=', $oneWeekAgo)
            ->get();

        $debtors = $invoices->filter(function ($invoice) {
            $order = $invoice->order;

            if (!$order) {
                return false;
            }

            $totalOrderAmount = $order->total_amount;
            $totalPaid = $order->payments->sum('amount');
            $latestStatus = $order->payments->sortByDesc('payment_date')->first()?->status;

            if (
                $totalPaid < $totalOrderAmount ||
                !in_array($latestStatus, ['fully paid with bank charges', 'fully paid without bank charges'])
            ) {
                $invoice->overdue_days = Carbon::parse($invoice->created_at)->diffInDays(now());
                return true;
            }

            return false;
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
