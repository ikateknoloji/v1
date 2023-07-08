<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'E-posta alanı zorunludur.',
            'password.required' => 'Parola alanı zorunludur.',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return $this->error(
                'Kullanıcı Girişi Gerçekleştirilemedi.', 
            ['error'=>'Kullanıcı bilgilerin eksik veya hatalı']
            );
        }

        $user = $request->user();
        $token = $user->createToken('API Token')->plainTextToken;

        return $this->success(['token' => $token], 'Giriş Başarıyla gerçekleştirildi.');
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->success(null, 'Logged out successfully');
    }
}
