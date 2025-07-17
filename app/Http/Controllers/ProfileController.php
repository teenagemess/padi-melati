<?php

namespace App\Http\Controllers;

use App\Models\Datadiri;
use App\Models\Orangtua;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\PandanganNikah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user(); // Gunakan user dari request

        $dataDiri = Datadiri::with(['orangtua', 'pandanganNikah', 'kriteria'])
            ->where('user_id', $user->id)
            ->first(); // Ubah ke first() saja

        // Jika admin ingin edit profile orang lain, perlu penanganan khusus
        if (!$dataDiri) {
            $dataDiri = new Datadiri(['user_id' => $user->id]);
        }

        return view('profile.edit', [
            'user' => $user,
            'dataDiri' => $dataDiri,
        ]);
    }

    /**
     * Update the user's profile information (untuk email).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update user's name only
     */
    public function updateName(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = $request->user();
        $user->name = $request->name;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'name-updated');
    }

    /**
     * Update user's email only
     */
    public function updateEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        $user = $request->user();
        $user->email = $request->email;
        $user->email_verified_at = null; // Reset email verification
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'email-updated');
    }

    public function updateDataDiri(Request $request)
    {
        DB::beginTransaction();
        try {
            // Update Data Diri - hanya field yang diisi saja
            $user = $request->user();
            $dataDiri = Datadiri::firstOrNew(['user_id' => $user->id]);

            if ($dataDiri) {
                $fillableFields = [
                    'nbm',
                    'nama_peserta',
                    'jenis_kelamin',
                    'tempat_lahir',
                    'tanggal_lahir',
                    'tinggi_badan',
                    'berat_badan',
                    'alamat',
                    'no_telepon',
                    'pendidikan',
                    'pekerjaan',
                    'penghasilan',
                    'riwayat_organisasi',
                ];

                foreach ($fillableFields as $field) {
                    if ($request->has($field)) {
                        $dataDiri->$field = $request->input($field);
                    }
                }

                $dataDiri->save();
                DB::commit();
            }

            DB::commit();
            return back()->with('status', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Update the user's profile image.
     */
    public function updateImage(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        try {
            // Check if file exists
            if (!$request->hasFile('image')) {
                return Redirect::route('profile.edit')->with('error', 'No file selected');
            }

            $file = $request->file('image');

            // Check if file is valid
            if (!$file->isValid()) {
                return Redirect::route('profile.edit')->with('error', 'Invalid file upload');
            }

            // Delete old image if exists
            if ($user->image) {
                $oldImagePath = public_path('storage/' . $user->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Define destination path
            $destinationPath = public_path('storage/profile-images');

            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move uploaded file
            $file->move($destinationPath, $filename);

            // Set the relative path for database storage
            $imagePath = 'profile-images/' . $filename;

            // Verify the file was stored
            if (!file_exists($destinationPath . '/' . $filename)) {
                return Redirect::route('profile.edit')->with('error', 'Failed to save image');
            }

            // Update user's image path
            $user->update(['image' => $imagePath]);

            return Redirect::route('profile.edit')->with('status', 'image-updated');
        } catch (\Exception $e) {
            Log::error('Profile image upload error: ' . $e->getMessage());
            return Redirect::route('profile.edit')->with('error', 'Error uploading image: ' . $e->getMessage());
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete user's profile image if exists
        if ($user->image) {
            $imagePath = public_path('storage/' . $user->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
