<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AppFormSession;

class TerminateAppFormSession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:terminate-app-form-session';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $newAppFormSession = new AppFormSession;
    
        $newAppFormSession->user_id = '231';
        $newAppFormSession->user_name = 'jjuuuuu';
        $newAppFormSession->is_alive = true;

        $newAppFormSession->save();

        info('hello world');
    }
}
