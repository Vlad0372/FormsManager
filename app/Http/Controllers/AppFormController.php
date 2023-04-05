<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\AppForm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AppFormController extends Controller
{
    /**
     * Show the form to create a new application.
     */
    public function create(): View//RedirectResponse
    {
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
