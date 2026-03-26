<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\Subscriber;
use App\Models\Newsletter;
use App\Models\NewsletterLog;
use App\Mail\NewsletterMailable;
use Exception;

class SendNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app::newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a newsletter to active subscribers safely for shared hosting.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $newsletters = Newsletter::where('status', 'scheduled')
            ->where('send_at', '<=', now())
            ->get();

        foreach ($newsletters as $newsletter) {
            $this->sendNewsletter($newsletter);
        }

    }

    private function sendNewsletter($newsletter)
    {
        $chunkSize = 50;
        $delaySeconds = 5;
        $failedCount = 0;
        $totalCount = 0;

        // Check if there are active subscribers
        $activeSubscriberCount = Subscriber::where('is_active', true)->count();
        if ($activeSubscriberCount === 0) {
            $newsletter->update(['status' => 'no_recipients']);
            \Log::info("Newsletter #{$newsletter->id} has no active subscribers. Skipping send.");
            return;
        }

        Subscriber::where('is_active', true)->chunk($chunkSize, function ($subscribers) use ($newsletter, &$failedCount, &$totalCount, $delaySeconds) {
            foreach ($subscribers as $subscriber) {
                $totalCount++;
                $log = NewsletterLog::firstOrCreate(
                    ['subscriber_id' => $subscriber->id, 'newsletter_id' => $newsletter->id],
                    ['status' => 'pending']
                );

                if ($log->status === 'sent') continue;

                try {
                    $unsubscribeUrl = URL::temporarySignedRoute(
                        'subscriber.unsubscribe',
                        now()->addDays(7),
                        ['email' => $subscriber->email]
                    );

                    Mail::to($subscriber->email)->send(new NewsletterMailable($newsletter, $unsubscribeUrl));

                    $log->update([
                        'status' => 'sent',
                        'sent_at' => now()
                    ]);

                } catch (\Exception $e) {
                    $failedCount++;
                    $log->update([
                        'status' => 'failed',
                        'error' => $e->getMessage()
                    ]);
                }
            }
            sleep($delaySeconds);
        });

        $status = $failedCount === 0 ? 'completed' : ($failedCount < $totalCount ? 'sending' : 'failed');
        $newsletter->update(['status' => $status]);
    }
}
