<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PengaturanController extends Controller
{
    /**
     * Display store settings view with Profil Toko & QRIS tabs.
     */
    public function index(Request $request)
    {
        $settings = StoreSetting::current();
        $activeTab = $request->input('tab', 'toko');

        return view('owner.pengaturan.index', compact('settings', 'activeTab'));
    }

    /**
     * Update Profil Toko (Identitas Toko).
     */
    public function updateShop(Request $request)
    {
        $request->validate([
            'shop_name' => ['required', 'string', 'max:255'],
            'shop_address' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'shop_name.required' => 'Nama toko wajib diisi.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ]);

        $settings = StoreSetting::current();
        $logoPath = $settings->shop_logo;

        if ($request->hasFile('logo')) {
            if ($settings->shop_logo && File::exists(public_path($settings->shop_logo))) {
                File::delete(public_path($settings->shop_logo));
            }

            $file = $request->file('logo');
            $filename = 'logo_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/settings'), $filename);
            $logoPath = 'uploads/settings/' . $filename;
        }

        $settings->update([
            'shop_name' => $request->input('shop_name'),
            'shop_address' => $request->input('shop_address'),
            'shop_logo' => $logoPath,
        ]);

        return redirect()->route('owner.pengaturan', ['tab' => 'toko'])
            ->with('success', 'Profil toko berhasil disimpan.');
    }

    /**
     * Upload or replace QRIS image.
     */
    public function updateQris(Request $request)
    {
        $request->validate([
            'qris' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'qris.required' => 'File gambar QRIS wajib dipilih.',
            'qris.max' => 'Ukuran gambar QRIS maksimal 2MB.',
        ]);

        $settings = StoreSetting::current();

        if ($settings->qris_image && File::exists(public_path($settings->qris_image))) {
            File::delete(public_path($settings->qris_image));
        }

        $file = $request->file('qris');
        $filename = 'qris_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/settings'), $filename);
        $qrisPath = 'uploads/settings/' . $filename;

        $settings->update([
            'qris_image' => $qrisPath,
        ]);

        return redirect()->route('owner.pengaturan', ['tab' => 'qris'])
            ->with('success', 'Metode pembayaran QRIS berhasil disimpan.');
    }

    /**
     * Delete existing QRIS image.
     */
    public function deleteQris()
    {
        $settings = StoreSetting::current();

        if ($settings->qris_image && File::exists(public_path($settings->qris_image))) {
            File::delete(public_path($settings->qris_image));
        }

        $settings->update([
            'qris_image' => null,
        ]);

        return redirect()->route('owner.pengaturan', ['tab' => 'qris'])
            ->with('success', 'Metode pembayaran QRIS berhasil dihapus.');
    }
}
