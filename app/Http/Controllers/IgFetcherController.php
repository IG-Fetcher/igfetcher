<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IgFetcherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    
    public function homepage() {
        return view('home');
    }

    public function fetchUserInfos(Request $request) {
        $username = $request->input('username');
        // Todo : validate
        return redirect()->route('userinfo.html', ['username' => $username]);
    }

    public function showUserInfos($username) {
        return view('userinfo', [
            'username' => $username
        ]);
    }

    public function showUserInfosJSON($username) {
        return response()->json([
            'username' => $username,
        ]);
    }
}
