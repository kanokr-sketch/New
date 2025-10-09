@extends('layouts.main')

@section('content')
<style>
    .profile-container {
        max-width: 700px;
        margin: 40px auto;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .profile-header img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin-right: 20px;
        object-fit: cover;
    }
    .profile-header h2 {
        margin: 0;
    }
    .profile-info label {
        font-weight: bold;
    }
    .profile-info div {
        margin-bottom: 10px;
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        <img src="{{ $employee->profile_image ? asset('storage/' . $employee->profile_image) : asset('images/default-profile.png') }}" alt="Profile Image">
        <h2>{{ $employee->name }}</h2>
    </div>

    <div class="profile-info">
        <div><label>อีเมล:</label> {{ $employee->email }}</div>
        <div><label>เพศ:</label> {{ $employee->gender ?? '-' }}</div>
        <div><label>เบอร์โทร:</label> {{ $employee->phone ?? '-' }}</div>
        <div><label>วันเกิด:</label> {{ $employee->birth_date ?? '-' }}</div>
        <div><label>ที่อยู่:</label> {{ $employee->address ?? '-' }}</div>
        <div><label>แผนก:</label> {{ $employee->department ?? '-' }}</div>
        <div><label>อัตราค่าจ้างต่อชั่วโมง:</label> {{ $employee->hourly_rate ? number_format($employee->hourly_rate, 2) . " บาท" : '-' }}</div>
        <div><label>ตำแหน่ง:</label> {{ $employee->role ?? '-' }}</div>
    </div>

    <div style="margin-top: 20px;">
        <a href="{{ route('employee.edit.profile') }}" class="btn" style="background:#4CAF50;color:white;padding:10px;border-radius:5px;text-decoration:none;">แก้ไขโปรไฟล์</a>
    </div>
</div>
@endsection
