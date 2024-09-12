<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Manager;
use Inertia\Inertia;

class ManagerController extends Controller
{
    public function create()
    {
        $managers = Manager::all();
        return inertia('YourComponent', [
            'managers' => $managers,
        ]);
    }
    public function showLoginForm()
    {
        return Inertia::render('ManagerLogin');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('manager')->attempt($credentials)) {
            return redirect()->intended('/dashboard'); 
        }
        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('manager')->logout();
        return redirect('/');
    }
    public function getAllManagers()
    {
        $managers = Manager::all(['id', 'name']); 
        return response()->json($managers);
    }
}
