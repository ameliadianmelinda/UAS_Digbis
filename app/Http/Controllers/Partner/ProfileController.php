<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = [
            'logo' => null,
            'org_name' => 'Amikom Event Hub Partner',
            'pic_name' => 'Rizky Permana',
            'org_email' => 'partner@amikomeventhub.com',
            'phone' => '081234567890',
            'address' => 'Jl. Raya No. 10, Jakarta Selatan',
            'description' => 'Kami adalah organisasi event yang fokus pada penyelenggaraan pengalaman acara digital dan komunitas kreatif dengan standar profesional.',
            'website' => 'https://amikomeventhub.com',
            'instagram' => '@amikomeventhub',
        ];

        return view('partner.profile', compact('profile'));
    }
}
