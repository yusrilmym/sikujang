<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Unit;
use App\Position;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Rules\MatchOldPassword;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "user";

        $user = DB::table('users')->leftjoin('units', 'units.id', '=', 'users.id_unit')
        ->leftJoin('positions', 'positions.id', '=', 'users.id_jafung')
        ->select('users.id', 'users.nickname', 'users.fullname', 'users.nip', 'users.nik', 'users.gol', 'users.email', 'users.tmt', 'users.id_alam', 'users.id_jafung', 'users.id_jabpns', 'users.id_edu', 'users.id_unit', 'users.id_finger', 'users.jenis_peg',
        'users.agama', 'users.tpt_lahir', 'users.tgl_lahir', 'users.gender', 'users.status', 'users.role', 'users.bio', 'users.photo', 'units.nama_unit', 'units.bagian', 'positions.jabatan', 'positions.kategori', 'positions.shifting')
        ->orderBy('users.id', 'asc')
        ->get();

        // return $query->join('units', 'id_unit', '=', 'id_unit')->paginate(10);
        return $user;
    }

    public function userByUnit()
    {
        // if (\Gate::allows('isAdmin')){

        $user = auth('api')->user();
        $unit = $user->id_unit;
        $result = DB::table('users')->where('id_unit', '=', $unit )
        ->select('id','fullname', 'nickname', 'id_unit', 'id_jafung')->get();
        return $result;
        // }
    }

    public function userByBagian()
    {
        // if (\Gate::allows('isAdmin')){
        $user = auth('api')->user();
        $bagian = Unit::where('id', '=', $user->id_unit)->select('bagian')->first();
        // $result = DB::table('units')->rightjoin('users', 'users.id_unit', '=', 'units.id')->where('bagian', '=', $bagian->bagian)->get();
        $result = DB::table('users')->leftjoin('units', 'units.id', '=', 'users.id_unit')
                ->leftJoin('positions', 'positions.id', '=', 'users.id_jafung')
                ->where('units.bagian', '=', $bagian->bagian)
                ->select('users.id', 'users.agama', 'units.bagian', 'users.email', 'users.fullname', 'users.nickname', 'users.gender', 'users.gol', 'users.id_jabpns',
                    'positions.jabatan', 'users.id_jafung', 'users.id_unit', 'users.jenis_peg', 'units.nama_unit', 'users.nik', 'users.nip', 'users.status', 'users.tgl_lahir', 'users.tpt_lahir', 'users.tmt', )
                ->orderBy('users.id', 'asc')
                ->get();
        return $result;
        // }
    }

    public function allUserByUnit(Request $request)
    {
        $unit = $request->id_unit;
        $result = DB::table('users')->where('id_unit', '=', $unit )->get();
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nickname' => 'required|string|max:191',
            'fullname' => 'required|string|max:191',
            'nip' => 'required|string|max:191|unique:users',
            'email' => 'required|string|email|max:191|ends_with:rsudcibinong.com|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'sometimes|string',
        ]);

        $foto = 'avatar.png';

        if(empty($request->photo)){
            $request->merge(['photo' => $foto ]);
        }

        return User::create([
            'nickname' => $request['nickname'],
            'fullname' => $request['fullname'],
            'nip' => $request['nip'],
            'email' => $request['email'],
            'role' => $request['role'],
            'gol' => $request['gol'],
            'tmt' => $request['tmt'],
            'jenis_peg' => $request['jenis_peg'],
            'id_unit' => $request['id_unit'],
            'id_jafung' => $request['id_jafung'],
            'id_finger' => $request['id_finger'],
            'agama' => $request['agama'],
            'tpt_lahir' => $request['tpt_lahir'],
            'tgl_lahir' => $request['tgl_lahir'],
            'gender' => $request['gender'],
            'status' => $request['status'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    // public function show(user $user)
    // {
    //     return $user;
    // }

    public function show(User $user)
    {
        return $user;
    }

    //untuk orang yang login
    public function profile() {
        $user = auth('api')->user();
        $query = DB::table('users')
        ->join('positions', 'positions.id', '=', 'users.id_jafung')
        ->join('units', 'units.id', '=', 'users.id_unit')
        ->where('users.id', '=', $user->id )
        ->select('users.id', 'users.photo', 'users.nickname', 'users.fullname', 'users.jenis_peg',
        'users.gol', 'users.tmt', 'users.gender', 'users.agama', 'users.tpt_lahir', 'users.tgl_lahir', 'users.photo',
        'users.nip', 'users.nik', 'users.gol', 'users.email', 'positions.jabatan',
        'positions.kategori AS katjab', 'users.id_unit', 'units.nama_unit AS unit', 'units.bagian')
        ->get();
        return $query;
    }

    public function userLogin() {
        $user = auth('api')->user();
        $query = DB::table('users')
        ->join('positions', 'positions.id', '=', 'users.id_jafung')
        ->join('units', 'units.id', '=', 'users.id_unit')
        ->where('users.id', '=', $user->id )
        ->select('users.id', 'users.photo', 'users.nickname', 'users.role', 'users.id_jafung', 'users.id_jabpns', 'positions.jabatan', 'positions.kategori AS katjab', 'positions.shifting', 'users.id_unit',
         'units.nama_unit AS unit', 'units.bagian')
        ->get();
        return $query;
    }
    //untuk orang yang login
    public function updateProfile(Request $request) {

        $user = auth('api')->user();

        $this->validate($request, [
            'nickname' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|ends_with:rsudcibinong.com|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6|confirmed',
            'role' => 'sometimes',
        ]);

        // $currentPhoto = $user->photo;
        // if($request->photo != $currentPhoto){

        //     $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

        //     \Image::make($request->photo)->fit(1000, 1400)->save(public_path('img/avatar/').$name);
        //     $request->merge(['photo' => $name]);

        //     $userPhoto = public_path('img/avatar/').$currentPhoto;
        //     if(file_exists($userPhoto) && $currentPhoto !="avatar.png"){
        //         @unlink($userPhoto);
        //     }
        // }

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request ['password'])]);
        }

        // $user->update($request->has('password') ? array_merge($request->except('password'), ['password' => bcrypt($request->input('password'))]) : $request->except('password'));
        $user->update($request->all());
        return ['message' => "success"];
        // return Redirect::route('/home');

    }

    public function updatePhoto(Request $request, $id)
    {
        $this->validate($request, [
            'photo' => 'required',
        ]);

        $user = User::findOrFail($id);

        $currentPhoto = $user->photo;
        if($request->photo != $currentPhoto){
            // $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            $name = trim($request->fullname, ' ').'-'.time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->fit(1000, 1334)->save(public_path('img/photo/').$name);
            \Image::make($request->photo)->fit(500, 667)->crop(500, 500, 0, 0)->save(public_path('img/avatar/').$name);
            $request->merge(['photo' => $name]);

            $userAvatar = public_path('img/avatar/').$currentPhoto;
            if(file_exists($userAvatar) && $currentPhoto !="avatar.png"){
                @unlink($userAvatar);
            }
            $userPhoto = public_path('img/photo/').$currentPhoto;
            if(file_exists($userPhoto) && $currentPhoto !="avatar.png"){
                @unlink($userPhoto);
            }
        }
        $user->update($request->all());
        return ['message' => "success"];
        // return $user;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, user $user)
    {
        // $user = User::findOrFail($id);

        $this->validate($request, [
            'nickname' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|ends_with:rsudcibinong.com|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6|confirmed',
            'role' => 'sometimes',
        ]);

        $user->update($request->has('password') ? array_merge($request->except('password'), ['password' => bcrypt($request->input('password'))]) : $request->except('password'));
        //$user->update($request->all());
    }

    public function changePwd(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'oldpassword' => ['required', new MatchOldPassword],
            'newpassword' => 'required|min:6|different:oldpassword',
            'confirm' => 'required|same:newpassword'
        ]);

        if (Hash::check($request->oldpassword, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->newpassword)
            ])->save();

            return ['message' => "change password success"];

        } else {
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user){

        // if(\Gate::allows('isSuperAdmin') || \Gate::allows('isSys')){
            $user->delete();
            return ['message' => 'User Delete'];
        // }
        // $this->authorize('isSuperAdmin');
    }

    public function search(){
        if($search = \Request::get('q')){
            $users = User::where(function($query) use ($search){
                $query->where('nickname', 'LIKE', "%$search%")
                ->orWhere('fullname', 'LIKE', "%$search%");
                // ->orWhere('role', 'LIKE', "%$search%");
            })->paginate(10);
        }
        return $users;
    }
}
