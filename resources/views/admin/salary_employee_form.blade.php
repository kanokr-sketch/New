@extends("layouts.main")
@section("content")

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เลือกพนักงาน</title>

    <!-- ✅ Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: "Prompt", sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        select, input[type="month"], button {
            margin-top: 5px;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background-color: #45a049;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
        }
        .form-container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 400px;
        }
        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>เลือกพนักงานและเดือน</h1>

        @if(session('success'))
            <p style="color:green;">{{ session('success') }}</p>
        @endif

        <!-- ฟอร์มเลือกพนักงานและเดือน -->
       <form method="GET" id="salaryForm">
            <label>พนักงาน:</label>
            <select name="employeeId" id="employeeId" style="width:100%;" required>
                <option value="">-- เลือกพนักงาน --</option>
                @foreach($employees as $employee)
                    {{-- <option value="{{ $employee->id }}">{{ $employee->user->name }}</option> --}}
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>

            <label>เดือน:</label>
            <input type="month" name="month" id="month" value="{{ date('Y-m') }}" required>

            <button type="submit">คำนวณเงินเดือน</button>
        </form>

        <!-- ลิงก์อื่นๆ -->
        <br>
        <a href="{{ route('workhours.create') }}">➕ เพิ่มชั่วโมงการทำงาน</a><br>
        {{-- <a href="{{ route('admin.salary.all') }}">📊 รายงานรายได้สะสมทั้งหมด</a> --}}

        <form action="{{ route('admin.salary.all') }}" method="GET">
    <label>เลือกเดือน:</label>
    <input type="month" name="month" required>
    <button type="submit">คำนวณเงินเดือนทั้งหมด</button>
</form>

    </div>

    <!-- ✅ jQuery + Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // เปิดให้พิมพ์ค้นหา
            $('#employee').select2({
                placeholder: "พิมพ์เพื่อค้นหาพนักงาน...",
                allowClear: true,
                width: 'resolve'
            });

            // เมื่อ submit เปลี่ยน route ตาม id และเดือน
document.getElementById('salaryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const employeeId = document.getElementById('employeeId').value;
    const month = document.getElementById('month').value;
    if (employeeId && month) {
        window.location.href = `/admin/salary/employee/${employeeId}?month=${month}`;
    }
});
        });
    </script>
</body>
</html>
@endsection