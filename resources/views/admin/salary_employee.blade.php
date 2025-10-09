@extends('layouts.main')

@section('content')
<div class="container" style="padding: 20px;">
    <h1 style="text-align: center;">เงินเดือนของ {{ $employee->user->name }}</h1>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #4CAF50; color: white;">
                <th style="padding: 10px; border: 1px solid #ddd;">เดือน</th>
                <th style="padding: 10px; border: 1px solid #ddd;">ชั่วโมงทำงาน</th>
                <th style="padding: 10px; border: 1px solid #ddd;">อัตราค่าจ้าง (บาท/ชั่วโมง)</th>
                <th style="padding: 10px; border: 1px solid #ddd;">เงินเดือนรวม (บาท)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $month }}</td>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $workHours }}</td>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ number_format($employee->hourly_rate, 2) }}</td>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ number_format($salary, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: center;">
        <a href="{{ route('admin.salary.employee.form') }}" style="padding: 8px 15px; background: #007BFF; color: white; text-decoration: none; border-radius: 5px;">
            กลับไปเลือกพนักงาน
        </a>
    </div>
</div>
@endsection
