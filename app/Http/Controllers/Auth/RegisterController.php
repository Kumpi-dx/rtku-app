<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16', 'unique:wargas,nik'],
            'email' => ['required', 'email', 'unique:users,email'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'pekerjaan' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
            'status_domisili' => ['nullable', 'in:Tetap,Kontrak,Pindah'],
            'status_perkawinan' => ['nullable', 'in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'nik.unique' => 'NIK sudah terdaftar. Silakan masuk atau hubungi pengurus.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan. Silakan masuk atau gunakan email lain.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'status_domisili.in' => 'Status domisili tidak valid.',
            'status_perkawinan.in' => 'Status perkawinan tidak valid.',
            'no_telp.max' => 'Nomor telepon maksimal 20 karakter.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sama.',
        ]);

        $user = DB::transaction(function () use ($validated): User {
            $user = User::create([
                'name' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'warga',
            ]);

            Warga::create([
                'nik' => $validated['nik'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? 'Perempuan',
                'no_telp' => $validated['no_telp'] ?? null,
                'pekerjaan' => $validated['pekerjaan'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'status_domisili' => $validated['status_domisili'] ?? 'Tetap',
                'status_perkawinan' => $validated['status_perkawinan'] ?? null,
                'user_id' => $user->id,
            ]);

            return $user;
        });

        Auth::login($user);

        return redirect()->route('portal.index')->with('success', 'Registrasi berhasil. Akun warga Anda telah dibuat.');
    }
}
