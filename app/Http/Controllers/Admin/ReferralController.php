<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;

class ReferralController extends Controller
{
    public function index()
    {
        return view('admin.referrals.index', [
            'referrals' => Referral::with(['referrer', 'referred', 'userTrade.trade'])->latest()->paginate(20),
        ]);
    }

    public function destroy(Referral $referral)
    {
        $referral->delete();

        return back()->with('status', 'Parrainage supprime.');
    }
}
