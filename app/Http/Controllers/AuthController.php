<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\c_in;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * แสดงหน้า Login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * ตรวจสอบการเข้าสู่ระบบ
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // ลองหาผู้ใช้จากรหัสพนักงาน/ผู้ดูแลระบบ
        $user = User::where('email', $request->email)->first();

        if ($user && Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            // ทั้ง admin และ employee ไปหน้า checkin ได้เหมือนกัน
            return redirect()->route('c_in.checkin');
        }

        return back()->withErrors(['a_e_id' => 'รหัสพนักงานหรือรหัสผ่านไม่ถูกต้อง']);
    }

    /**
     * หน้า dashboard (สำรองไว้สำหรับ admin)
     */
    public function dashboard()
    {
        $user = Auth::user();

        // ตรวจสอบว่าผู้ใช้มีการเช็คอินครั้งล่าสุดหรือไม่
        $latestCheck = c_in::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->first();

        return view('admin.dashboard', compact('latestCheck'));
    }

    /**
     * ออกจากระบบ
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
