<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Departments;
use App\Models\Semester;
use App\Models\StudentResult;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    // Student Role
    protected const STUDENT = 0;
    protected const TEACHER = 1;
    // Data Decrypt Function
    public function check_encrypt_data($encrypt_data)
    {
        try{
            return decrypt($encrypt_data);
        }catch(Exception $e){
            return back()->with('error','Something Worng! Please try again.');
        }
    }

    public function __construct()
    {
        $this->middleware('auth');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.index');
    }

    // Management Page View
    public function managementView()
    {
        $all_user = User::orderBy('id','desc')->get();
        $pending_teachers = $all_user->where('role',1)
                                    ->where('status',0);
        $active_teacher = $all_user->where('role',1)
                                    ->where('status',1);
        $students = $all_user->where('role',0)
                            ->where('status',0);

        return view('dashboard.management',[
            'pending_teachers'=>$pending_teachers,
            'active_teachers' =>$active_teacher,
            'students'=>$students
        ]);
    }

    // Teacher Approve
    public function statusChange($encrypt_id)
    {
        $id = $this->check_encrypt_data($encrypt_id);
        $user_info = User::where('id',$id)->where('role',1)->first();
        $block = false;

        if($user_info === null) {
            return back()->with('error',"Data Not Found!");
        }else {
            if($user_info->status == 1) {
                try{
                    $block = User::find($user_info->id)->update([
                        'status' => '0',
                    ]); 
                }catch(Exception $e) {
                    return back()->with('error','Something Worng! Please try again.');
                }
            }else {
                try{
                    $approve = User::find($user_info->id)->update([
                        'status' => '1',
                    ]); 
                }catch(Exception $e) {
                    return back()->with('error','Something Worng! Please try again.');
                }
            }
        }

        if($block == true) {
            return back()->with('success','Blocked!');
        }else {
            return back()->with('success','Approved!');
        }


    }

    // Delete User
    public function teacherDelete($encrypt_id)
    {
        $id = $this->check_encrypt_data($encrypt_id);
        $user_info = User::find($id);
        $user_profile = $user_info->image;
        $delete_result = StudentResult::where('student_id',$id)->delete();

        if($user_profile != 'default.jpg') {
            try{
                if(File::exists(public_path('dashboard/user/'.$user_profile))) {
                    File::delete(public_path('dashboard/user/'.$user_profile));
                }
            }catch(Exception $e){
                return back()->with('error','Profile Image Delete Faild!');
            }
        }

        if($user_info->delete() == true) {
            return back()->with('success','Successfully Deleted!');
        }else {
            return back()->with('error','Something Worng! Please try again.');
        }
    }

    // Students Department
    public function studentsDipartmentShow()
    {
        $dipartments = Departments::orderBy('id','desc')->get();
        $semesters = Semester::all();
        $subjects = Subject::orderBy('id','desc')->get();
        return view('dashboard.dipartments',[
            'dipartments'=>$dipartments,
            'semesters' => $semesters,
            'subjects' =>$subjects
        ]);
    }

    // Department Add
    public function studentsDipartmentAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        // If Single Validation Fails
        if ($validator->stopOnFirstFailure()->fails()) {
            return back()->with('department_error','Department Error')->withErrors($validator)->withInput();
        }

        $validated = $validator->safe()->all();
        $validated['added_by'] = Auth::user()->name;
        $validated['created_at'] = Carbon::now();

        // insert
        try{
            $insert = Departments::create($validated);
        }catch(Exception $e) {
            return back()->with('error',"Something Worng! Please try again.");
        }

        return back()->with('success',"Department Added Success!");
    }

    // Department Delete
    public function departmentDelete($encrypt_id)
    {
        $id = $this->check_encrypt_data($encrypt_id);

        $semester_ids = Semester::where('department_id',$id)->pluck('id');

        // delete users under this semester
        $users_delete = User::whereIn('semester_id',$semester_ids)->delete();

        // Delete semesters under this departments
        $semesters_delete = Semester::where('department_id',$id)->delete();

        // Delete Department
        $delete_department = Departments::find($id)->delete();

        if($delete_department != true || $semesters_delete != true || $users_delete != true) {
            return back()->with('error',"Something Worng! Please try again.");
        }
        return back()->with('success',"Semester Delete Successfully!");
    }

    // Subject Add
    public function subjectAdd(Request $request)
    {
        if(!is_string($request->name)) {
            throw ValidationException::withMessages([
                'subject-error' => 'Faild!',
                'name' => 'Pelase Enter a Valid Name that Contains only String.',
            ]);
        }

        $data = [];
        $data['name'] = $request->name;
        $data['added_by'] = Auth::user()->name;
        $data['created_at'] = Carbon::now();

        $add_subject = Subject::create($data);

        if($add_subject != true) {
            return back()->with('error',"Something Worng! Please try again.");
        }
        return back()->with('success',"Subject Added Successfully!");
    }

    // Subject Delete
    public function subjectDelete($encrypt_id)
    {
        $id = $this->check_encrypt_data($encrypt_id);

        if(Subject::find($id)->delete()) {
            return back()->with('success',"Subject Delete Successfully!");
        }

        return back()->with('error',"Something Worng! Please try again.");
    }

    // Students Attendance View
    public function studentsAttendanceView()
    {
        $departments = Departments::orderBy('id','desc')->get();
        if(Auth::user()->status == 1) {
            return view('dashboard.attendance',[
                'departments'=>$departments,
            ]);
        }else {
            return redirect()->route('front-end.index');
        }
    }

    // Admin Get Semester via ajax
    public function getSemesterAjax(Request $request)
    {
        $department_id = $request->department_id;
        $semesters = Semester::where('department_id',$department_id)->select('id','name')->get();
        return json_encode($semesters,true);
    }

    // Students Attendance Sheet Ajax
    public function attendanceSheet(Request $request)
    {
        $department_id = $request->department_id;
        $semester_id = $request->semester_id;
        $date = $request->date;
        $getStudents = User::where('department_id',$department_id)
                            ->where('semester_id',$semester_id)
                            ->get();

        return view('dashboard.attendance-sheet-ajax',[
            'students'=>$getStudents,
            'date'=> $date,
            'department_id'=>$department_id,
            'semester_id' => $semester_id,
        ]);
    }


    // Attendance Submit
    public function attendanceSubmit(Request $request)
    {
        $present_student_ids = [];
        $all_student_ids = [];
        if($request->present_students != null) {
            $present_student_ids = $request->present_students;
        }
        if($request->ids != null) {
            $all_student_ids = $request->ids;
        }
        $date = Carbon::parse($request->date);
        $department_id = $request->department_id;
        $semester_id = $request->semester_id;

        if($all_student_ids == null) {
            return back()->with('error',"Students Not Available!");
        }

        if($semester_id == "" || $department_id == "") {
            return back()->with('error','Department/Semester is Missing. Try again.');
        }

        // if alrady attendance done 
        $check_attendance = Attendance::where('department_id',$department_id)
                                        ->where('semester_id',$semester_id)
                                        ->where('attendance_date',$date)
                                        ->get();

        $absent_students = [];
        if(count($present_student_ids) == 0) {
            $absent_students = $all_student_ids;
        }else {
            $absent_students = array_diff($all_student_ids,$present_student_ids);
        }

        $present = (object)$present_student_ids;
        $absent = (object)$absent_students;


        if($check_attendance->count() != 0) {
            $get_id = $check_attendance->first()->id;
            $update_attendance = Attendance::find($get_id)->update([
                'attendance_date' => $date,
                'department_id' => $department_id,
                'semester_id' =>$semester_id,
                'present_students' => json_encode($present,true),
                'absent_students' => json_encode($absent,true),
                'added_by' => Auth::user()->name
            ]);

            if($update_attendance != true) {
                return back()->with('error',"Something Worng! Please try again.");
            }
        }else {
            $insert_attendance = Attendance::create([
                'attendance_date' => $date,
                'department_id' => $department_id,
                'semester_id' =>$semester_id,
                'present_students' => json_encode($present,true),
                'absent_students' => json_encode($absent,true),
                'added_by' => Auth::user()->name,
                'created_at' => Carbon::now()
            ]);
            if($insert_attendance != true) {
                return back()->with('error',"Something Worng! Please try again.");
            }
        }

        return back()->with('success',"Attendance Success!");
    }


    // Attendance Result 
    public function attendanceResult()
    {
        if(Auth::user()->role == 0) {
            return view('dashboard.student-attendence-result');
        }else {
            return redirect()->route('front-end.index');
        }
    }


    // Student Attendance Result Load Ajax
    public function attendanceReportLoad(Request $request)
    {
        $date_range = $request->date_range;
        $date_range_array = explode('-',$date_range);
        $start_time = Carbon::parse($date_range_array[0]);
        $end_time = Carbon::parse($date_range_array[1]);
        $getData = Attendance::whereBetween('attendance_date',[$start_time,$end_time])->get();

        return view('dashboard.attendance-result-ajax',[
            'data' => $getData,
            'user_id' => Auth::user()->id,
        ]);

        
    }

    // Admin Show Students Attendance Report
    public function studentsAttendanceAdminSide()
    {
        $departments = Departments::orderBy('id','desc')->get();
        return view('dashboard.attendance-admin-show',[
            'departments' => $departments,
        ]);
    }

    // get Students via ajax for admin attendance
    public function getStudents(Request $request)
    {
        $getStudents = User::where('department_id',$request->department_id)
                            ->where('semester_id',$request->semester_id)
                            ->select('id','name')
                            ->get();
        return json_encode($getStudents,true);
    }

    // Admin Attendance Result Ajax
    public function getStudentsAttendanceAjax(Request $request)
    {
        if(Auth::user()->status != 1) {
            return redirect()->route('fornt-end.index');
        }else {
            $department_id = $request->department_id;
            $student_id = $request->student_id;

            $data = Attendance::where('department_id',$department_id)->orderBy('id','desc')->get();

            return view('dashboard.admin-ajax-attendance',[
                'data'=>$data,
                'user_id'=>$student_id
            ]);
        }
    }

    // Semester Add
    public function addSemester(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100'],
            'department_id' => ['required', 'numeric']
        ]);

        // If Single Validation Fails
        if ($validator->stopOnFirstFailure()->fails()) {
            return  back()->with('semester_error','Semester Error')->withErrors($validator)->withInput();
        }

        $validated = $validator->safe()->all();
        $validated['created_at'] = Carbon::now();
        $validated['added_by'] = Auth::user()->name;

        $insertSemester = Semester::create($validated);


        if($insertSemester != true) {
            return back()->with('error',"Something Worng! Please try again.");
        }

        return back()->with('success',"Successfully Added Semester.");
    }


    // Semester Delete
    public function deleteSemester($encrypt_id)
    {
        $id = $this->check_encrypt_data($encrypt_id);
        $delete = Semester::find($id)->delete();

        if($delete != true) {
            return back()->with('error',"Something Worng! Please try again.");
        }

        return back()->with('success',"Semester Delete Successfully!");
    }


    // Student Result Make
    public function studentResultMake()
    {
        if(Auth::user()->role == 1 && Auth::user()->status == 1 || Auth::user()->role == 5 && Auth::user()->status == 1) {
            $departments = Departments::orderBy('id','desc')->get();
            $subjects = Subject::select('id','name')->get();

            return view('dashboard.student-result-make',[
                'departments' =>$departments,
                'subjects' => $subjects
            ]);
        }else {
            return redirect()->route('front-end.index');
        }

    }

    // Students Result Add
    public function studentResultAdd(Request $request)
    {
        if(Auth::user()->role == 1 && Auth::user()->status == 1 || Auth::user()->role == 5 && Auth::user()->status == 1) {
            // check already result is entry or not
            $student_id = $request->student_id;
            $subject_id = $request->subject_id;

            $find_student = StudentResult::where('student_id',$student_id)
                                        ->where('subject_id',$subject_id)
                                        ->get();
            if($find_student->count() != 0) {
                return back()->with('error',"Already Result Added.");
            }
            $validator = Validator::make($request->all(), [
                'department_id' => 'required|numeric',
                'semester_id' => 'required|numeric',
                'student_id' => 'required|numeric',
                'subject_id' => 'required|numeric',
                'class_test_one' => 'numeric|nullable|max:15',
                'class_test_two' => 'numeric|nullable|max:15',
                'class_test_three' => 'numeric|nullable|max:15',
                'class_test_avg' => 'numeric|nullable|max:45',
                'assingment' => 'numeric|nullable|max:5',
                'presentation' => 'numeric|nullable|max:5',
                'attendance' => 'numeric|nullable|max:5',
                'midterm' => 'numeric|nullable|max:30',
                'final' => 'numeric|nullable|max:40',
                'total' => 'numeric|nullable|max:100',
                'grade' => 'required|string|max:100'
            ]);
    
            // If Single Validation Fails
            if ($validator->stopOnFirstFailure()->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $validated = $validator->safe()->all();
            $validated['added_by'] = auth()->user()->name;
            $validated['created_at'] = Carbon::now();

            // insert
            $insert = StudentResult::create($validated);
            if($insert != true) {
                return back()->with('error',"Something Worng! Please try again.");
            }

            return back()->with('success',"Result Added Successfully!");

        }else {
            return redirect()->route('front-end.index');
        }
    }

    // Students Results
    public function allStudentResultPage()
    {
        if(Auth::user()->role == 1 && Auth::user()->status == 1 || Auth::user()->role == 5 && Auth::user()->status == 1) {
            $departments = Departments::orderBy('id','desc')->get();
            $subjects = Subject::all();
            return view('dashboard.all-students-result-page',[
                'departments' =>$departments,
                'subjects' => $subjects,
            ]);
        }else {
            return redirect()->route('front-end.index');
        }
    }

    // get Student Result via ajax 
    public function allStudentResultAjax(Request $request)
    {
        $department_id = $request->department_id;
        $semester_id = $request->semester_id;
        $student_id = $request->student_id;
        $subject_id = $request->subject_id;


        $result = StudentResult::where('department_id',$department_id)
                                ->where('semester_id',$semester_id)
                                ->where('student_id',$student_id)
                                ->where('subject_id',$subject_id)
                                ->first();
        
        return view('dashboard.all-student-result-load',[
            'result' => $result,
        ]);

    }


    // Individual Student Result
    public function studentResult()
    {
        if(Auth::user()->role == 0) {
            $student_result = StudentResult::where('student_id',Auth::user()->id)->get();
            return view('dashboard.single-student-result',[
                'student_result' =>$student_result,
            ]);
        }else {
            return redirect()->route('front-end.index');
        }
    }

    // Change Password
    public function passwordChange(Request $request)
    {
        $auth_user_db_pass = User::find(Auth::user()->id);
        if(Hash::check($request->old_password,$auth_user_db_pass->password)) {
            $validator = Validator::make($request->all(), [
                'new_password' => 'required|string|min:8|confirmed',
            ]);
    
            // If Single Validation Fails
            if ($validator->stopOnFirstFailure()->fails()) {
                return back()->with('department_error','Department Error')->withErrors($validator)->withInput();
            }

            $validated = $validator->safe()->all();

            $pass_update = User::find(Auth::user()->id)->update([
                'password' => Hash::make($validated['new_password']),
            ]);

            if($pass_update != true) {
                return back()->with('error','Something Worng! Please try again.');
            }
            return back()->with('success','Password Changed');
        }else {
            throw ValidationException::withMessages([
                'old_password' => 'Old Password didn\'t match...',
            ]);
        }
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
