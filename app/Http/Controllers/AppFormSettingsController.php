<?php

namespace App\Http\Controllers;

use App\Models\AppType;
use App\Models\AppForm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AppFormSettingsController extends Controller
{
    public function index(Request $request): View
    {
        session(['_old_input.app_type_name' => ""]);
        session(['_old_input.has_description' => 0]);

        return view('app-form-settings.index', ['appFormTypes' => AppType::all()->reverse()]);
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validateWithBag('appformtype', [
            'app_type_name' => 'required|unique:app_types,type|string|min:3|max:30',
        ]);

        $newAppFormType = new AppType;
        $newAppFormType->type = $request->app_type_name;

        if($request->has('app-type-checkbox')){
            $newAppFormType->has_description = true;
        }else{
            $newAppFormType->has_description = false;
        }

        $newAppFormType->save();
        
        return Redirect::back()->with('status', 'app-form-type-created');
    }
    public function edit(Request $request, string $Id): View
    {
        if($request->input('action') == 'repopulateForm'){
            $appFormType = AppType::find($request->id);

            if($appFormType != null){
                session(['_old_input.app_type_name' => $appFormType->type]);
                session(['_old_input.has_description' => $appFormType->has_description]);
            }
        }
        
        return view('app-form-settings.index', ['appFormTypeId' => $Id,
                                                'appFormTypes' => AppType::all()->reverse()]);
    }
    public function update(Request $request): RedirectResponse
    {
        if($request->input('action') == 'goBack'){
            return Redirect::route('app-form-settings', ['appFormTypes' => AppType::all()->reverse()]);
        }

        $rules = 'required|string|min:3|max:30';
        $additionalRule = '|unique:app_types,type';

        $appFormType = AppType::find($request->input('appFormTypeId'));

        if($appFormType->type != $request->app_type_name){
            $rules .= $additionalRule;
        }

        $request->validateWithBag('appformtype', [
            'app_type_name' => $rules,
        ]);

        if($appFormType != null){
            $oldTypeName = $appFormType->type;

            $appFormType->type = $request->app_type_name;

            $recordsWithOldType = AppForm::where('type', '=', $oldTypeName);
            $recordsWithOldType->update(['type' => $appFormType->type]);

            if($request->has('app-type-checkbox')){
                $appFormType->has_description = true;
            }else{
                $appFormType->has_description = false;
                $recordsWithOldType->update(['place' => null]);
            }

            $appFormType->save();           
        }

        return Redirect::route('app-form-settings')->with('status', 'app-form-type-updated');
    }
    public function destroy(Request $request): RedirectResponse
    {
        $appFormType = AppType::find($request->input('id'));

        if($appFormType != null){

            if (AppForm::where('type', '=', $appFormType->type)->exists()) {
                return Redirect::route('app-form-settings')->with('status', 'app-form-type-deletion-failed');
            }else{
                $appFormType->delete();
            }       
        }

        return Redirect::route('app-form-settings')->with('status', 'app-form-type-deleted');
    }
}
