<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];

        if ($request->hasFile('avatar')) {

            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $extension = $request->file('avatar')->getClientOriginalExtension();

            $fileName = Str::slug($user->name) . '-' . $user->id . '.' . $extension;

            $path = $request->file('avatar')->storeAs(
                'avatars',
                $fileName,
                'public'
            );

            $user->avatar = $path;
        }

        $user->save();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Profile updated successfully.');
    }
}
