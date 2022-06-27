@extends('dashboard.layouts.app')

@section('title')
    <title>Management</title>
@endsection

@section('page-title')
    Management
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Reachers Registration Request</h4>
                    </div>
                    <div class="card-body">
                        @if ($pending_teachers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pending_teachers as $key=>$teacher)
                                            <tr>
                                                <td><strong>{{ $key + 1 }}</strong></td>
                                                <td>{{ $teacher->name }}</td>
                                                <td><span class="badge light badge-success">{{ $teacher->email }}</span></td>
                                                <td>{{ $teacher->mobile }}</td>
                                                <td>
                                                    <a href="{{ route('admin.user.approve',encrypt($teacher->id)) }}" class="btn btn-success">Approve</a>
                                                    <a href="{{ route('admin.user.delete',encrypt($teacher->id)) }}" class="btn btn-danger userDeleteBtn">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="font-weight-bold">No Data Found!</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        {{-- All Teachers --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Active Teachers</h4>
                    </div>
                    <div class="card-body">
                        @if ($active_teachers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($active_teachers as $key=>$teacher)
                                            <tr>
                                                <td><strong>{{ $key + 1 }}</strong></td>
                                                <td>{{ $teacher->name }}</td>
                                                <td><span class="badge light badge-success">{{ $teacher->email }}</span></td>
                                                <td>{{ $teacher->mobile }}</td>
                                                <td>
                                                    <a href="{{ route('admin.user.approve',encrypt($teacher->id)) }}" class="btn btn-warning">Block</a>
                                                    <a href="{{ route('admin.user.delete',encrypt($teacher->id)) }}" class="btn btn-danger userDeleteBtn">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="font-weight-bold">No Data Found!</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        {{-- All Students --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Students</h4>
                    </div>
                    <div class="card-body">
                        @if ($students->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>Name</th>
                                            <th>Roll/ID</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $key=>$student)
                                            <tr>
                                                <td><strong>{{ $key + 1 }}</strong></td>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->roll_id_no }}</td>
                                                <td><span class="badge light badge-success">{{ $student->email }}</span></td>
                                                <td>{{ $student->mobile }}</td>
                                                <td>
                                                    <a href="{{ route('admin.user.approve',encrypt($student->id)) }}" class="btn btn-warning">Block</a>
                                                    <a href="{{ route('admin.user.delete',encrypt($student->id)) }}" class="btn btn-danger userDeleteBtn">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="font-weight-bold">No Data Found!</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $('.userDeleteBtn').click(function(event){
            event.preventDefault();
            if(confirm('Are You Sure To Delete This User') === true) {
                event.stopPropagation();
                window.location = $(this).attr("href");
            }
        });
    </script>
@endsection