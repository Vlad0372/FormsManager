<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\AppForm;
use App\Models\AppFormSession;
use Illuminate\Support\Facades\DB;

class TerminateAppFormSessionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public  $details;
    protected $id;

    public function __construct(string $details)
    {
        //$id = $details['id'];
        //$this->$details = $details;
        //var_dump($details);
        info($details);
        //info(json_encode($details));
        //$this->details = json_encode($details);
        //echo($details['id']);
        //echo($id);
        //$this->$details = $details['id'];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        //info($details);
        //info(json_decode($this->$details));
        //$appFormSession = DB::table('app_form')->where('id', $id);
       // $appFormSession = DB::table('app_form_sessions')->where('id', $id)->first();
        //echo($appFormSession->id);
        //echo($appFormSession->is_alive);
        //info($details);
        // info($appFormSession);
        // if($appFormSession->is_alive == true){
        //     DB::table('app_form_sessions')->where('id', $appFormSession->id)->update(['is_alive' => "0"]);
        // }
    }
}
