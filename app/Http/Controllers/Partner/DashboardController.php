<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $partner = $request->user() ?? (object) [
            'name' => 'Partner Demo',
            'email' => 'partner@example.com',
        ];

        return view('partner.dashboard', compact('partner'));
    }

    public function preview()
    {
        $partner = (object) [
            'name' => 'Partner Demo',
            'email' => 'partner@example.com',
        ];

        return view('partner.dashboard', compact('partner'));
    }
}