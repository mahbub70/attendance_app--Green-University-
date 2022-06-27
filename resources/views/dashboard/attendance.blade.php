@extends('dashboard.layouts.app')

@section('title')
    <title>Attendance</title>
@endsection

@section('page-title')
    Manage Attendance
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
                            <h2 class="card-title">Departments</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <form>
                                    <div class="form-group">
                                        <select class="form-control form-control-lg default-select " name="department" id="department_id">
                                            <option selected disabled>Select Department</option>
                                            @foreach ($departments as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </form>
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
                                    <select class="form-control" id="semesterSelectBox">
                                        <option disabled selected>Select Semester</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <!-- Card -->
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Date </h2>
                        </div>
                        <div class="card-body">
                            <input name="datepicker" class="datepicker-default form-control" id="datepicker">
                        </div>
                    </div>
                    <!-- Card -->
                </div>
                <div class="row ">
                    <div class="card-body" style="margin-left: 450px;">
                        <button type="button" class="btn btn-success" id="attendanceSheetBtn">View</button>
                    </div>
                </div>
        </div>
        <!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Attendances</h4>
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
    // get semester via ajax
    $('#department_id').change(function(){
        var department_id = $(this).val();
        $.post("{{ route('getSemester.ajax') }}",{department_id:department_id}, function(data, status){
            if(status == 'success') {
                var response_data = jQuery.parseJSON(data);
                var options="";
                    options += `<option selected disabled>Select Students</option>`;

                    Object.keys(response_data).forEach((key, value) => {
                        options += `<option value="${response_data[key]['id']}">${response_data[key]['name']}</option>`;
                    });
                $('#semesterSelectBox').html(options);
            }
        });
    });

    $('#attendanceSheetBtn').click(function(){
        var department_id = $('#department_id').val();
        var semester_id  = $('#semesterSelectBox').val();
        var date = $('#datepicker').val();

        if(department_id == "" || date == "") {
            alert('All field is required');
        }else {
            $.post("{{ route('students.attendance.sheet') }}",{department_id:department_id,date:date,semester_id:semester_id}, function(data, status){
                if(status == 'success') {
                    var response_data = data;
                    $('#attendance-sheet-table').html(response_data);
                }
            });
        }
    });
</script>

@endsection