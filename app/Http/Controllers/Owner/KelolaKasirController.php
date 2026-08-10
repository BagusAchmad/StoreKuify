<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class KelolaKasirController extends Controller
{
    /**
     * Display the cashier accounts management list.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status', 'all');

        $query = User::where('role', 'Kasir');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $cashiers = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('owner.kelola_kasir.index', compact('cashiers', 'search', 'status'));
    }

    /**
     * Show the form for creating a new cashier account.
     */
    public function create()
    {
        return view('owner.kelola_kasir.create');
    }

    /**
     * Store a newly created cashier account.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username', 'alpha_dash'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan. Silakan pilih username lain.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan garis bawah.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'kasir_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/cashiers'), $filename);
            $photoPath = 'uploads/cashiers/' . $filename;
        }

        $email = $request->input('username') . '@kasir.storekuify.local';

        $cashier = User::create([
            'name' => $request->input('name'),
            'username' => strtolower($request->input('username')),
            'email' => $email,
            'password' => Hash::make($request->input('password')),
            'role' => 'Kasir',
            'is_active' => true,
            'profile_photo' => $photoPath,
        ]);

        return redirect()->route('owner.kelola_kasir')
            ->with('success', 'Kasir berhasil ditambahkan.')
            ->with('new_cashier_credentials', [
                'name' => $cashier->name,
                'username' => $cashier->username,
                'password' => $request->input('password'),
            ]);
    }

    /**
     * Show the form for editing an existing cashier account.
     */
    public function edit(User $user)
    {
        if (!$user->isKasir()) {
            abort(403, 'Aksi ini hanya berlaku untuk akun kasir.');
        }

        return view('owner.kelola_kasir.edit', compact('user'));
    }

    /**
     * Update an existing cashier account.
     */
    public function update(Request $request, User $user)
    {
        if (!$user->isKasir()) {
            abort(403, 'Aksi ini hanya berlaku untuk akun kasir.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan. Silakan pilih username lain.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan garis bawah.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $photoPath = $user->profile_photo;
        if ($request->hasFile('photo')) {
            if ($user->profile_photo && File::exists(public_path($user->profile_photo))) {
                File::delete(public_path($user->profile_photo));
            }
            $file = $request->file('photo');
            $filename = 'kasir_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/cashiers'), $filename);
            $photoPath = 'uploads/cashiers/' . $filename;
        }

        $email = strtolower($request->input('username')) . '@kasir.storekuify.local';

        $user->update([
            'name' => $request->input('name'),
            'username' => strtolower($request->input('username')),
            'email' => $email,
            'profile_photo' => $photoPath,
        ]);

        return redirect()->route('owner.kelola_kasir')
            ->with('success', 'Data kasir berhasil diperbarui.');
    }

    /**
     * Activate a deactivated cashier account.
     */
    public function activate(User $user)
    {
        if (!$user->isKasir()) {
            abort(403, 'Aksi ini hanya berlaku untuk akun kasir.');
        }

        $user->update(['is_active' => true]);

        return redirect()->back()->with('success', 'Kasir berhasil diaktifkan kembali.');
    }

    /**
     * Deactivate an active cashier account.
     */
    public function deactivate(User $user)
    {
        if (!$user->isKasir()) {
            abort(403, 'Aksi ini hanya berlaku untuk akun kasir.');
        }

        $user->update(['is_active' => false]);

        return redirect()->back()->with('success', 'Kasir berhasil dinonaktifkan.');
    }

    /**
     * Reset password for a cashier account.
     */
    public function resetPassword(Request $request, User $user)
    {
        if (!$user->isKasir()) {
            abort(403, 'Aksi ini hanya berlaku untuk akun kasir.');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:6'],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
        ]);

        $newPassword = $request->input('password');

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        return redirect()->back()
            ->with('success', 'Password kasir berhasil direset.')
            ->with('new_reset_credentials', [
                'name' => $user->name,
                'username' => $user->username,
                'password' => $newPassword,
            ]);
    }
}
