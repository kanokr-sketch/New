@extends("layouts.main")
@section("content")

<h1>เงินเดือนของ {{ $employee->name }} เดือน {{ $month }}</h1>

<h2>รายได้ต่อวัน</h2>
<table>
    <tr>
        <th>วันที่</th>
        <th>ชั่วโมงทำงาน</th>
        <th>อัตราค่าจ้าง (บาท/ชั่วโมง)</th>
        <th>จำนวนเงิน (บาท)</th>
        <th>จัดการ</th>
    </tr>
    @foreach ($daily as $wh)
        <tr>
            <td>{{ $wh['date'] }}</td>
            <td>{{ $wh['hours'] }}</td>
            <td>{{ number_format($wh['rate'], 2) }}</td>
            <td>{{ number_format($wh['amount'], 2) }}</td>
            <td>
                <a class="edit-btn" href="{{ route('workhour.edit', $wh['id']) }}">แก้ไข</a><form action="{{ route('workhour.delete', $wh['id']) }}" method="POST">
                {{-- <a class="edit-btn" href="{{ route('workhour.edit', $wh['id']) }}">แก้ไข</a> --}}
                {{-- <form action="{{ route('workhour.delete', $wh['id']) }}" method="POST" onsubmit="return confirm('แน่ใจหรือไม่ว่าต้องการลบข้อมูลนี้?')"> --}}
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">ลบ</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<h2>รวมทั้งเดือน: {{ number_format($monthlySalary, 2) }} บาท</h2>

<br>
<a href="{{ route('admin.salary.employee.form') }}">⬅ กลับไปหน้าเลือกพนักงาน</a>

@endsection
