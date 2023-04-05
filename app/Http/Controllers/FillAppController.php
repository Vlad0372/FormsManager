<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AppFormController extends Controller
{
    /**
     * Display the application form.
     */
    public function tryStartFilling(Request $request): RedirectResponse
    {
        // return view('applications.edit', [
        //     'user' => $request->user(),
        // ]);
        //return redirect()->back();
        //$returnMsg = 'form-filling-occupied';
        $isSessionOccupied = true;
        $isSessionOccupied = false; 


        // if($request->status === 'bruh'){
        //     $isSessionOccupied = false; 
        // }
      
        if($isSessionOccupied){
            $returnMsg = 'form-filling-occupied';
            return redirect()->back()->with('status', $returnMsg);
        }else{
            $returnMsg = 'form-filling-free';
            return Redirect::route('applications.edit')->with('status', 'bruh');
        }


         
        //return Redirect::route('applications.edit')->with('status', 'profile-updated');
    }
    public function edit(Request $request): View
    {
        return view('applications.edit', [
            'user' => $request->user(),
        ]);

        //return Redirect::route('applications.edit')->with('status', 'profile-updated');
    }
    public function toggleApprove(Request $request,$id) {
        //Move::find($id)->update([approved => $request->approved]);
        return view('applications.edit', [
            'user' => $request->user(),
        ]);

    }
    /**
     * Update the application form.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        
    }

    /**
     * Delete the application form.
     */
    public function destroy(Request $request): RedirectResponse
    {
       
    }
    
     /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:'.User::class,
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        // event(new Registered($user));

        // Auth::login($user);

        return Redirect::route('dashboard')->with('status', 'bruh');
    }
}
