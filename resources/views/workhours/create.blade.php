@extends("layouts.main")
@section("content")

<div style="max-width:800px;margin:auto;padding:20px;background:#fff;border-radius:8px;">
    <h1>เพิ่มชั่วโมงการทำงาน</h1>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <form id="workForm">
        <div class="entry">
            <label>พนักงาน:</label><br>
            <select id="employeeSelect" required>
                <option value="">-- เลือกพนักงาน --</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->first_name ?? $emp->user->name }}</option>
                @endforeach
            </select><br><br>

            <label>วันที่:</label><br>
            <input type="date" id="work_date" required><br><br>

            <label>จำนวนชั่วโมงทำงาน:</label><br>
            <input type="number" id="hours_worked" min="1" step="0.1" required><br><br>

            <button type="button" id="addToPreview" class="btn btn-success">➕ เพิ่ม</button>
        </div>
    </form>

    <table id="previewTable" class="table table-bordered" style="display:none;margin-top:20px;">
        <thead>
            <tr>
                <th>ชื่อพนักงาน</th>
                <th>วันที่</th>
                <th>จำนวนชั่วโมง</th>
                <th>ลบ</th>
            </tr>
        </thead>
        <tbody id="previewBody"></tbody>
    </table>

    <form action="{{ route('workhours.storeMultiple') }}" method="POST" id="finalForm">
        @csrf
        <button type="submit" id="saveAll" class="btn btn-primary" style="display:none;">💾 บันทึกทั้งหมด</button>
    </form>

    <br>
    <div style="margin-top: 20px; text-align: center;">
        <a href="{{ route('admin.salary.employee.form') }}" style="padding: 8px 15px; background: #007BFF; color: white; text-decoration: none; border-radius: 5px;">
            กลับไปเลือกพนักงาน
        </a>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#employeeSelect').select2({
        placeholder: "ค้นหาชื่อพนักงาน...",
        allowClear: true,
        width: '100%'
    });

    let entries = [];

    $('#addToPreview').click(function() {
        let empId = $('#employeeSelect').val();
        let empName = $('#employeeSelect option:selected').text();
        let date = $('#work_date').val();
        let hours = $('#hours_worked').val();

        if (!empId || !date || !hours) {
            alert('กรุณากรอกข้อมูลให้ครบ');
            return;
        }

        entries.push({ employee_id: empId, name: empName, work_date: date, hours_worked: hours });

        $('#previewBody').append(`
            <tr>
                <td>${empName}</td>
                <td>${date}</td>
                <td>${hours}</td>
                <td><button type="button" class="removeRow btn btn-danger btn-sm">ลบ</button></td>
            </tr>
        `);

        $('#previewTable').show();
        $('#saveAll').show();

        $('#employeeSelect').val('').trigger('change');
        $('#work_date').val('');
        $('#hours_worked').val('');
    });

    $(document).on('click', '.removeRow', function() {
        let rowIndex = $(this).closest('tr').index();
        entries.splice(rowIndex, 1);
        $(this).closest('tr').remove();
        if (entries.length === 0) {
            $('#previewTable').hide();
            $('#saveAll').hide();
        }
    });

    $('#finalForm').submit(function() {
        entries.forEach((e) => {
            $('#finalForm').append(`<input type="hidden" name="employee_id[]" value="${e.employee_id}">`);
            $('#finalForm').append(`<input type="hidden" name="work_date[]" value="${e.work_date}">`);
            $('#finalForm').append(`<input type="hidden" name="hours_worked[]" value="${e.hours_worked}">`);
        });
    });
});
</script>

@endsection
