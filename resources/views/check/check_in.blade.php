@extends("layouts.main")
@section("content")

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>พนักงาน - เช็คอิน/เช็คเอาท์</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <h1>ระบบเช็คอิน/เช็คเอาท์</h1>
    <p>ชื่อผู้ใช้: {{ auth()->user()->full_name ?? auth()->user()->name }}</p>
    {{-- <p>ตำแหน่งงาน: {{ auth()->user()->department ?? '-' }}</p>
    <p>เข้าสู่ระบบล่าสุด: {{ auth()->user()->last_login_at ?? '-' }}</p> --}}

    <hr>

    @php
    // ป้องกัน Undefined variable: ถ้า controller ไม่ส่ง latestCheck ให้เป็น null แทน
    $latestCheck = $latestCheck ?? null;
    $isCheckedIn = $latestCheck && $latestCheck->check_out === null;
    @endphp

    @if ($isCheckedIn)
    {{-- ปุ่มเช็คเอาท์ --}}
    <form method="POST" action="{{ route('c_in.checkout') }}">
        @csrf
        <button type="submit">เช็คเอาท์</button>
    </form>

    <p>เช็คอินเมื่อ: {{ optional($latestCheck->check_in)->toDateTimeString() ?? $latestCheck->check_in ?? '-' }}</p>
    <p><strong>สถานะ:</strong> กำลังทำงาน...</p>
    @else
    {{-- ปุ่มเช็คอิน --}}
    <form method="POST" action="{{ route('c_in.store') }}">
        @csrf
        <button type="submit">เช็คอิน</button><br>
    </form>

    @if ($latestCheck)
    <p>เช็คอินล่าสุด: {{ optional($latestCheck->check_in)->toDateTimeString() ?? $latestCheck->check_in }}</p>
    <p>เช็คเอาท์ล่าสุด: {{ optional($latestCheck->check_out)->toDateTimeString() ?? $latestCheck->check_out ?? '-' }}
    </p>

    @if (!empty($latestCheck->work_hours))
    <p><strong>เวลาทำงาน:</strong> {{ number_format($latestCheck->work_hours, 2) }} ชั่วโมง</p>
    @endif
    @else
    <p>ยังไม่มีบันทึกการเช็คอินล่าสุด</p>
    @endif
    @endif

    <hr>

    {{-- ปุ่มออกจากระบบ --}}
    {{-- <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">ออกจากระบบ</button>
    </form> --}}

    {{-- SweetAlert แจ้งเตือน --}}
    @if (session('success'))
    <script>
    Swal.fire({
        title: 'สำเร็จ!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'ตกลง'
    });
    </script>
    @endif

    @if (session('error'))
    <script>
    Swal.fire({
        title: 'เกิดข้อผิดพลาด!',
        text: "{{ session('error') }}",
        icon: 'error',
        confirmButtonText: 'ตกลง'
    });
    </script>
    @endif

    <script>
    window.history.forward();

    function noBack() {
        window.history.forward();
    }
    </script>

</body>

</html>
@endsection