<?php

namespace App\Jobs\Auth;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class VerifyRegistrationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $toEmail,
        public string $toName,
        public string $userName,
        public string $userEmail,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = [
            "title" => "Verify Registration",
            "toEmail" => $this->toEmail,
            "toName" => $this->toName,
            "userName" => $this->userName,
            "userEmail" => $this->userEmail,
            "url" => "https://tbu.id",
        ];
        Mail::send('emails.auth.verify-registration', $data, function ($message) use ($data) {
            $message->to($data["toEmail"])
                ->subject($data["title"]);
        });
    }
}
