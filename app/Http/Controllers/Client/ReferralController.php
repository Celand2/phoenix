<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function index()
    {
        return view('client.referrals.index', [
            'referrals' => Referral::with('referred')->where('referrer_id', Auth::id())->latest()->paginate(20),
        ]);
    }
}
