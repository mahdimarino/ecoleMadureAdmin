<?php

namespace App\Http\Controllers\SupportTeam;

use Illuminate\Support\Facades\DB;
use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Section;
use App\Models\StudentApplication;
use App\Models\StudentRecord;
use App\Repositories\LocationRepo;
use App\Repositories\MyClassRepo;
use App\Repositories\UserRepo;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $user, $loc, $my_class;

    public function __construct(UserRepo $user, LocationRepo $loc, MyClassRepo $my_class)
    {
        $this->middleware('teamSA', ['only' => ['index', 'store', 'edit', 'update']]);
        $this->middleware('super_admin', ['only' => ['reset_pass', 'destroy']]);

        $this->user = $user;
        $this->loc = $loc;
        $this->my_class = $my_class;
    }

    public function index()
    {
        $ut = $this->user->getAllTypes();
        $ut2 = $ut->where('level', '>', 2);

        $d['user_types'] = Qs::userIsAdmin() ? $ut2 : $ut;
        $d['my_classes'] = $this->my_class->all();
        $d['my_classes']->load('section');
        $d['states'] = $this->loc->getStates();

        $d['users'] = $this->user->getPTAUsers();

        $d['nationals'] = $this->loc->getAllNationals();

        $d['blood_groups'] = $this->user->getBloodGroups();

        /*
        |--------------------------------------------------------------------------
        | STUDENT APPLICATIONS
        |--------------------------------------------------------------------------
        |
        | This was missing before.
        | The Blade file uses:
        |
        | @foreach($student_applications as $app)
        |
        | so we must pass this variable to the view.
        |
        */

        $d['student_applications'] = StudentApplication::orderBy(
            'created_at',
            'desc'
        )->get();

        /*
        |--------------------------------------------------------------------------
        | PENDING APPLICATION COUNT
        |--------------------------------------------------------------------------
        */

        $d['pending_applications'] = StudentApplication::where(
            'status',
            'pending'
        )->count();

        return view(
            'pages.support_team.users.index',
            $d
        );
    }

    public function edit($id)
    {
        $id = Qs::decodeHash($id);
        $d['user'] = $this->user->find($id);
        $d['states'] = $this->loc->getStates();
        $d['users'] = $this->user->getPTAUsers();
        $d['blood_groups'] = $this->user->getBloodGroups();
        $d['nationals'] = $this->loc->getAllNationals();
        return view('pages.support_team.users.edit', $d);
    }

    public function reset_pass(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $id = Qs::decodeHash($request->user_id);

        if (!$id) {
            return back()->with('pop_error', 'Utilisateur invalide.');
        }

        // Prevent changes to Head Super Admin
        if (Qs::headSA($id)) {
            return back()->with('flash_danger', __('msg.denied'));
        }

        $user = $this->user->find($id);

        if (!$user) {
            return back()->with('pop_error', 'Utilisateur introuvable.');
        }

        $this->user->update($id, [
            'password' => Hash::make($request->password)
        ]);

        return back()->with(
            'flash_success',
            'Le mot de passe a été modifié avec succès.'
        );
    }

    public function registerTeacher(Request $req)
    {
        $data = $req->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'phone'    => 'required|string|max:30',
            'phone2'   => 'nullable|string|max:30',
            'gender'   => 'required|string',
            'address'  => 'required|string|max:255',
            'nal_id'   => 'required',
            'state_id' => 'nullable',
            'lga_id'   => 'nullable',
            'bg_id'    => 'nullable',
            'emp_date' => 'nullable',
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Automatically make this user a teacher
        $data['user_type'] = 'teacher';

        // Default photo
        $data['photo'] = Qs::getDefaultUserImage();

        // Generate user code
        $data['code'] = strtoupper(Str::random(10));

        // Hash password
        $data['password'] = Hash::make($req->password);

        // Upload photo
        if ($req->hasFile('photo')) {

            $photo = $req->file('photo');

            $f = Qs::getFileMetaData($photo);

            $f['name'] = 'photo.' . $f['ext'];

            $f['path'] = $photo->storeAs(
                Qs::getUploadPath('teacher') . $data['code'],
                $f['name']
            );

            $data['photo'] = asset('storage/' . $f['path']);
        }

        // Create teacher
        $user = $this->user->create($data);

        // Create staff record
        $staff_id = Qs::getAppCode()
            . '/STAFF/'
            . date('Y/m')
            . '/'
            . mt_rand(1000, 9999);

        $d2 = $req->only(Qs::getStaffRecord());

        $d2['user_id'] = $user->id;
        $d2['code'] = $staff_id;

        $this->user->createStaffRecord($d2);

        return redirect()
            ->route('teacherregrstarsion')
            ->with('success', 'Teacher registration successful!');
    }

    public function approveTeacher(User $user)
    {
        if ($user->user_type !== 'teacher') {
            abort(404);
        }

        $user->is_approved = true;
        $user->save();

        return back()->with('success', 'Teacher approved successfully.');
    }

    public function approveStudent(Request $request, $id)
    {
        $request->validate([
            'my_class_id' => 'required|exists:my_classes,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        $user = User::findOrFail($id);

        if ($user->user_type !== 'student') {
            abort(404);
        }

        // Make sure the section belongs to the selected class
        $section = Section::where('id', $request->section_id)
            ->where('my_class_id', $request->my_class_id)
            ->where('active', 1)
            ->first();

        if (!$section) {
            return back()->with(
                'pop_error',
                'The selected section does not belong to this class or is inactive.'
            );
        }

        // Don't create a duplicate StudentRecord
        if (StudentRecord::where('user_id', $user->id)->exists()) {

            $user->is_approved = 1;
            $user->save();

            return back()->with(
                'success',
                'Student is already assigned to a class and has been approved.'
            );
        }

        $application = StudentApplication::where('user_id', $user->id)->first();

        DB::transaction(function () use (
            $request,
            $user,
            $application
        ) {

            /*
        |--------------------------------------------------------------------------
        | Create normal StudentRecord
        |--------------------------------------------------------------------------
        */

            StudentRecord::create([
                'user_id'      => $user->id,
                'my_class_id'  => $request->my_class_id,
                'section_id'   => $request->section_id,
                'adm_no'       => $user->username,
                'session'      => Qs::getSetting('current_session'),
                'year_admitted' => $application?->academic_year ?: date('Y'),
                'age'          => $user->dob
                    ? \Carbon\Carbon::parse($user->dob)->age
                    : null,
                'grad'         => 0,
            ]);

            /*
        |--------------------------------------------------------------------------
        | Approve User
        |--------------------------------------------------------------------------
        */

            $user->is_approved = 1;
            $user->save();

            /*
        |--------------------------------------------------------------------------
        | Approve Application
        |--------------------------------------------------------------------------
        */

            if ($application) {
                $application->status = 'accepted';
                $application->reviewed_by = auth()->id();
                $application->reviewed_at = now();
                $application->save();
            }
        });

        return back()->with(
            'success',
            'Student approved and added to the selected class successfully.'
        );
    }

    public function teacherRegistration()
    {
        $d['user_types'] = $this->user->getAllTypes();
        $d['states'] = $this->loc->getStates();
        $d['nationals'] = $this->loc->getAllNationals();
        $d['blood_groups'] = $this->user->getBloodGroups();

        return view('auth.teacherregrstarsion', $d);
    }

    public function store(UserRequest $req)
    {
        $user_type = $this->user->findType($req->user_type)->title;

        $data = $req->except(Qs::getStaffRecord());
        $data['name'] = ucwords($req->name);
        $data['user_type'] = $user_type;
        $data['photo'] = Qs::getDefaultUserImage();
        $data['code'] = strtoupper(Str::random(10));

        $user_is_staff = in_array($user_type, Qs::getStaff());
        $user_is_teamSA = in_array($user_type, Qs::getTeamSA());

        $staff_id = Qs::getAppCode() . '/STAFF/' . date('Y/m', strtotime($req->emp_date)) . '/' . mt_rand(1000, 9999);
        $data['username'] = $uname = ($user_is_teamSA) ? $req->username : $staff_id;

        $pass = $req->password ?: $user_type;
        $data['password'] = Hash::make($pass);

        if ($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath($user_type) . $data['code'], $f['name']);
            $data['photo'] = asset('storage/' . $f['path']);
        }

        /* Ensure that both username and Email are not blank*/
        if (!$uname && !$req->email) {
            return back()->with('pop_error', __('msg.user_invalid'));
        }

        $user = $this->user->create($data); // Create User

        /* CREATE STAFF RECORD */
        if ($user_is_staff) {
            $d2 = $req->only(Qs::getStaffRecord());
            $d2['user_id'] = $user->id;
            $d2['code'] = $staff_id;
            $this->user->createStaffRecord($d2);
        }

        return Qs::jsonStoreOk();
    }

    public function update(UserRequest $req, $id)
    {
        $id = Qs::decodeHash($id);

        // Redirect if Making Changes to Head of Super Admins
        if (Qs::headSA($id)) {
            return Qs::json(__('msg.denied'), FALSE);
        }

        $user = $this->user->find($id);

        $user_type = $user->user_type;
        $user_is_staff = in_array($user_type, Qs::getStaff());
        $user_is_teamSA = in_array($user_type, Qs::getTeamSA());

        $data = $req->except(Qs::getStaffRecord());
        $data['name'] = ucwords($req->name);
        $data['user_type'] = $user_type;

        if ($user_is_staff && !$user_is_teamSA) {
            $data['username'] = Qs::getAppCode() . '/STAFF/' . date('Y/m', strtotime($req->emp_date)) . '/' . mt_rand(1000, 9999);
        } else {
            $data['username'] = $user->username;
        }

        if ($req->hasFile('photo')) {
            $photo = $req->file('photo');
            $f = Qs::getFileMetaData($photo);
            $f['name'] = 'photo.' . $f['ext'];
            $f['path'] = $photo->storeAs(Qs::getUploadPath($user_type) . $user->code, $f['name']);
            $data['photo'] = asset('storage/' . $f['path']);
        }

        $this->user->update($id, $data);   /* UPDATE USER RECORD */

        /* UPDATE STAFF RECORD */
        if ($user_is_staff) {
            $d2 = $req->only(Qs::getStaffRecord());
            $d2['code'] = $data['username'];
            $this->user->updateStaffRecord(['user_id' => $id], $d2);
        }

        return Qs::jsonUpdateOk();
    }

    public function show($user_id)
    {
        $user_id = Qs::decodeHash($user_id);
        if (!$user_id) {
            return back();
        }

        $data['user'] = $this->user->find($user_id);

        /* Prevent Other Students from viewing Profile of others*/
        if (Auth::user()->id != $user_id && !Qs::userIsTeamSAT() && !Qs::userIsMyChild(Auth::user()->id, $user_id)) {
            return redirect(route('dashboard'))->with('pop_error', __('msg.denied'));
        }

        return view('pages.support_team.users.show', $data);
    }

    public function destroy($id)
    {
        $id = Qs::decodeHash($id);

        // Redirect if Making Changes to Head of Super Admins
        if (Qs::headSA($id)) {
            return back()->with('pop_error', __('msg.denied'));
        }

        $user = $this->user->find($id);

        if ($user->user_type == 'teacher' && $this->userTeachesSubject($user)) {
            return back()->with('pop_error', __('msg.del_teacher'));
        }

        $path = Qs::getUploadPath($user->user_type) . $user->code;
        Storage::exists($path) ? Storage::deleteDirectory($path) : true;
        $this->user->delete($user->id);

        return back()->with('flash_success', __('msg.del_ok'));
    }

    protected function userTeachesSubject($user)
    {
        $subjects = $this->my_class->findSubjectByTeacher($user->id);
        return ($subjects->count() > 0) ? true : false;
    }
}
