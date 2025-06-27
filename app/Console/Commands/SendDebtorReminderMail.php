<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderInvoice;
use Carbon\Carbon;
use App\Mail\DebtorReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Attributes\AsScheduled;
use Illuminate\Support\Facades\DB;


#[AsScheduled('weeklyOn(3, "08:00", timezone: "Asia/Singapore")')]
class SendDebtorReminderMail extends Command
{
    protected $signature = 'debtors:remind';

    protected $description = 'Send a reminder email to admin about unpaid invoices';

    public function handle()
    {
        $oneWeekAgo = Carbon::now()->subWeek();

        $debtors = OrderInvoice::with(['customer', 'createdBy', 'order.payments'])
            ->where('invoice_category', '!=', 'shipping')
            ->where('created_at', '<=', $oneWeekAgo) // Add the one week filter
            ->whereHas('order', function ($query) {
                $query->where('total', '>', 0)
                    ->whereNotIn('order_status', ['Paid', 'Cancelled', 'FOC'])
                    ->where('workflow_type', '!=', 'consignment')
                    ->whereRaw('(SELECT COALESCE(SUM(amount), 0) FROM payments WHERE payments.order_id = order_master.order_id) < order_master.total');
            })
            ->get();

        foreach ($debtors as $invoice) {
            $invoice->overdue_days = (int) Carbon::parse($invoice->created_at)->diffInDays(now());

            $invoice->totalPaid = $invoice->order->payments->sum('amount');

            $invoice->pendingAmount = max(0, $invoice->order->total - $invoice->totalPaid);

            $invoice->currencySymbol = DB::table('currency')
                ->where('id', $invoice->order->currency_id)
                ->value('symbol') ?? '';
        }

        $adminEmail = env('ADMIN_EMAIL', 'developer@predsolutions.com');

        if ($debtors->count() > 0) {
            Mail::to($adminEmail)->send(new DebtorReminderMail($debtors));
            Mail::to('manish.bhuvait@gmail.com')->send(new DebtorReminderMail($debtors));
            $this->info('Reminder email sent successfully.');
        } else {
            $this->info('No overdue invoices found.');
        }
    }
}
