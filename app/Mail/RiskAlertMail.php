<?php

namespace App\Mail;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RiskAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $student,
        public Classroom $classroom,
        public string $reason
    ) {
    }

    public function build(): self
    {
        return $this
            ->subject('Peringatan Progress Siswa - ClassTrack')
            ->view('emails.risk-alert');
    }
}
