<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        $folderPath = app_path('api/domisili');
        $domisili = [];
    
        if (is_dir($folderPath)) {
            $files = scandir($folderPath);
    
            foreach ($files as $file) {
                // Proses hanya file JSON
                if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                    $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
    
                    // Decode JSON
                    $data = json_decode(file_get_contents($filePath), true);
    
                    // Pastikan data valid dan tambahkan ke array
                    if (isset($data['name'])) {
                        $domisili[] = $data; // Menyimpan objek sebagai array
                    }
                }
            }
        }
    
        // Kirim data ke view
        return view('auth.register', compact('domisili'));
    }
    
    
    

    // Proses registrasi
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'no_hp' => 'required|numeric',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'keperluan_spk' => 'required|string',
            'domisili' => 'required|string',
        ]);

        try {
            // Proses menyimpan data ke database
            User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'keperluan_spk' => $request->keperluan_spk,
                'domisili' => $request->domisili,
                'role' => 'Pengguna Utama',
                'validasi' => 'Menunggu',
            ]);

            return redirect()->route('register')->with('modal_success', true);

        } catch (\Exception $e) {
            \Log::error('Error saat menyimpan user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
        }
    }
}