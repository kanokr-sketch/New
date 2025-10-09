<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use App\Models\Work;

class AdminController extends Controller
{
    /**
     * แสดงรายชื่อพนักงานทั้งหมด
     */
    public function listEmployees()
    {
        $employees = Employee::with('user')->get();
        return view('admin.employee_list', compact('employees'));
    }

    /**
     * ฟอร์มเพิ่มพนักงาน
     */
    public function createEmployee()
    {
        return view('admin.employee.create');
    }

    /**
     * บันทึกข้อมูลพนักงานใหม่
     */
    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,employee',
            'gender' => 'nullable|string|in:ชาย,หญิง,อื่นๆ',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'hourly_rate' => 'nullable|numeric|min:0',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // อัปโหลดรูป
        $profilePath = null;
        if ($request->hasFile('profile_image')) {
            $profilePath = $request->file('profile_image')->store('profiles', 'public');
        }

        // สร้าง User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        // สร้าง Employee
        Employee::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'department' => $request->department,
            'hourly_rate' => $request->hourly_rate,
            'role' => $request->role,
            'profile_image' => $profilePath
        ]);

        return redirect()->route('admin.employee.list')->with('success', 'เพิ่มพนักงานเรียบร้อยแล้ว!');
    }

    public function salaryEmployeeForm()
{
    $employees = Employee::all();
    return view('admin.salary_employee_form', compact('employees'));
}
/**
     * ✅ คำนวณเงินเดือนรายเดือนจากตาราง work
     */
     public function calculateSalary(Request $request)
    {
        $employeeId = $request->employee_id;
        $month = $request->month ?? date('Y-m');

        $employee = Employee::findOrFail($employeeId);

        // ดึงข้อมูลจากตาราง work
        $works = Work::where('user_id', $employee->user_id)
            ->whereMonth('date', '=', date('m', strtotime($month)))
            ->whereYear('date', '=', date('Y', strtotime($month)))
            ->get();

        $totalHours = $works->sum('work_hours');
        $hourlyRate = $works->first()->hourly_rate ?? $employee->hourly_rate ?? 0;
        $totalSalary = $totalHours * $hourlyRate;

        return view('admin.salary.result_employee', compact(
            'employee', 'works', 'totalHours', 'hourlyRate', 'totalSalary', 'month'
        ));
    }

   public function showEmployeeSalary($employeeId, Request $request)
{
    $month = $request->query('month');

    if (!$month) {
        return redirect()->back()->with('error', 'กรุณาเลือกเดือน');
    }

    $employee = Employee::findOrFail($employeeId);

    $workData = Work::where('user_id', $employee->user_id)
        ->whereMonth('date', date('m', strtotime($month)))
        ->whereYear('date', date('Y', strtotime($month)))
        ->get();

    $daily = $workData->map(function ($wh) use ($employee) {
        return [
            'date' => $wh->date,
            'hours' => $wh->work_hours,
            'rate' => $wh->hourly_rate ?? $employee->hourly_rate,
            'amount' => ($wh->work_hours * ($wh->hourly_rate ?? $employee->hourly_rate)),
            'id' => $wh->id
        ];
    });

    $monthlySalary = $daily->sum('amount');

    return view('admin.salary.result_employee', [
        'employee' => $employee,
        'daily' => $daily,
        'monthlySalary' => $monthlySalary,
        'month' => $month
    ]);
}


    // สรุปข้อมูล
public function showAllEmployeesSalary(Request $request)
{
    $month = $request->query('month');

    if (!$month) {
        return redirect()->back()->with('error', 'กรุณาเลือกเดือน');
    }

    $year = date('Y', strtotime($month));
    $monthNum = date('m', strtotime($month));

    // ดึงพนักงานทั้งหมด
    $employees = Employee::with(['user'])->get();

    $salaries = [];

    foreach ($employees as $employee) {
        $workHours = Work::where('user_id', $employee->user_id)
            ->whereYear('date', $year)
            ->whereMonth('date', $monthNum)
            ->get();

        $totalSalary = $workHours->sum(function ($wh) {
            return $wh->work_hours * $wh->hourly_rate;
        });

        $salaries[] = [
            'employee' => $employee,
            'workHours' => $workHours,
            'totalSalary' => $totalSalary,
        ];
    }

    return view('admin.salary.salary_all_employees', compact('salaries', 'month'));
}


}
