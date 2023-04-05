<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Controllers\DateTimeZone;
use App\Jobs\ProcessAppFormJob;
use App\Models\AppForm;
use App\Models\AppFormSession;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Console\Kernel;
use App\Jobs\ProcessAppForm;
use App\Jobs\TerminateAppFormSessionJob;
use Carbon\Carbon;
use Pheanstalk\Pheanstalk;

class AppFormController extends Controller
{
    /**
     * Show the form to create a new application.
     */
    public function create(): View//RedirectResponse
    {
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        $user = auth()->user();

        if($user != null){
            if($lastAppFormSession == null){
                echo('null');
                $newAppFormSession = new AppFormSession;
    
                $newAppFormSession->user_id = $user->id;
                $newAppFormSession->user_name = $user->name;
                $newAppFormSession->is_alive = true;
    
                $newAppFormSession->save();
            }else{
                echo('not_null');

                if($lastAppFormSession->is_alive == false){
                    $newAppFormSession = new AppFormSession;
    
                    $newAppFormSession->user_id = $user->id;
                    $newAppFormSession->user_name = $user->name;
                    $newAppFormSession->is_alive = true;
    
                    $newAppFormSession->save();
                }
            }
        }
       
        $newAppFormSession = new AppFormSession;
    
                    $newAppFormSession->user_id = $user->id;
                    $newAppFormSession->user_name = $user->name;
                    $newAppFormSession->is_alive = true;
    
                    $newAppFormSession->save();
                    
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();

         //$details['id'] = $lastAppFormSession->id;
        //  $start = Carbon::now();
        //  $job = new TerminateAppFormSessionJob($details);
        //  $job->delay($start->addSeconds(5));
        //  dispatch($job, $details);
        $details['to'] = 'harsukh21@gmail.com';
        $details['name'] = 'Receiver Name';
        $details['subject'] = 'Hello Laravelcode';
        $details['message'] = 'Here goes all message body.';

        TerminateAppFormSessionJob::dispatch('govno');
       
        
         //TerminateAppFormSessionJob::dispatch($details);

        //$appFormSession = DB::table('app_form_sessions')->where('id', $lastAppFormSession->id)->first();;
        //var_dump($lastAppFormSession);
        //var_dump($appFormSession);
        //echo($lastAppFormSession->id);
        //     $users = DB::table('users')->get();
 
    //     foreach ($users as $user) {
    //     echo $user->name;
    //     echo($users[0]->name);
    // }
    
        //$array = json_decode($appFormSession, true);
        //var_dump($appFormSession->id);
        //\Log::info(json_encode($array->all()));
        //info($appFormSession->id);
        
         

        $bryh = 'bruh';

        //$job = (new SendWelcomeEmailJob())
        //->delay(Carbon::now()->addMinutes(10));
        //dispatch($job);
        //$dateTime = Carbon::now();
        
        //TerminateAppFormSession::dispatch()->delay($dateTime->addMinutes(1))->onConnection('database');;

        //TerminateAppFormSession::dispatch()->onConnection('redis');
        //\Artisan::call('queue:listen');
       
        //$sch = new Schedule(\DateTimeZone::EUROPE);
        //\Artisan::call('schedule:run');
        //\Artisan::schedule($sch);

        //\Artisan::call('app:terminate-app-form-session');

        //$job = (new TerminateAppFormSession())->delay(Carbon::now()->addMinutes(2));
        //dispatch($job);

        //dispatch(new ProcessAppFormJob($bryh));

        //dd()
        // $isSessionOccupied = true;
        // $isSessionOccupied = false; 
      
        // if($isSessionOccupied){
        //     $returnMsg = 'form-filling-occupied';
        //     return redirect()->back()->with('status', $returnMsg);
        // }else{
        //     $returnMsg = 'form-filling-free';
        //     return Redirect::route('applications.edit')->with('status', 'bruh');
        // }
        //return view('post.create');
            
        
        

        return view('app-form.create');
    }
 
    public function OccupyAppFormSession($id)
    {
        $details['id'] = 'Md Obydullah';
        $start = Carbon::now();
        $job = new TerminateAppFormSessionJob($details);
        $job->delay($start->addSeconds(5));
        
        dispatch($job);
    }
    private function ExtendAppFormSession()
    {
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        $user = auth()->user();

        if($lastAppFormSession->is_alive == true and $lastAppFormSession->user_id == $user->id){
            //$lastAppFormSession->was_extended = true;
        }
    }
    /**
     * Store a new application.
     */
    public function store(Request $request): RedirectResponse
    {
        \Log::info(json_encode($request->all()));

        $rules = [
            'app_name' => 'required|string|min:3|max:30',
            'description' => 'required|string|min:3|max:200',
            'type' => 'required|in:1,2,3',
            'place' => 'nullable|string|min:3|max:50',
        ];
 
        $validator = $request->validateWithBag('appform', $rules);
        
        $newAppForm = new AppForm;

        $newAppForm->app_name = $request->app_name;
        $newAppForm->description = $request->description;
        $newAppForm->type = $request->type;
        $newAppForm->place = $request->place;

        $newAppForm->save();

        return Redirect::route('dashboard')->withErrors($validator, 'appform');
    }
}
