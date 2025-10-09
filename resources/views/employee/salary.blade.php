@extends('layouts.main')
@section('content')
    <style>
        body {
            font-family: "Prompt", sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 60px auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="month"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }

        button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .logout-btn {
            background-color: #dc3545;
            margin-top: 15px;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        @media (max-width: 600px) {
            .container {
                margin: 30px 20px;
                padding: 20px;
            }
        }
    </style>

    <div class="container">
        <h1>สวัสดี {{ $employee->first_name ?? Auth::user()->name }}</h1>

        <form method="GET" id="salaryForm">
            <label>เลือกเดือนเพื่อคำนวณเงินเดือน:</label>
            <input type="month" name="month" id="month" required>
            <button type="submit">คำนวณเงินเดือน</button>
        </form>
    </div>

    <script>
        document.getElementById('salaryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const month = document.getElementById('month').value;
            if (month) {
                // ✅ ใช้ backtick เพื่อให้ template literal ทำงาน
                window.location.href = `/employee/salary/${month}`;
            }
        });
    </script>
@endsection
