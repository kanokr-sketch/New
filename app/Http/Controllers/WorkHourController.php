<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\c_in;
use App\Models\Employee;
use App\Models\Work;

class WorkHourController extends Controller
{
    /**
     * แสดงฟอร์มเพิ่มชั่วโมงการทำงาน
     */
    public function create()
    {
        // ดึงข้อมูลพนักงานทั้งหมด
        $employees = Employee::with('user')->get();

        return view('workhours.create', compact('employees'));
    }

    /**
     * บันทึกชั่วโมงการทำงานแบบเดี่ยว
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in'
        ]);

        $user = Auth::user();

        // คำนวณชั่วโมงทำงาน
        $hoursWorked = null;
        if ($request->check_out) {
            $start = strtotime($request->check_in);
            $end = strtotime($request->check_out);
            $hoursWorked = ($end - $start) / 3600; // ชั่วโมง
        }

        Work::create([
            'user_id' => $user->id,
            'work_date' => $request->work_date,
            'hours_worked' => $hoursWorked
        ]);

        return redirect()->route('workhours.create')->with('success', 'เพิ่มชั่วโมงการทำงานเรียบร้อยแล้ว!');
    }

    /**
     * บันทึกชั่วโมงการทำงานแบบหลายรายการ
     */
    public function storeMultiple(Request $request)
    {
          $request->validate([
        'employee_id' => 'required|array',
        'work_date' => 'required|array',
        'hours_worked' => 'required|array',
    ]);

        foreach ($request->employee_id as $index => $empId) {
            $employee = Employee::find($empId);
        Work::create([
            'user_id' => $empId,
            'date' => $request->work_date[$index],
            'work_hours' => $request->hours_worked[$index],
            'hourly_rate' => $employee->hourly_rate ?? 0
        ]);
        }

        return redirect()->route('workhours.create')->with('success', 'บันทึกชั่วโมงการทำงานเรียบร้อยแล้ว!');
    }


   public function edit($id)
    {
        $work = Work::findOrFail($id);
        return view('workhours.edit', compact('work'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'work_hours' => 'required|numeric|min:0',
        ]);

        $work = Work::findOrFail($id);
        $work->work_hours = $request->work_hours;
        $work->save();

        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $work = Work::findOrFail($id);
        $work->delete();

        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }
}
