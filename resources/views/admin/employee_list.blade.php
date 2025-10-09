@extends('layouts.main')

@section('content')
<div class="container" style="margin-top:30px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>รายชื่อพนักงานทั้งหมด</h2>
        <a href="{{ route('admin.employee.create') }}" 
           style="background-color:#4CAF50;color:white;padding:10px 16px;border-radius:6px;text-decoration:none;">
           + เพิ่มพนักงาน
        </a>
    </div>

    @if(session('success'))
        <div style="color:green; margin-bottom:10px;">{{ session('success') }}</div>
    @endif

    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <thead style="background-color:#f0f0f0;">
            <tr>
                <th>รูปโปรไฟล์</th>
                <th>ชื่อ</th>
                <th>อีเมล</th>
                <th>เพศ</th>
                <th>เบอร์โทร</th>
                <th>วันเกิด</th>
                <th>ที่อยู่</th>
                <th>แผนก</th>
                <th>ค่าจ้าง/ชม.</th>
                <th>Role</th>
                <th>การจัดการ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>
                        @if($employee->profile_image)
                            <img src="{{ asset('storage/'.$employee->profile_image) }}" width="50" height="50" style="border-radius:50%;">
                        @else
                            <span>ไม่มีรูป</span>
                        @endif
                    </td>
                    <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->gender ?? '-' }}</td>
                    <td>{{ $employee->phone ?? '-' }}</td>
                    <td>{{ $employee->birth_date ?? '-' }}</td>
                    <td>{{ $employee->address ?? '-' }}</td>
                    <td>{{ $employee->department ?? '-' }}</td>
                    <td>{{ $employee->hourly_rate ? number_format($employee->hourly_rate, 2) : '-' }}</td>
                    <td>{{ ucfirst($employee->role) }}</td>
                    <td style="text-align:center;">
                        <a href="{{ route('admin.employee.edit', $employee->id) }}"
                           style="background-color:#ffc107;color:black;padding:6px 10px;border-radius:4px;text-decoration:none;">
                           แก้ไข
                        </a>
                        <form action="{{ route('admin.employee.destroy', $employee->id) }}"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('ต้องการลบพนักงานคนนี้หรือไม่?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="background-color:#dc3545;color:white;border:none;padding:6px 10px;border-radius:4px;cursor:pointer;">
                                ลบ
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
