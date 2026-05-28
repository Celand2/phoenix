<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Withdrawal;
use App\Services\WithdrawalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function index()
    {
        return view('client.withdrawals.index', [
            'withdrawals' => Withdrawal::with('paymentMethod')->where('user_id', Auth::id())->latest()->paginate(20),
            'paymentMethods' => PaymentMethod::active()->get(),
        ]);
    }

    public function store(Request $request, WithdrawalService $withdrawalService)
    {
        $data = $request->validate([
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'account_number' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
        ]);

        $ok = $withdrawalService->create(Auth::user(), PaymentMethod::findOrFail($data['payment_method_id']), (float) $data['amount'], $data['account_number'], $data['account_name']);

        return $ok
            ? back()->with('status', 'Retrait demande.')
            : back()->withErrors(['amount' => 'Solde gains insuffisant.']);
    }
}
