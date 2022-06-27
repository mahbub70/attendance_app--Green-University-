@extends('dashboard.layouts.app')

@section('title')
    <title>Students Result</title>
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

            @if ($student_result->count() == 0)
                <div>No Data Found!</div>
            @else
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Result</h4>
                        </div>
                        <div class="card-body">
                            <div id="student-result-table">
                                <div class="table-responsive">
                                    <table id="" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Semester</th>
                                                <th>Subject</th>
                                                <th>Total Marks</th>
                                                <th>Result</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($student_result as $key=>$item)
                                                <tr>
                                                    <td>{{ $item->student->name }}</td>
                                                    <td>{{ $item->department->name }}</td>
                                                    <td>{{ $item->semester->name }}</td>
                                                    <td>{{ $item->subject->name }}</td>											
                                                    <td>{{ $item->total }}</td>											
                                                    <td><span class="badge badge-primary">{{ $item->grade }}</span></td>												
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Result Details</h4>
                        </div>
                        <div class="card-body">
                            <div id="student-result-table">
                                <div class="table-responsive">
                                    <table id="" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>1st C. T.</th>
                                                <th>2nd C. T.</th>
                                                <th>3rd C. T.</th>
                                                <th>C.T Avg.</th>
                                                <th>Assingment</th>
                                                <th>Presentation</th>
                                                <th>Attendance</th>
                                                <th>Midterm</th>
                                                <th>Final</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($student_result as $key=>$item)
                                                <tr>
                                                    <td>{{ $item->class_test_one }}</td>
                                                    <td>{{ $item->class_test_two }}</td>
                                                    <td>{{ $item->class_test_three }}</td>
                                                    <td>{{ $item->class_test_avg }}</td>			
                                                    <td>{{ $item->assingment }}</td>	
                                                    <td>{{ $item->presentation }}</td>			
                                                    <td>{{ $item->attendance }}</td>	
                                                    <td>{{ $item->midterm }}</td>	
                                                    <td>{{ $item->final }}</td>												
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection


@section('js')

@endsection

