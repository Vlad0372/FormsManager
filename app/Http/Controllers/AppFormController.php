<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppSessionRequest;
use App\Http\Controllers\DateTimeZone;
use App\Jobs\ProcessAppFormJob;
use App\Models\AppForm;
use App\Models\AppFormSession;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Jobs\TerminateAppFormSessionJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class AppFormController extends Controller
{
    private $sessionSeconds = 40;//120;

    public function GetAppFormSessionSecondsLeft(){
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();

        if($lastAppFormSession != null){
            $currentTime = Carbon::now();
            $appForm_expires_at = new Carbon($lastAppFormSession->expires_at);
            $secondsLeft = $currentTime->diffInSeconds($appForm_expires_at, false);

            return $secondsLeft;
        }   

        return null;
    }
    public function OccupyAppFormSession($seconds)
    {
        $user = auth()->user();
        $currentTime = Carbon::now();

        $newAppFormSession = new AppFormSession;    
        $newAppFormSession->user_id = $user->id;
        $newAppFormSession->user_name = $user->name;
        $newAppFormSession->is_alive = true;
        $newAppFormSession->expires_at = $currentTime->addSeconds($seconds);
        $newAppFormSession->save();
        
        session(['sessionSeconds' => $seconds]);
        //$details['id'] = $newAppFormSession->id;
        //$start = Carbon::now();
        //$job = new TerminateAppFormSessionJob($details);
        //$job->delay($start->addSeconds($seconds));

        //dispatch($job);
    }
    private function ExtendAppFormSession($seconds)
    {
        //self::TerminateAppFormSession();
        //self::OccupyAppFormSession($seconds);
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        $user = auth()->user();
        //Log::info("bruh time extended");
        if($lastAppFormSession->user_id == $user->id){
            DB::table('app_form_sessions')->where('id', $lastAppFormSession->id)->update(['is_alive' => "1"]);
            DB::table('app_form_sessions')->where('id', $lastAppFormSession->id)->update(['expires_at' => Carbon::now()->addSeconds($seconds)]);     
        }
    }
    private function TerminateAppFormSession()
    {
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        $user = auth()->user();

        if($lastAppFormSession->user_id == $user->id){
            DB::table('app_form_sessions')->where('id', $lastAppFormSession->id)->update(['is_alive' => "0"]);
            DB::table('app_form_sessions')->where('id', $lastAppFormSession->id)->update(['expires_at' => Carbon::createFromTimestamp(0)->addDay()]);     
        }
    }
    public function edit(): View
    {
        return view("app-form.edit");
    }
    public function create(): RedirectResponse
    {
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        Log::info("create bruh?");
        //
        // $currentTime = Carbon::now();
        // $appForm_expires_at = new Carbon($lastAppFormSession->expires_at);

        // $secondsLeft = $currentTime->diffInSeconds($appForm_expires_at, false);
       
        // Log::info("current time:". $currentTime);
        // Log::info("seconds left:". $lastAppFormSession->expires_at);
        // Log::info("carb left:". $secondsLeft);
       
        //

        $user = auth()->user();

        if($user != null){
            session(['_old_input.app_name' => '']);
            session(['_old_input.description' => '']);
            session(['_old_input.type' => '3']);
            session(['_old_input.place' => '']);

            if($lastAppFormSession == null){  //$lastAppFormSession->is_alive == false){            
                self::OccupyAppFormSession($this->sessionSeconds);

                //session(['sessionSeconds' => $this->sessionSeconds]);

                return Redirect::route('app-form.edit')->with('status', 'form-filling-free');
            }else{
               
                $secondsLeft = self::GetAppFormSessionSecondsLeft();
                
                if($secondsLeft != null){
                    if($secondsLeft < 1){
                        self::OccupyAppFormSession($this->sessionSeconds);
                
                        return Redirect::route('app-form.edit')->with('status', 'form-filling-free');
                    }

                    if($secondsLeft > 0 and $lastAppFormSession->user_id == $user->id){
                        self::ExtendAppFormSession($this->sessionSeconds);

                        return Redirect::route('app-form.edit')->with('status', 'form-filling-free');
                    }                  
                }
            }

            // if($lastAppFormSession != null and $lastAppFormSession->is_alive == true and $lastAppFormSession->user_id == $user->id){
            //     self::TerminateAppFormSession();
            //     self::OccupyAppFormSession($this->sessionSeconds);

            //     //session(['sessionSeconds' => $this->sessionSeconds]);

            //     return Redirect::route('app-form.edit')->with('status', 'form-filling-free');
            // }
        }

        return Redirect::back()->with('status', 'form-filling-occupied');  
    }
    public function store(StoreAppSessionRequest $request): RedirectResponse
    {
        Log::info("vv?");
        // switch ($request->input('action')) {
        //     case 'sendData':
        //         Log::info("vruh?");
        //         self::ExtendAppFormSession($this->sessionSeconds);

        //         $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        //         $secondsLeft = self::GetAppFormSessionSecondsLeft();
        //         $user = auth()->user();

        //         if($lastAppFormSession->user_id == $user->id and $secondsLeft > 0){//$lastAppFormSession->is_alive){
        //             $request->validateWithBag('appform', $request->rules());

        //             $newAppForm = new AppForm;
    
        //             $newAppForm->app_name = $request->app_name;
        //             $newAppForm->author_id = $user->id;
        //             $newAppForm->author_name = $user->name;
        //             $newAppForm->description = $request->description;
        //             $newAppForm->type = $request->type;
        //             $newAppForm->place = $request->place;
    
        //             $newAppForm->save();
                
        //             self::TerminateAppFormSession();

        //             return Redirect::route('dashboard')->with('status', 'form-sent-successfully');
        //         }

        //         break;
    
        //     case 'extendTime':
        //         Log::info("huh?");
        //         self::ExtendAppFormSession($this->sessionSeconds);

        //         session(['_old_input.app_name' => $request->app_name]);
        //         session(['_old_input.description' => $request->description]);
        //         session(['_old_input.type' => $request->type]);
        //         session(['_old_input.place' => $request->place]);
        //         //session(['sessionSeconds' => $this->sessionSeconds]);
        
        //         return Redirect::back();
        // }
        self::ExtendAppFormSession($this->sessionSeconds); 
        return Redirect::back();   
        return Redirect::route('dashboard');
    }
    public function terminate(Request $request): RedirectResponse
    {
        self::TerminateAppFormSession();
        
        return Redirect::route('dashboard')->with('status', 'session-terminated');
    }
}
