<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\c_in;
use App\Models\Work;

class EmployeeController extends Controller
{


    public function salaryForm()
{
    $employee = Auth::user()->employee;
    return view('employee.salary', compact('employee'));

}
    public function dashboard()
{
    $user = Auth::user();

    // ดึงข้อมูลพนักงาน
    $employee = $user->employee;

    // ดึง check-in ล่าสุดของผู้ใช้
    $latestCheck = \App\Models\c_in::where('user_id', $user->id)
        ->latest() // เรียงจากล่าสุด
        ->first();

    return view('employee.dashboard', compact('employee', 'latestCheck'));
}



public function showSalary($month)
{
    $user = Auth::user();
    $employee = $user->employee;

    // ดึงข้อมูล works ของเดือนที่เลือก
    $workHours = Work::where('user_id', $user->id)
        ->whereYear('date', date('Y', strtotime($month)))
        ->whereMonth('date', date('m', strtotime($month)))
        ->get();

    // คำนวณเงินเดือนรวม
    $monthlySalary = $workHours->sum(function ($wh) {
        return $wh->work_hours * $wh->hourly_rate;
    });

    return view('employee.salary_show', compact('employee', 'month', 'workHours', 'monthlySalary'));
}


public function profile()
{
    $employee = auth()->user()->employee; // ดึงข้อมูลพนักงานจากผู้ใช้ที่ล็อกอิน

    return view('employee.profile', compact('employee'));
}

public function editProfile()
{
    $employee = auth()->user()->employee;
    return view('employee.edit_profile', compact('employee'));
}

public function updateProfile(Request $request)
{
    $employee = auth()->user()->employee;

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . auth()->id(),
        'gender' => 'nullable|string|in:ชาย,หญิง,อื่นๆ',
        'phone' => 'nullable|string|max:20',
        'birth_date' => 'nullable|date',
        'address' => 'nullable|string',
        'department' => 'nullable|string|max:255',
        'hourly_rate' => 'nullable|numeric|min:0',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $profilePath = $employee->profile_image;
    if ($request->hasFile('profile_image')) {
        $profilePath = $request->file('profile_image')->store('profiles', 'public');
    }

    $employee->update([
        'name' => $request->name,
        'email' => $request->email,
        'gender' => $request->gender,
        'phone' => $request->phone,
        'birth_date' => $request->birth_date,
        'address' => $request->address,
        'department' => $request->department,
        'hourly_rate' => $request->hourly_rate,
        'profile_image' => $profilePath
    ]);

    $user = \App\Models\User::find(auth()->id());
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    return redirect()->route('employee.profile')->with('success', 'อัปเดตโปรไฟล์เรียบร้อยแล้ว!');
}

}
