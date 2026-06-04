<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::latest()->paginate(20)]);
    }

    public function show(User $user)
    {
        $user->load(['userTrades.trade', 'deposits', 'withdrawals', 'referrals']);

        return view('admin.users.show', compact('user'));
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
