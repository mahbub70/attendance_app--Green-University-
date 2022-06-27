@extends('dashboard.layouts.app')

@section('title')
    <title>Departments</title>
@endsection

@section('page-title')
    Departments
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Departments</h4>
                        <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#addNewDepartment">Add New Department</a>
                    </div>
                    <div class="card-body">
                        @if ($dipartments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>Department Name</th>
                                            <th>Added By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dipartments as $key=>$item)
                                            <tr>
                                                <td><strong>{{ $key + 1 }}</strong></td>
                                                <td>{{ $item->name }}</td>
                                                <td><span class="badge light badge-success">{{ $item->added_by }}</span></td>
                                                <td>
                                                    <a href="{{ route('admin.department.delete',encrypt($item->id)) }}" class="btn btn-danger departmentDeleteBtn">Delete</a>
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


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Semester</h4>
                        <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#addNewSemister">Add New Semester</a>
                    </div>
                    <div class="card-body">
                        @if ($dipartments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>Department Name</th>
                                            <th>Semester Name</th>
                                            <th>Added By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($semesters as $key=>$item)
                                            <tr>
                                                <td><strong>{{ $key + 1 }}</strong></td>
                                                <td>{{ $item->department->name }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td><span class="badge light badge-success">{{ $item->added_by }}</span></td>
                                                <td>
                                                    <a href="{{ route('admin.semester.delete',encrypt($item->id)) }}" class="btn btn-danger semesterDelete">Delete</a>
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

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Subjects</h4>
                        <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#addNewSubject">Add New Subject</a>
                    </div>
                    <div class="card-body">
                        @if ($dipartments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th class="width80">#</th>
                                            <th>Subject Name</th>
                                            <th>Added By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subjects as $key=>$item)
                                            <tr>
                                                <td><strong>{{ $key + 1 }}</strong></td>
                                                <td>{{ $item->name }}</td>
                                                <td><span class="badge light badge-success">{{ $item->added_by }}</span></td>
                                                <td>
                                                    <a href="{{ route('admin.subject.delete',encrypt($item->id)) }}" class="btn btn-danger subjectDelete">Delete</a>
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

{{-- Modal --}}
<div class="modal fade" id="addNewDepartment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add New Department</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.department.add') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" placeholder="Department Name" class="form-control">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
  
{{-- Add New Semister --}}
<div class="modal fade" id="addNewSemister" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add New Semester</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.semester.add') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="selectDepartment" class="form-label">Select Department</label>
                    <select name="department_id" id="selectDepartment" class="form-control">
                        <option value="" selected disabled>Select One</option>
                        @foreach ($dipartments as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="form-label">Semester Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Semester Name">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

{{-- Add New Subject --}}
<div class="modal fade" id="addNewSubject" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add New Subject</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.subject.add') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" placeholder="Subject Name" class="form-control">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        $('.departmentDeleteBtn').click(function(event){
            event.preventDefault();
            if(confirm('Are You Sure To Delete This Department. Also Delete All Semester Under this Department.') === true) {
                event.stopPropagation();
                window.location = $(this).attr("href");
            }
        });
    </script>

    <script>
        $('.semesterDelete').click(function(){
            event.preventDefault();
            if(confirm('Are You Sure To Delete This Semester') === true) {
                event.stopPropagation();
                window.location = $(this).attr("href");
            }
        });
    </script>

    <script>
        $('.subjectDelete').click(function(){
            event.preventDefault();
            if(confirm('Are You Sure To Delete This Subject.') === true) {
                event.stopPropagation();
                window.location = $(this).attr("href");
            }
        });
    </script>

    @if (session('semester_error'))
        <script>
            $('#addNewSemister').modal('show');
        </script>
    @endif

    @if (session('department_error'))
        <script>
            $('#addNewDepartment').modal('show');
        </script>
    @endif

    @if (session('subject-error'))
        <script>
            $('#addNewSubject').modal('show');
        </script>
    @endif
@endsection