@extends('layouts.main')

@section('content')
<style>
    .container {
        max-width: 600px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    label { display:block; margin-bottom:6px; font-weight:bold; }
    input, select, textarea {
        width:100%; padding:10px; margin-bottom:15px;
        border:1px solid #ccc; border-radius:6px;
    }
    button {
        width:100%; background:#007bff; color:white; padding:12px;
        border:none; border-radius:6px; font-size:16px;
    }
    button:hover { background:#0056b3; }
</style>

<div class="container">
    <h2 style="text-align:center; margin-bottom:20px;">แก้ไขข้อมูลพนักงาน</h2>

    <form method="POST" action="{{ route('admin.employee.update', $employee->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ชื่อ และอีเมล แสดงเฉย ๆ แก้ไม่ได้ --}}
        <label>ชื่อ - นามสกุล</label>
        <input type="text" name="name" value="{{ $employee->name }}" readonly>

        <label>อีเมล</label>
        <input type="email" name="email" value="{{ $employee->email }}" readonly>

        {{-- ข้อมูลอื่น ๆ แสดงแต่แก้ไม่ได้ --}}
        <label>เพศ</label>
        <input type="text" value="{{ $employee->gender }}" readonly>

        <label>เบอร์โทรศัพท์</label>
        <input type="text" value="{{ $employee->phone }}" readonly>

        <label>วันเกิด</label>
        <input type="date" value="{{ $employee->birth_date }}" readonly>

        <label>ที่อยู่</label>
        <textarea rows="3" readonly>{{ $employee->address }}</textarea>

        {{-- ✅ แก้ไขได้เฉพาะส่วนนี้ --}}
        <label>แผนก (Department)</label>
        <input type="text" name="department" value="{{ $employee->department }}">

        <label>อัตราค่าจ้างต่อชั่วโมง (บาท)</label>
        <input type="number" step="0.01" name="hourly_rate" value="{{ $employee->hourly_rate }}">

        <label>ตำแหน่ง</label>
        <select name="role" required>
            <option value="employee" {{ $employee->role == 'employee' ? 'selected' : '' }}>Employee</option>
            <option value="admin" {{ $employee->role == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>

        <label>รูปโปรไฟล์</label>
        <input type="file" name="profile_image" accept="image/*">

        <button type="submit">อัปเดตข้อมูล</button>
    </form>

    <div style="text-align:center; margin-top:15px;">
        <a href="{{ route('admin.employee.list') }}" style="color:#555; text-decoration:none;">⬅ กลับไปหน้ารายชื่อ</a>
    </div>
</div>
@endsection
