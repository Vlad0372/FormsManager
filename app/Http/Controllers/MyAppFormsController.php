<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppFormRequest;
use App\Http\Controllers\DateTimeZone;
use App\Models\AppForm;
use App\Models\AppType;
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
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;

require '../vendor/autoload.php';

class MyAppFormsController extends Controller
{
    public function index(): View
    {
        return view('my-app-forms.index', ['myAppForms' => AppForm::all()->where('author_id','=',auth()->user()->id)->reverse()]);
    }

    public function edit(Request $request, string $Id): View
    {
        if($request->input('action') == 'repopulateForm'){
            $user = auth()->user();
            $appForm = AppForm::find($request->id);

            if($appForm != null and $appForm->author_id == $user->id){
                session(['_old_input.app_name' => $appForm->app_name]);
                session(['_old_input.description' => $appForm->description]);
                session(['_old_input.type' => $appForm->type]);
                session(['_old_input.place' => $appForm->place]);
            }
        }

        return view('my-app-forms.edit', ['appFormId' => $Id ,'allAppTypes' => AppType::all()]);
    }

    public function update(AppFormRequest $request): RedirectResponse
    {
        if($request->input('action') == 'goBack'){
            return Redirect::route('my-app-forms');
        }

        $user = auth()->user();
        $appForm = AppForm::find($request->input('appFormId'));

        if($appForm != null and $appForm->author_id == $user->id){
            $appForm->app_name = $request->app_name;
            $appForm->description = $request->description;
            $appForm->type = $request->type;
            $appForm->place = null;

            $appFormType = AppType::where('type', '=',  $request->type)->first();

            if($appFormType != null && $appFormType->has_description == true){
                $appForm->place = $request->place;
            }

            $appForm->save();
        }

        return Redirect::route('my-app-forms')->with('status', 'app-form-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $appForm = AppForm::find($request->id);

        if($appForm != null and $appForm->author_id == $user->id){
           $appForm->delete();

           return Redirect::route('my-app-forms')->with('status', 'app-form-deleted');
        }

        return Redirect::route('my-app-forms');
    }

    public function pdfStream(Request $request)
    {
        $user = auth()->user();
        $appForm = AppForm::find($request->input('appFormId'));
       
        $appForm->created_at_f = Carbon::parse($appForm->created_at)->format('d.m.Y');
        $appForm->printed_at_f = Carbon::parse(Carbon::now())->format('d.m.Y');
        
        if($appForm != null and $appForm->author_id == $user->id){
            $appForm = $appForm->toArray();
              
            $pdf = PDF::loadView('my-app-forms.partials.pdf-template', compact('appForm'));
           
            return $pdf->stream('application_form.pdf');
        }
    }
}
