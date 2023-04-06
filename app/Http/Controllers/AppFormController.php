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
use App\Jobs\BruhJob;
use Carbon\Carbon;
class AppFormController extends Controller
{
    public function OccupyAppFormSession($seconds)
    {
        $user = auth()->user();

        $newAppFormSession = new AppFormSession;    
        $newAppFormSession->user_id = $user->id;
        $newAppFormSession->user_name = $user->name;
        $newAppFormSession->is_alive = true;
        $newAppFormSession->save();

        $details['id'] = $newAppFormSession->id;
        $start = Carbon::now();
        $job = new TerminateAppFormSessionJob($details);
        $job->delay($start->addSeconds($seconds));

        dispatch($job);
    }
    private function ExtendAppFormSession($seconds)
    {
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        $user = auth()->user();

        if($lastAppFormSession->user_id == $user->id){
            DB::table('app_form_sessions')->where('id', $lastAppFormSession->id)->update(['is_alive' => "0"]);
        }

        $newAppFormSession = new AppFormSession;    
        $newAppFormSession->user_id = $user->id;
        $newAppFormSession->user_name = $user->name;
        $newAppFormSession->is_alive = true;
        $newAppFormSession->save();
        
        $details['id'] = $newAppFormSession->id;
        $start = Carbon::now();
        $job = new TerminateAppFormSessionJob($details);
        $job->delay($start->addSeconds($seconds));

        dispatch($job);
    }

    /**
    * Display the application form.
    */
    public function edit(): View
    {
        return view('app-form.create');
    }

    /**
    * Display the application form.
    */
    public function create(): RedirectResponse
    {
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        $user = auth()->user();

        if($user != null){
            if($lastAppFormSession == null || $lastAppFormSession->is_alive == false){            
                self::OccupyAppFormSession(40);
                
                //session(['parameter1' => 'bruh']);
                return Redirect::route('app-form.edit')->with('status', 'form-filling-free')
                                                       ->with('minutes', '2');
            }

            if($lastAppFormSession != null and $lastAppFormSession->is_alive == true and $lastAppFormSession->user_id == $user->id){
                //session(['parameter1' => 'bruh']);               
                return Redirect::route('app-form.edit')->with('status', 'form-filling-free')
                                                       ->with('minutes', '2');
            }
        }

        return Redirect::back()->with('status', 'form-filling-occupied');  
    }
 
    
    /**
     * Store a new application.
     */
    public function store(Request $request): RedirectResponse
    {
        //\Log::info(json_encode($request->all()));

        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        $user = auth()->user();

        if($lastAppFormSession->user_id == $user->id and $lastAppFormSession->is_alive){
            DB::table('app_form_sessions')->where('id', $lastAppFormSession->id)->update(['is_alive' => "0"]);
            
            $rules = [
                'app_name' => 'required|string|min:3|max:30',
                'description' => 'required|string|min:3|max:200',
                'type' => 'required|in:1,2,3',
                'place' => 'nullable|string|min:3|max:50',
            ];
     
            $request->validate($rules);
            
            $newAppForm = new AppForm;
    
            $newAppForm->app_name = $request->app_name;
            $newAppForm->description = $request->description;
            $newAppForm->type = $request->type;
            $newAppForm->place = $request->place;
    
            $newAppForm->save();
    
            return Redirect::route('dashboard')->with('status', 'form-sent-successfully');
        }

        return Redirect::route('dashboard');
    }
    public function update(Request $request): RedirectResponse
    {
        //self::ExtendAppFormSession(40);
        //return Redirect::route('dashboard');
        return Redirect::back()->with('minutes', '32');
        //return Redirect::route('app-form.create')->with('status', 'form-updated');
    }
    public function terminate(Request $request): RedirectResponse
    {
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        $user = auth()->user();

        if($lastAppFormSession->user_id == $user->id){
            DB::table('app_form_sessions')->where('id', $lastAppFormSession->id)->update(['is_alive' => "0"]);
        }
        
        return Redirect::route('dashboard')->with('status', 'session-terminated');
    }
}
