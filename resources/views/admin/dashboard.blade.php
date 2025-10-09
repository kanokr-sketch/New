@extends('layouts.main')

@section('content')
    <h2>หน้าจอเช็คอิน</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">สถานะการเช็คอินล่าสุด</h5>

            @if($latestCheck)
                <p><strong>วันที่:</strong> {{ $latestCheck->date }}</p>
                <p><strong>เวลาเช็คอิน:</strong> {{ \Carbon\Carbon::parse($latestCheck->check_in)->format('H:i:s') }}</p>
                @if($latestCheck->check_out)
                    <p><strong>เวลาเช็คเอาท์:</strong> {{ \Carbon\Carbon::parse($latestCheck->check_out)->format('H:i:s') }}</p>
                    <p><strong>จำนวนชั่วโมง:</strong> {{ $latestCheck->work_hours }} ชั่วโมง</p>
                @else
                    <p>คุณยังไม่ได้เช็คเอาท์</p>
                @endif
            @else
                <p>ยังไม่มีการเช็คอิน</p>
            @endif

            <form method="POST" action="{{ route('c_in.store') }}">
                @csrf
                <button type="submit" class="btn btn-success">✅ เช็คอิน</button>
            </form>

            <form method="POST" action="{{ route('c_in.checkout') }}" style="margin-top:10px;">
                @csrf
                <button type="submit" class="btn btn-danger">🚪 เช็คเอาท์</button>
            </form>
        </div>
    </div>
@endsection
