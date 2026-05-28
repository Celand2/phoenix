<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BonusCode;
use Illuminate\Http\Request;

class BonusCodeController extends Controller
{
    public function index()
    {
        return view('admin.bonus-codes.index', ['bonusCodes' => BonusCode::latest()->paginate(20)]);
    }

    public function create()
    {
        return view('admin.bonus-codes.create');
    }

    public function store(Request $request)
    {
        BonusCode::create($request->validate([
            'code' => ['required', 'string', 'max:255', 'unique:bonus_codes,code'],
            'amount' => ['required', 'numeric', 'min:0'],
            'max_uses' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:active,inactive'],
            'expires_at' => ['nullable', 'date'],
        ]) + ['used_count' => 0]);

        return redirect()->route('admin.bonus-codes.index')->with('status', 'Code bonus cree.');
    }

    public function destroy(BonusCode $bonusCode)
    {
        $bonusCode->delete();

        return back()->with('status', 'Code bonus supprime.');
    }
}
