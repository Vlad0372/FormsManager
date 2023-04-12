<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TerminateAppFormSessionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;

    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
        Log::info("bruh construct");
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $appFormSession = DB::table('app_form_sessions')->where('id', $this->details['id'])->first();
        DB::table('app_form_sessions')->where('id', $appFormSession->id)->update(['is_alive' => "5"]);
        if($appFormSession->is_alive == true){
            DB::table('app_form_sessions')->where('id', $appFormSession->id)->update(['is_alive' => "5"]);
        }
        Log::info("terminated. id:".$appFormSession->id);
    }
}
