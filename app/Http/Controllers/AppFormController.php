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
    private $sessionSeconds = 15;
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
        self::TerminateAppFormSession();
        self::OccupyAppFormSession($seconds);
    }
    private function TerminateAppFormSession()
    {
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        $user = auth()->user();

        if($lastAppFormSession->user_id == $user->id){
            DB::table('app_form_sessions')->where('id', $lastAppFormSession->id)->update(['is_alive' => "0"]);
        }
    }

    /**
    * Display the application form.
    */
    public function edit(): View
    {
        return view("app-form.create");
    }
    public function create(): RedirectResponse
    {
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        $user = auth()->user();

        if($user != null){
            if($lastAppFormSession == null || $lastAppFormSession->is_alive == false){            
                self::OccupyAppFormSession($this->sessionSeconds);

                session(['sessionSeconds' => $this->sessionSeconds]);

                return Redirect::route('app-form.edit')->with('status', 'form-filling-free');
            }

            if($lastAppFormSession != null and $lastAppFormSession->is_alive == true and $lastAppFormSession->user_id == $user->id){
                self::TerminateAppFormSession();
                self::OccupyAppFormSession($this->sessionSeconds);

                session(['sessionSeconds' => $this->sessionSeconds]);

                return Redirect::route('app-form.edit')->with('status', 'form-filling-free');
            }
        }

        return Redirect::back()->with('status', 'form-filling-occupied');  
    }
    public function store(Request $request): RedirectResponse
    {
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
        self::ExtendAppFormSession($this->sessionSeconds);

        session(['sessionSeconds' => $this->sessionSeconds]);

        return Redirect::back();
    }
    public function terminate(Request $request): RedirectResponse
    {
        self::TerminateAppFormSession();
        
        return Redirect::route('dashboard')->with('status', 'session-terminated');
    }
}
