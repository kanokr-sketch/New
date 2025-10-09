@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>เงินเดือนของ {{ $employee->name }} ประจำเดือน {{ date('F Y', strtotime($month)) }}</h2>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>วันที่</th>
                <th>ชั่วโมงทำงาน</th>
                <th>อัตราต่อชั่วโมง</th>
                <th>รวมต่อวัน</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daily as $d)
            <tr>
                <td>{{ $d['date'] }}</td>
                <td>{{ $d['hours'] }}</td>
                <td>{{ number_format($d['rate'], 2) }}</td>
                <td>{{ number_format($d['amount'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="mt-4">💰 รวมทั้งเดือน: {{ number_format($monthlySalary, 2) }} บาท</h4>
</div>
@endsection
