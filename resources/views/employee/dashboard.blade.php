@extends('layouts.main')

@section('content')
<h1>หน้าเช็คอิน/เช็คเอาท์</h1>
<p>ยินดีต้อนรับ, {{ auth()->user()->name }}</p>

<hr>

@if (session('success'))
    <div style="color: green;">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div style="color: red;">{{ session('error') }}</div>
@endif

@if ($latestCheck)
    @php $isCheckedIn = $latestCheck->check_out === null; @endphp

    @if ($isCheckedIn)
        <p>เช็คอินเมื่อ: {{ $latestCheck->check_in }}</p>
        <p><strong>สถานะ:</strong> กำลังทำงาน...</p>
        <form method="POST" action="{{ route('c_in.checkout') }}">
            @csrf
            <button type="submit">เช็คเอาท์</button>
        </form>
    @else
        <p>เช็คอินล่าสุด: {{ $latestCheck->check_in }}</p>
        <p>เช็คเอาท์ล่าสุด: {{ $latestCheck->check_out }}</p>
        <p><strong>เวลาทำงาน:</strong> {{ $latestCheck->work_hours ?? '-' }} ชั่วโมง</p>
        <form method="POST" action="{{ route('c_in.store') }}">
            @csrf
            <button type="submit">เช็คอิน</button>
        </form>
    @endif
@else
    <p>ยังไม่มีการเช็คอิน</p>
    <form method="POST" action="{{ route('c_in.store') }}">
        @csrf
        <button type="submit">เช็คอิน</button>
    </form>
@endif
@endsection
