
@if ($result != null)
<div class="table-responsive">
    <table id="" class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Department</th>
                <th>Semester</th>
                <th>Subject</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $result->student->name }}</td>
                <td>{{ $result->department->name }}</td>
                <td>{{ $result->semester->name }}</td>
                <td>{{ $result->subject->name }}</td>												
                <td><span class="badge badge-primary">{{ $result->grade }}</span></td>												
            </tr>
        </tbody>
    </table>
</div>
    
@else
    <div class="text-center">No Data Found!</div>
@endif