<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form for authenticated user (Owner or Kasir).
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the authenticated user's personal profile information and password.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->isKasir()) {
            // Kasir role: only photo and password can be updated by self. Name & username are readonly.
            $request->validate([
                'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            ], [
                'photo.max' => 'Ukuran foto maksimal 2MB.',
                'password.min' => 'Kata sandi baru minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            ]);

            $data = [];

            if ($request->hasFile('photo')) {
                if ($user->profile_photo && File::exists(public_path($user->profile_photo))) {
                    File::delete(public_path($user->profile_photo));
                }

                $file = $request->file('photo');
                $filename = 'profile_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/profiles'), $filename);
                $data['profile_photo'] = 'uploads/profiles/' . $filename;
            }

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->input('password'));
            }

            if (!empty($data)) {
                $user->update($data);
            }

            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        } else {
            // Owner role: full profile management
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
                'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            ], [
                'name.required' => 'Nama lengkap wajib diisi.',
                'username.required' => 'Username wajib diisi.',
                'username.unique' => 'Username sudah digunakan. Silakan pilih username lain.',
                'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan garis bawah.',
                'photo.max' => 'Ukuran foto maksimal 2MB.',
                'password.min' => 'Kata sandi baru minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            ]);

            $photoPath = $user->profile_photo;
            if ($request->hasFile('photo')) {
                if ($user->profile_photo && File::exists(public_path($user->profile_photo))) {
                    File::delete(public_path($user->profile_photo));
                }

                $file = $request->file('photo');
                $filename = 'profile_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/profiles'), $filename);
                $photoPath = 'uploads/profiles/' . $filename;
            }

            $data = [
                'name' => $request->input('name'),
                'username' => strtolower($request->input('username')),
                'profile_photo' => $photoPath,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->input('password'));
            }

            $user->update($data);

            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        }
    }
}
