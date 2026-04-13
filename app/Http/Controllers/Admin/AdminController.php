<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $validasi_diterima = User::where('validasi', 'Diterima')
                                 ->where('role', '!=', 'Admin')
                                 ->count();
        $validasi_ditolak = User::where('validasi', 'Ditolak')
                                ->where('role', '!=', 'Admin') 
                                ->count();
        $validasi_menunggu = User::where('validasi', 'Menunggu')
                                 ->where('role', '!=', 'Admin') 
                                 ->count();
    
        return view('Admin.dashboard', [
            'validasi_diterima' => $validasi_diterima,
            'validasi_ditolak' => $validasi_ditolak,
            'validasi_menunggu' => $validasi_menunggu,
        ]);
    }

    public function manageUsers()
    {
        $users = User::all();
        return view('Admin.users', compact('users'));
    }

    public function updateValidation(Request $request, $id)
    {
        $request->validate([
            'validasi' => 'required|in:Diterima,Ditolak',
        ]);

        $user = User::findOrFail($id);
        $user->validasi = $request->validasi;
        $user->save();

        return redirect()->back()->with('success', 'Status validasi berhasil diperbarui.');
    }
}