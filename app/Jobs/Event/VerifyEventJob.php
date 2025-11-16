<?php

namespace App\Jobs\Event;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class VerifyEventJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $toEmail,
        public string $toName,
        public string $eventId,
        public string $eventName,
        public string $eventTitle,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = [
            "title" => "Verify Event",
            "toEmail" => $this->toEmail,
            "toName" => $this->toName,
            "eventId" => $this->eventId,
            "eventName" => $this->eventName,
            "eventTitle" => $this->eventTitle,
            "url" => route('approvals.event.show', $this->eventId),
        ];
        Mail::send('emails.event.verify', $data, function ($message) use ($data) {
            $message->to($data["toEmail"])
                ->subject($data["title"]);
        });
    }
}
