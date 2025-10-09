@extends('layouts.main')

@section('content')
<div style="margin: 20px; font-family: 'Prompt', sans-serif;">
    <h1>เงินเดือนพนักงานทั้งหมด เดือน {{ date('F Y', strtotime($month)) }}</h1>

    <table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
        <thead style="background: #f2f2f2;">
            <tr>
                <th>ชื่อพนักงาน</th>
                {{-- <th>รายละเอียด</th> --}}
                <th>เงินเดือนรวม (บาท)</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salaries as $data)
                <tr>
                    <td>{{ $data['employee']->name }}</td>
                    {{-- <td>
                        @foreach ($data['workHours'] as $wh)
                            วันที่ {{ date('d-m-Y', strtotime($wh->date)) }}: {{ $wh->work_hours }} ชั่วโมง<br>
                        @endforeach
                    </td> --}}
                    <td>{{ number_format($data['totalSalary'], 2) }}</td>
                    <td>
                        <a href="{{ route('admin.salary.employee.show', $data['employee']->id) }}?month={{ $month }}" style="color: blue;">ดูรายละเอียด</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.salary.employee.form') }}" style="color: blue;">⬅ กลับไปหน้าเลือกพนักงาน</a>
</div>
@endsection
