@extends('layouts.main')

@section('content')
<div style="margin:20px;">
    <h2>แก้ไขชั่วโมงการทำงาน</h2>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('workhour.update', $work->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>วันที่: </label>
            <input type="text" value="{{ $work->date }}" disabled>
        </div>

        <div>
            <label>ชั่วโมงทำงาน:</label>
            <input type="number" name="work_hours" step="0.01" value="{{ $work->work_hours }}" required>
            @error('work_hours')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top:10px;">
            <button type="submit" style="padding:5px 10px;background:blue;color:white;border:none;border-radius:5px;">
                บันทึกการแก้ไข
            </button>
            <a href="{{ url()->previous() }}" style="margin-left:10px;color:red;">ย้อนกลับ</a>
        </div>
    </form>
</div>
@endsection
