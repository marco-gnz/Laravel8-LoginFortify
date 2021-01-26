<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->rut == null) {
            return view('home', compact('user'));
        } else {
            return view('home_principal');
        }
    }
    public function create_rut(Request $request, User $user)
    {
        if (!$request->ajax()) return redirect('/');

        $user = Auth::user();

        $rut = $request->rut;

        $validation = User::where('rut', $rut)->first();

        if(!$validation){
            $user->update([
                'rut' => $rut
            ]);
        }else{
            return response()->json(["ok" => false]);
        }

        
    }
}
