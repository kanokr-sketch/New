@extends('layouts.main')

@section('content')
<style>
    body { font-family: "Prompt", sans-serif; background-color: #f5f5f5; }
    .container {
        max-width: 600px; margin: 40px auto; background: #fff;
        padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    label { display:block; margin-bottom:6px; font-weight:bold; }
    input, select, textarea {
        width:100%; padding:10px; margin-bottom:15px;
        border:1px solid #ccc; border-radius:6px;
    }
    button {
        width:100%; background:#4CAF50; color:white; padding:12px;
        border:none; border-radius:6px; font-size:16px;
    }
    button:hover { background:#45a049; }
</style>

<div class="container">
    <h2 style="text-align:center; margin-bottom:20px;">เพิ่มพนักงานใหม่</h2>

    <form method="POST" action="{{ route('admin.employee.store') }}" enctype="multipart/form-data">
        @csrf

        <label>ชื่อ - นามสกุล</label>
        <input type="text" name="name" required>

        <label>อีเมล</label>
        <input type="email" name="email" required>

        <label>รหัสผ่าน</label>
        <input type="password" name="password" min = "5"required>

        <label>เพศ</label>
        <select name="gender">
            <option value="">-- เลือกเพศ --</option>
            <option value="ชาย">ชาย</option>
            <option value="หญิง">หญิง</option>
            <option value="อื่นๆ">อื่นๆ</option>
        </select>

        <label>เบอร์โทรศัพท์</label>
        <input type="text" name="phone">

        <label>วันเกิด</label>
        <input type="date" name="birth_date">

        <label>ที่อยู่</label>
        <textarea name="address" rows="3"></textarea>

        <label>แผนก (Department)</label>
        <input type="text" name="department">

        <label>อัตราค่าจ้างต่อชั่วโมง (บาท)</label>
        <input type="number" step="0.01" name="hourly_rate">

        <label>ตำแหน่ง</label>
        <select name="role" required>
            <option value="employee">Employee</option>
            <option value="admin">Admin</option>
        </select>

        <label>รูปโปรไฟล์</label>
        <input type="file" name="profile_image" accept="image/*">

        <button type="submit">บันทึกข้อมูล</button>
    </form>

    <div style="text-align:center; margin-top:15px;">
        <a href="{{ route('admin.employee.list') }}" style="color:#555; text-decoration:none;">⬅ กลับไปหน้ารายชื่อ</a>
    </div>
</div>
@endsection
