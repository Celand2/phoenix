<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\BonusCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BonusCodeController extends Controller
{
    public function redeem(Request $request, BonusCodeService $bonusCodeService)
    {
        $data = $request->validate(['code' => ['required', 'string', 'max:255']]);
        $result = $bonusCodeService->redeem(Auth::user(), $data['code']);

        return $result['success']
            ? back()->with('status', $result['message'])
            : back()->withErrors(['code' => $result['message']]);
    }
}
