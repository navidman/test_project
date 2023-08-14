<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use Illuminate\Console\Command;

class AcceptIntroducer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'word:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a email to all Job Seeker for Accept Introducer.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        MailController::sendMail('mehrzad.deris@gmail.com', env('APP_URL'), 'مهرزاد دریس', 'تست کرون جاب');
    }
}
