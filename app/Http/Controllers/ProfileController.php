<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit() {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request) {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return view('partials.form-error', ['errors' => $validator->errors()]);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response('<p class="text-emerald-500 font-medium text-sm">Profil berhasil diperbarui!</p>')
                ->header('HX-Trigger', json_encode(['showToast' => ['value' => 'Profil diperbarui']]));
    }
}
