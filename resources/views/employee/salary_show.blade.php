@extends('layouts.main')

@section('content')
<style>
    body {
        font-family: "Prompt", sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 40px 0;
    }

    .container {
        max-width: 900px;
        margin: auto;
        background: #fff;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h1 {
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    h2 {
        color: #555;
        margin-top: 30px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 15px;
    }

    th, td {
        border: 1px solid #aaa;
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .total {
        font-weight: bold;
        background-color: #ffe082;
    }

    .back-btn {
        display: inline-block;
        margin-top: 25px;
        padding: 10px 20px;
        border-radius: 6px;
        background-color: #007BFF;
        color: white;
        text-decoration: none;
        transition: background 0.3s;
    }

    .back-btn:hover {
        background-color: #0056b3;
    }
</style>

<div class="container">
    <h1>เงินเดือนของ {{ $employee->name }} เดือน {{ date('F Y', strtotime($month)) }}</h1>

    @if(count($workHours) > 0)
        <h2>รายได้ต่อวัน</h2>
        <table>
            <tr>
                <th>วันที่</th>
                <th>ชั่วโมงทำงาน</th>
                <th>อัตราค่าจ้าง (บาท/ชั่วโมง)</th>
                <th>จำนวนเงิน (บาท)</th>
            </tr>
            @foreach($workHours as $wh)
                <tr>
                    <td>{{ date('d-m-Y', strtotime($wh->check_in)) }}</td>
                    <td>{{ $wh->work_hours}}</td>
                    <td>{{ number_format($employee->hourly_rate, 2) }}</td>
                    <td>{{ number_format($wh->work_hours * $employee->hourly_rate, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3">รวมทั้งเดือน</td>
                <td>{{ number_format($monthlySalary, 2) }} บาท</td>
            </tr>
        </table>
    @else
        <p style="color:red; text-align:center;">ไม่มีข้อมูลการทำงานในเดือนนี้</p>
    @endif

    <a href="{{ route('employee.salary') }}" class="back-btn">⬅ กลับไปหน้าเลือกเดือน</a>
</div>
@endsection
