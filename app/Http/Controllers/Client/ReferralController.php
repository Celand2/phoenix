<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function index()
    {
        $referralsQuery = Referral::with('referred')->where('referrer_id', Auth::id());

        return view('client.referrals.index', [
            'referredUsers' => User::where('referred_by', Auth::id())->latest()->get(),
            'referrals' => (clone $referralsQuery)->latest()->paginate(20),
            'totalCommissions' => (clone $referralsQuery)->sum('commission_amount'),
        ]);
    }
}
