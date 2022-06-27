
<div class="table-responsive">
    <form action="{{ route('students.attendance.submit') }}" method="POST">
        <p>Click Checkbox If Student is Present.</p>
        @csrf
        <input type="hidden" value="{{ $date }}" name="date">
        <input type="hidden" value="{{ $department_id }}" name="department_id">
        <input type="hidden" value="{{ $semester_id }}" name="semester_id">
        <table id="" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Roll No</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $key=>$student)
                    <input type="hidden" value="{{ $student->id }}" name="ids[]">
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $student->roll_id_no }}</td>
                        <td>{{ $student->name }}</td>
                        <td>
                            <div class="form-group text-center">
                                <input type="checkbox" name="present_students[]" class="form-check-input" value="{{ $student->id }}">
                            </div>
                        </td>												
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>