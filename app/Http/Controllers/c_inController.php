<?php

namespace App\Http\Controllers;

use App\Models\c_in;
use App\Models\Work;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class c_inController extends Controller
{
    public function showCheckInPage()
    {
        $user = Auth::user();

        $latestCheck = c_in::where('user_id', $user->id)
            ->latest('id')
            ->first();

        return view('employee.dashboard', compact('latestCheck'));
    }

    public function checkIn(Request $request)
    {
        $user = Auth::user();

        // ตรวจสอบว่ามีการเช็คอินอยู่แล้วหรือไม่
        $existingCheck = c_in::where('user_id', $user->id)
            ->whereNull('check_out')
            ->first();

        if ($existingCheck) {
            return redirect()->route('c_in.checkin')->with('error', 'คุณได้เช็คอินแล้ว กรุณาเช็คเอาท์ก่อน!');
        }

        // บันทึกการเช็คอิน
        c_in::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->format('Y-m-d'),
            'check_in' => Carbon::now(),
        ]);

        // ดึงค่า rate จากตาราง employee
        $employee = Employee::where('user_id', $user->id)->first();
        $hourlyRate = $employee->hourly_rate ?? 0;

        // เพิ่ม record ในตาราง Work
        Work::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->toDateString(),
            'work_hours' => 0,
            'hourly_rate' => $hourlyRate,
            'total_amount' => 0,
        ]);

        return redirect()->route('c_in.checkin')->with('success', 'เช็คอินเรียบร้อย! เวลา: ' . Carbon::now()->format('H:i:s'));
    }

    public function checkOut(Request $request)
    {
        $user = Auth::user();

        $latestCheck = c_in::where('user_id', $user->id)
            ->whereNull('check_out')
            ->latest('id')
            ->first();

        if (!$latestCheck) {
            return redirect()->route('c_in.checkin')->with('error', 'ไม่มีการเช็คอินล่าสุด');
        }

        $checkIn = Carbon::parse($latestCheck->check_in)->timezone('Asia/Bangkok');
        $checkOut = Carbon::now()->timezone('Asia/Bangkok');

        if ($checkOut->lt($checkIn)) {
            return redirect()->route('c_in.checkin')->with('error', 'ไม่สามารถเช็คเอาท์ก่อนเวลาเช็คอินได้');
        }

        // คำนวณเวลาทำงาน (ชั่วโมง)
        $workMinutes = $checkIn->diffInMinutes($checkOut);
        $workHours = round($workMinutes / 60, 2);

        // อัปเดตข้อมูลเช็คเอาท์
        $latestCheck->update([
            'check_out' => $checkOut,
            'work_hours' => $workHours,
        ]);

        // ดึง rate จากตาราง employee
        $employee = Employee::where('user_id', $user->id)->first();
        $hourlyRate = $employee->hourly_rate ?? 0;

        // คำนวณยอดรวม
        $totalPay = $workHours * $hourlyRate;

        // อัปเดตตาราง Work ของวันนั้น
        $work = Work::where('user_id', $user->id)
            ->whereDate('date', $checkIn->toDateString())
            ->latest('id')
            ->first();

        if ($work) {
            $work->update([
                'work_hours' => $workHours,
                'hourly_rate' => $hourlyRate,
                'total_amount' => $totalPay,
            ]);
        }

        return redirect()->route('c_in.checkin')->with(
            'success',
            'เช็คเอาท์เรียบร้อย! ชั่วโมงทำงาน: ' . number_format($workHours, 2) . ' ชั่วโมง | รวมเงิน: ' . number_format($totalPay, 2) . ' บาท'
        );
    }
}
