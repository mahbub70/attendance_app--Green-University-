@extends('dashboard.layouts.app')

@section('title')
    <title>Attendance Report</title>
@endsection

@section('page-title')
    Attendance Report
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('dashboard/vendor/pickadate/themes/default.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/vendor/pickadate/themes/default.date.css') }}">
 <!-- Daterange picker -->
<link href="{{ asset('dashboard/vendor/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('page-content')
<div class="content-body">
    <div class="container-fluid">
        @if (session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
        <div class="page-titles">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-xl-4 mb-3">
                                    <div class="example">
                                        <p class="mb-1"> Select Date </p>
                                        <input class="form-control input-daterange-datepicker" type="text" name="daterange">
                                    </div>
                                </div>
                                    <a href="javascript:void(0)" class="btn btn-primary btn-lg " id="generateReportBtn">Generate Report<i class="las la-angle-right ml-3 scale5"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                    <!-- Card -->

        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Attendance Report</h4>
                    </div>
                    <div class="card-body">
                        <div id="studentsAttendanceReport"></div>
                    </div>
                </div>
            </div>
            </div>

    </div>
</div>

@endsection

@section('js')

    <script src="{{ asset('dashboard/vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- clockpicker -->
    <script src="{{ asset('dashboard/vendor/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>
    <!-- asColorPicker -->
    <script src="{{ asset('dashboard/vendor/jquery-asColor/jquery-asColor.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/jquery-asGradient/jquery-asGradient.min.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/jquery-asColorPicker/js/jquery-asColorPicker.min.js') }}"></script>

    <script src="{{ asset('dashboard/vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    <!-- pickdate -->
    <script src="{{ asset('dashboard/vendor/pickadate/picker.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/pickadate/picker.date.js') }}"></script>



    <!-- Daterangepicker -->
    <script src="{{ asset('dashboard/js/plugins-init/bs-daterange-picker-init.js') }}"></script>
    <!-- Clockpicker init -->
    <script src="{{ asset('dashboard/js/plugins-init/clock-picker-init.js') }}"></script>
    <!-- asColorPicker init -->
    <script src="{{ asset('dashboard/js/plugins-init/jquery-asColorPicker.init.js') }}"></script>
    <!-- Material color picker init -->
    <script src="{{ asset('dashboard/js/plugins-init/material-date-picker-init.js') }}"></script>
    <!-- Pickdate -->
    <script src="{{ asset('dashboard/js/plugins-init/pickadate-init.js') }}"></script>
    
<script>
    $('#generateReportBtn').click(function(){
        var dateRange = $('.input-daterange-datepicker').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if(dateRange == "") {
            alert('Date is Empty. Please fill the date');
        }else {
            $.post("{{ route('students.attendance.result.load') }}",{date_range:dateRange}, function(data, status){
                if(status == 'success') {
                    var response_data = data;
                    $('#studentsAttendanceReport').html(response_data);
                }
            });
        }
    });
</script>

@endsection