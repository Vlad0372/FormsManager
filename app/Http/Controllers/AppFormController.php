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
    private $sessionSeconds = 120;
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
    public function edit(): View
    {
        return view("app-form.create");
    }
    public function create(): RedirectResponse
    {
        $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
        $user = auth()->user();

        if($user != null){
            session(['_old_input.app_name' => '']);
            session(['_old_input.description' => '']);
            session(['_old_input.type' => '3']);
            session(['_old_input.place' => '']);

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
        switch ($request->input('action')) {
            case 'sendData':
                $lastAppFormSession = DB::table('app_form_sessions')->latest()->first();
                $user = auth()->user();

                if($lastAppFormSession->user_id == $user->id and $lastAppFormSession->is_alive){
                    $rules = [
                        'app_name' => 'required|string|min:3|max:30',
                        'description' => 'required|string|min:3|max:200',
                        'type' => 'required|in:1,2,3',
                        'place' => 'nullable|string|min:3|max:50',
                    ];
           
                    $request->validateWithBag('appform', $rules);

                    $newAppForm = new AppForm;
    
                    $newAppForm->app_name = $request->app_name;
                    $newAppForm->description = $request->description;
                    $newAppForm->type = $request->type;
                    $newAppForm->place = $request->place;
    
                    $newAppForm->save();

                    DB::table('app_form_sessions')->where('id', $lastAppFormSession->id)->update(['is_alive' => "0"]);
                    
                    return Redirect::route('dashboard')->with('status', 'form-sent-successfully');
                }

                break;
    
            case 'extendTime':
                self::ExtendAppFormSession($this->sessionSeconds);

                session(['_old_input.app_name' => $request->app_name]);
                session(['_old_input.description' => $request->description]);
                session(['_old_input.type' => $request->type]);
                session(['_old_input.place' => $request->place]);
                session(['sessionSeconds' => $this->sessionSeconds]);
        
                return Redirect::back();
        }

        return Redirect::route('dashboard');
    }
    public function terminate(Request $request): RedirectResponse
    {
        self::TerminateAppFormSession();
        
        return Redirect::route('dashboard')->with('status', 'session-terminated');
    }
}
