<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppFormRequest;
use App\Http\Controllers\DateTimeZone;
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

class MyAppFormsController extends Controller
{
    public function index(): View
    {
        return view('my-app-forms.index', ['myAppForms' => AppForm::all()->where('author_id','=',auth()->user()->id)]);
    }

    public function edit(Request $request, string $Id): View
    {        
        if($request->input('action') == 'repopulateForm'){
            $user = auth()->user();
            $appForm = AppForm::find($request->id);

            $appFormTypeIndex = DB::scalar(
                "select type+0 from app_forms where id = ?", [$request->id]
            );

            if($appForm != null and $appForm->author_id == $user->id){
                session(['_old_input.app_name' => $appForm->app_name]);
                session(['_old_input.description' => $appForm->description]);
                session(['_old_input.type' => $appFormTypeIndex]);
                session(['_old_input.place' => $appForm->place]);
            }  
        }

        return view('my-app-forms.edit', ['appFormId' => $Id]);
    }

    public function update(AppFormRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $appForm = AppForm::find($request->input('appFormId'));

        if($appForm != null and $appForm->author_id == $user->id){
            $appForm->app_name = $request->app_name;
            $appForm->description = $request->description;
            $appForm->type = $request->type;
            $request->type == 1 ? $appForm->place = $request->place : $appForm->place = null;
            $appForm->save();
        }

        return Redirect::route('dashboard')->with('status', 'app-form-updated');
    }
}
