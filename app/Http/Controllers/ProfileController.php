<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        
        // Actualizar solo información personal del usuario
        $userData = $request->validated();
        
        $user->fill([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'movil' => $userData['movil'] ?? null,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::route('admin.profile.edit')
                        ->with('status', 'password-updated');
    }

    /**
     * Update the empresa's flete value.
     */
    public function updateFlete(Request $request)
    {
        $request->validate([
            'flete' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $empresa = $user->empresa;

        if (!$empresa) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró información de la empresa.'
            ], 404);
        }

        $empresa->update(['flete' => $request->flete]);

        return response()->json([
            'success' => true,
            'message' => 'Valor del flete actualizado correctamente.',
            'flete' => $empresa->flete
        ]);
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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
