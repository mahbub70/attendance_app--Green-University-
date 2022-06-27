@extends('dashboard.layouts.app')

@section('title')
    <title>Students Result Make</title>
@endsection

@section('page-title')
    Result Summer <?=(date('Y',time()))?>
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
            <form action="{{ route('students.result.add') }}" method="post" id="student_result_form">
                @csrf
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
                                    <select class="form-control @error('department_id') is-invalid @enderror" name="department_id" id="department_id">
                                        <option selected disabled>Select Department</option>
                                        @foreach ($departments as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                    <select class="form-control @error('semester_id') is-invalid @enderror" id="selectSemester" name="semester_id">
                                        <option selected disabled>Select One</option>
                                    </select>
                                    @error('semester_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                    <select class="form-control @error('student_id') is-invalid @enderror" id="studentsSelectBox" name="student_id">
                                        <option selected disabled>Select One</option>
                                    </select>
                                    @error('student_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                    <select class="form-control @error('subject_id') is-invalid @enderror" id="subjectSelectBox" name="subject_id">
                                        <option selected disabled>Select One</option>
                                        @foreach ($subjects as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Select Marks --}}
            <div class="row">
                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Class Test</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <input type="text" class="form-control input-default classTestInput @error('class_test_one') is-invalid @enderror" placeholder="input Mark" name="class_test_one" value="{{ old('class_test_one') }}">
                                    @error('class_test_one')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-default classTestInput @error('class_test_two') is-invalid @enderror" placeholder="input Mark" name="class_test_two" value="{{ old('class_test_two') }}">
                                    @error('class_test_two')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-default classTestInput @error('class_test_three') is-invalid @enderror" placeholder="input Mark" name="class_test_three" value="{{ old('class_test_three') }}">
                                    @error('class_test_three')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>                                            
                                <div class="form-group">
                                    <input type="text" class="form-control input-default classTestAvg markInput @error('class_test_avg') is-invalid @enderror" placeholder="Avg." readonly name="class_test_avg" value="{{ old('class_test_avg') }}">
                                    @error('class_test_avg')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Assingnment</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <input type="text" class="form-control input-default markInput asignment @error('assingment') is-invalid @enderror" placeholder="input Mark" name="assingment" value="{{ old('assingment') }}">
                                    @error('assingment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Presentation</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <input type="text" class="form-control input-default markInput presentation @error('presentation') is-invalid @enderror" placeholder="input Mark" name="presentation" value="{{ old('presentation') }}">
                                    @error('presentation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Attendance</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <input type="text" class="form-control input-default markInput attendance @error('attendance') is-invalid @enderror"  placeholder="input Mark" name="attendance" value="{{ old('attendance') }}">
                                    @error('attendance')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Midterm</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <input type="text" class="form-control input-default markInput midterm @error('midterm') is-invalid @enderror" placeholder="input Mark" name="midterm" value="{{ old('midterm') }}">
                                    @error('midterm')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Final </h2>
                            
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <input type="text" class="form-control input-default markInput final @error('final') is-invalid @enderror" placeholder="input Mark" name="final" value="{{ old('final') }}">
                                    @error('final')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Total</h2>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <input type="text" class="form-control input-default totalMarks @error('total') is-invalid @enderror" placeholder="input Mark" readonly name="total" value="{{ old('total') }}">
                                    @error('total')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Grade</h2>
                            
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="form-group">
                                    <input type="text" class="form-control input-default gradeInput @error('grade') is-invalid @enderror" placeholder="Grade" readonly name="grade">
                                    @error('grade')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row ">
                <div class="card-body" style="margin-left: 450px;">
                    <button type="submit" class="btn btn-success" id="resultSubmitBtn">Submit</button>
                </div>
            </div>
            <!-- row -->
            </form>
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

    // Calculation ClassTest
    var division = 0;
    var classTestTotal = 0;
    $('.classTestInput').keyup(function(){
        var allClassTestInput = $('.classTestInput');
        division = 0;
        classTestTotal = 0;
        var avg = 0;
        $.each(allClassTestInput,function(index){
            if($(this).val() > 15) {
                alert('Class Test Number Must be less then or Equal 15.');
                $(this).val("");
            }else { 
                if($(this).val() != "") {
                    division++;
                    classTestTotal = +classTestTotal + +$(this).val();
                }
            }
        });
        avg = classTestTotal / division;
        $('.classTestAvg').val(avg);

    });


    // Check Validity
    $('.asignment, .presentation,.attendance').keyup(function(){
        if($(this).val() > 5) {
            alert('Please Enter less then or equal 5.');
            $(this).val("");
        }
    });

    $('.midterm').keyup(function(){
        if($(this).val() > 30) {
            alert('Please Enter less then or equal 30.');
            $(this).val("");
        }
    });

    $('.final').keyup(function(){
        if($(this).val() > 40) {
            alert('Please Enter less then or equal 40.');
            $(this).val("");
        }
    });

    // Calculate Total marks
    var totalMarks = 0;
    $('.markInput').keyup(function(){
        totalMarks = 0;
        var allMarkInput = $('.markWrap .markInput');

        $.each(allMarkInput,function(index){
            if($(this).val() != "") {
                totalMarks = +totalMarks + +$(this).val();
            }
        });

        $('.totalMarks').val(totalMarks);
        $('.totalMarks').change();
    });

    // Calculate Grade
    $('.totalMarks').change(function(){
        var totalMarks = $(this).val();
        if(totalMarks < 50) {
            $('.gradeInput').val('F');
        }else if(totalMarks >= 50 && totalMarks <=54) {
            $('.gradeInput').val('D');
        }else if(totalMarks >= 55 && totalMarks <= 59) {
            $('.gradeInput').val('C-');
        }else if(totalMarks >= 60 && totalMarks <= 64) {
            $('.gradeInput').val('C');
        }else if(totalMarks >= 65 && totalMarks <= 69) {
            $('.gradeInput').val('C+');
        }else if(totalMarks >= 70 && totalMarks <= 74) {
            $('.gradeInput').val('B-');
        }else if(totalMarks >= 75 && totalMarks <= 79) {
            $('.gradeInput').val('B');
        }else if(totalMarks >= 80 && totalMarks <= 84) {
            $('.gradeInput').val('B+');
        }else if(totalMarks >= 85 && totalMarks <= 89) {
            $('.gradeInput').val('A-');
        }else if(totalMarks >= 90 && totalMarks <= 94) {
            $('.gradeInput').val('A');
        }else if(totalMarks >= 95 && totalMarks <= 100) {
            $('.gradeInput').val('A+');
        }
    });

    // Submit Button
    $('#resultSubmitBtn').click(function(event){
        event.preventDefault();
        if($('#department_id').val() == "" || $('#selectSemester').val() == "" || $('#selectSemester').val() == null || $('#studentsSelectBox').val() == "" || $('#studentsSelectBox').val() == null || $('#subjectSelectBox').val() == "" || $('#subjectSelectBox').val() == null || $('.totalMarks').val() == "" || $('.totalMarks').val() == null) {
            alert('Department, Semester, Students, Subject and Total Marks is Requird!');
        }else {
            event.stopPropagation();
            $('#student_result_form').submit();
        }
    })
    </script>
@endsection

