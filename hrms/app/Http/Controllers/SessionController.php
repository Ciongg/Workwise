<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function store(){
        $validated = request()->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(!Auth::attempt($validated)){
            throw ValidationException::withMessages([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        request()->session()->regenerate();
        
        if (Auth::user()->role === 'hr') {
            return redirect()->route('hr.dashboard')->with('success', 'Login successful');
        } elseif (Auth::user()->role === 'manager') {
            return redirect()->route('manager.dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->route('employee.dashboard')->with('success', 'Login successful');
        }
    }

    public function destroy(){
        Auth::logout();

        return redirect('/');
    }
}
