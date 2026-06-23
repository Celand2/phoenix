<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Support\Money;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();

        if ($search = $request->input('search')) {
            $users->where(function ($query) use ($search) {
                $query->where('id', $search)
                      ->orWhere('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return view('admin.users.index', ['users' => $users->latest()->paginate(20)->withQueryString()]);
    }

    public function show(User $user)
    {
        $user->load(['userTrades.trade', 'deposits', 'withdrawals', 'referrals']);
        $paymentMethods = PaymentMethod::with('exchangeRate')->active()->get();

        return view('admin.users.show', compact('user', 'paymentMethods'));
    }

    public function updatePreferences(Request $request, User $user)
    {
        $data = $request->validate([
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
        ]);

        $paymentMethod = PaymentMethod::with('exchangeRate')->active()->findOrFail($data['payment_method_id']);
        $snapshot = Money::snapshotFor($paymentMethod);

        $user->update([
            'preferred_payment_method_id' => $paymentMethod->id,
            'preferred_currency' => $snapshot['currency'],
            'preferred_rate' => $snapshot['rate'],
        ]);

        return back()->with('status', 'Préférences monétaires mises à jour.');
    }

    public function updateBalance(Request $request, User $user)
    {
        $data = $request->validate([
            'balance_invested' => ['required', 'numeric', 'min:0'],
            'balance_gains' => ['required', 'numeric', 'min:0'],
        ]);

        $user->update($data);

        return back()->with('status', 'Soldes mis a jour.');
    }

    public function updateStatus(Request $request, User $user)
    {
        $user->update($request->validate(['status' => ['required', 'in:active,inactive,suspended']]));

        return back()->with('status', 'Statut mis a jour.');
    }

    public function updatePassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = \Illuminate\Support\Facades\Hash::make($data['password']);
        $user->save();

        return back()->with('status', 'Mot de passe mis a jour.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'Utilisateur supprime.');
    }
}
