<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * The action to update user profile information.
     *
     * @var UpdateUserProfileInformation
     */
    protected $updateUserProfileInformation;

    /**
     * The action to update user profile information.
     */
    public function __construct(UpdateUserProfileInformation $updateUserProfileInformation)
    {
        $this->updateUserProfileInformation = $updateUserProfileInformation;
    }

    /**
     * Show the profile of the authenticated user.
     */

    public function showProfile(User $user)
    {
        return view('components.pages.profile.profile-information', [
            'title' => 'Profile',
            'user' => $user,
        ]);
    }

    /**
     * Upload the profile photo of the authenticated user.
     */
    public function uploadProfilePhoto(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }

        $request->validate(
            [
                'profile_photo' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            ],
            [
                'profile_photo.required' => 'Foto profil harus diunggah',
                'profile_photo.image' => 'File yang diunggah harus berupa gambar',
                'profile_photo.mimes' => 'Format gambar harus jpeg, png, jpg, webp, atau svg',
                'profile_photo.max' => 'Ukuran gambar maksimal 2MB',
            ]
        );

        try {
            $user = User::findOrFail(Auth::id());
            if ($request->hasFile('profile_photo')) {
                $user->clearMediaCollection('profile_photo');
                $user->addMediaFromRequest('profile_photo')
                    ->usingName('profile_' . Date('YmdHis') . Auth::id())
                    ->usingFileName('profile_' . Date('YmdHis') . '_' . Auth::id() . '.' . $request->file('profile_photo')->getClientOriginalExtension())
                    ->toMediaCollection('profile_photo');
            } else {
                return redirect()->back()->with('error', 'Tidak ada foto yang diunggah');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('error', 'Gagal mengunggah foto profil');
            Log::error('Error uploading profile photo: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui');
    }

    /**
     * Update the profile information of the authenticated user.
     */

    public function updateProfileInformation(Request $request)
    {
        $this->updateUserProfileInformation->update(Auth::user(), $request->all());

        return redirect()->route('profile', ['user' => Auth::user()->username]);
    }
}
