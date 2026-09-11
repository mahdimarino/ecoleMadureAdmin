<?php

namespace App\Http\Controllers;

use App\Helpers\Qs;
use App\Repositories\UserRepo;
use App\Models\Exam;
use App\Models\MyClass;
use App\Models\Subject;
use App\Models\StudentRecord;

class HomeController extends Controller
{
    protected $user;
    public function __construct(UserRepo $user)
    {
        $this->user = $user;
    }


    public function index()
    {
        return redirect()->route('dashboard');
    }

    public function privacy_policy()
    {
        $data['app_name'] = config('app.name');
        $data['app_url'] = config('app.url');
        $data['contact_phone'] = Qs::getSetting('phone');
        return view('pages.other.privacy_policy', $data);
    }

    public function terms_of_use()
    {
        $data['app_name'] = config('app.name');
        $data['app_url'] = config('app.url');
        $data['contact_phone'] = Qs::getSetting('phone');
        return view('pages.other.terms_of_use', $data);
    }

    public function dashboard()
    {
        $d = [];

        if (Qs::userIsTeamSAT()) {
            $d['users'] = $this->user->getAll();
        }

        $user = auth()->user();

        $d['calendar_classes'] = collect();
        $d['calendar_subjects'] = collect();
        $d['calendar_exams'] = Exam::where(
            'year',
            Qs::getCurrentSession()
        )->orderBy('name')->get();

        /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

        if (in_array($user->user_type, ['admin', 'super_admin'])) {

            $d['calendar_classes'] = MyClass::orderBy('name')->get();

            $d['calendar_subjects'] = Subject::with('my_class')
                ->orderBy('name')
                ->get();
        }

        /*
    |--------------------------------------------------------------------------
    | TEACHER
    |--------------------------------------------------------------------------
    */ elseif ($user->user_type === 'teacher') {

            $d['calendar_subjects'] = Subject::with('my_class')
                ->where('teacher_id', $user->id)
                ->orderBy('name')
                ->get();

            $d['calendar_classes'] = $d['calendar_subjects']
                ->pluck('my_class')
                ->filter()
                ->unique('id')
                ->values();
        }

        /*
    |--------------------------------------------------------------------------
    | STUDENT
    |--------------------------------------------------------------------------
    */ elseif ($user->user_type === 'student') {

            $student = Qs::findStudentRecord($user->id);

            if ($student) {
                $class = MyClass::find($student->my_class_id);

                if ($class) {
                    $d['calendar_classes'] = collect([$class]);
                }
            }
        }

        /*
    |--------------------------------------------------------------------------
    | PARENT
    |--------------------------------------------------------------------------
    */ elseif ($user->user_type === 'parent') {

            $class_ids = StudentRecord::where('my_parent_id', $user->id)
                ->pluck('my_class_id')
                ->filter()
                ->unique();

            $d['calendar_classes'] = MyClass::whereIn('id', $class_ids)
                ->orderBy('name')
                ->get();
        }

        return view('pages.support_team.dashboard', $d);
    }
}
