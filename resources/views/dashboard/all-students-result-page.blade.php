@extends('dashboard.layouts.app')

@section('title')
    <title>Students Result View</title>
@endsection

@section('page-title')
    Result View
@endsection

@section('css')
    
@endsection

@section('page-content')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles markWrap">
            @if (session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            {{-- Student Select Options --}}
            <div class="row">
                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Select Department</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group"> 
                                    <select class="form-control" name="department_id" id="department_id">
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
                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Select Semester</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <select class="form-control" id="selectSemester" name="semester_id">
                                        <option selected disabled>Select One</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Select Students</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <select class="form-control" id="studentsSelectBox" name="student_id">
                                        <option selected disabled>Select One</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Select Subject</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <select class="form-control" id="subjectSelectBox" name="subject_id">
                                        <option selected disabled>Select One</option>
                                        @foreach ($subjects as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row ">
                    <div class="card-body" style="margin-left: 450px;">
                        <button type="button" class="btn btn-success" id="studentResultBtn">View</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Student Result</h4>
                        </div>
                        <div class="card-body">
                            <div id="student-result-table">
                                
                            </div>
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

    // get Result Via ajax
    $('#studentResultBtn').click(function(){
        var semester_id = $("#selectSemester").val();
        var department_id = $('#department_id').val();
        var subject_id = $('#subjectSelectBox').val();
        var student_id = $('#studentsSelectBox').val();
        if($('#department_id').val() == "" || $('#selectSemester').val() == "" || $('#selectSemester').val() == null || $('#studentsSelectBox').val() == "" || $('#studentsSelectBox').val() == null || $('#subjectSelectBox').val() == "" || $('#subjectSelectBox').val() == null) {
            alert('All Field is Required!');
        }else {
            $.post("{{ route('all.student.result.ajax') }}",{department_id:department_id,semester_id:semester_id,student_id:student_id,subject_id:subject_id}, function(data, status){
                if(status == 'success') {
                    $('#student-result-table').html(data);
                }
            });
        }
    });

    </script>
@endsection

