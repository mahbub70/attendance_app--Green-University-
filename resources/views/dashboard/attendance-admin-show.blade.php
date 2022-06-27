@extends('dashboard.layouts.app')

@section('title')
    <title>Attendance</title>
@endsection

@section('page-title')
    Attendance Report
@endsection

@section('css')
    
@endsection

@section('page-content')
<div class="content-body">
    <div class="container-fluid">
        {{-- Teacher Pending Request --}}
        @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
        <div class="page-titles">
            <div class="row">
                <div class="col-xl-4 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Select Department</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <select class="form-control form-control-lg default-select " name="department" id="department_id">
                                        <option selected disabled>Select Department</option>
                                        @foreach ($departments as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Select Semester</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <select class="form-control" id="selectSemester">
                                        <option selected disabled>Select One</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Select Students</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <select class="form-control" id="studentsSelectBox">
                                        <option selected disabled>Select One</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row ">
                    <div class="card-body" style="margin-left: 450px;">
                        <button type="button" class="btn btn-success" id="studentsAttendanceShowBtn">View</button>
                    </div>
                </div>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Attendances Result</h4>
                    </div>
                    <div class="card-body">
                        <div id="attendance-sheet-table">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#department_id').change(function(){
        var department_id = $(this).val();
        $.post("{{ route('getSemester.ajax') }}",{department_id:department_id}, function(data, status){
            if(status == 'success') {
                var response_data = jQuery.parseJSON(data);
                var options="";
                    options += `<option selected disabled>Select Semester</option>`;

                    Object.keys(response_data).forEach((key, value) => {
                        options += `<option value="${response_data[key]['id']}">${response_data[key]['name']}</option>`;
                    });
                $('#selectSemester').html(options);
            }
        });
    });

    $('#selectSemester').change(function(){
        var semester_id = $(this).val();
        var department_id = $('#department_id').val();

        if(department_id == "" || semester_id == "") {
            alert('All field is required');
        }else {
            $.post("{{ route('getStudents.ajax') }}",{department_id:department_id,semester_id:semester_id}, function(data, status){
                if(status == 'success') {
                    var response_data = jQuery.parseJSON(data);
                    var options="";
                        options += `<option selected disabled>Select Students</option>`;

                        Object.keys(response_data).forEach((key, value) => {
                            options += `<option value="${response_data[key]['id']}">${response_data[key]['name']}</option>`;
                        });
                    $('#studentsSelectBox').html(options);
                }
            });
        }
    });

    $('#studentsAttendanceShowBtn').click(function(){
        var department_id = $('#department_id').val();
        var student_id = $('#studentsSelectBox').val();

        $.post("{{ route('admin.getAttendanceAjax') }}",{department_id:department_id,student_id:student_id},function(data,status){
            if(status == 'success') {
                $('#attendance-sheet-table').html(data);
            }else {
                alert('Something Worng! Please try again.');
            }
        });
    });
</script>



@endsection