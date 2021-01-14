<?php

namespace App\Http\Controllers\API;

use App\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivitiesController extends Controller
{
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
        //
        $today = date("Y-m-d");
        $user = auth('api')->user();
        $activity = DB::table('activities')->join('users', 'users.id', '=', 'activities.id_user')
        ->select('users.role', 'activities.id', 'activities.id_user', 'activities.mr', 'activities.nama_pasien', 'activities.jam', 'activities.tanggal', 'activities.status', 'activities.kegiatan')
        ->where('activities.id_user', '=', $user->id )
        ->where('activities.tanggal', '=', $today)
        ->orderBy('activities.jam', 'DESC')
        ->get();

        if (count($activity) == 0){
            return null ;
        }else{
            return $activity;
        }
    }

    public function byDate(Request $request)
    {
        //
        $date = $request->date;
        $user = auth('api')->user();
        $activity = DB::table('activities')->where('id_user', '=', $user->id )->join('users', 'users.id', '=', 'activities.id_user')
        ->select('users.role', 'activities.id', 'activities.id_user', 'activities.mr', 'activities.nama_pasien', 'activities.jam', 'activities.tanggal', 'activities.status', 'activities.kegiatan')
        ->where('tanggal', '=', $date)
        ->orderBy('jam', 'DESC')
        ->get();

        return $activity;
    }

    public function byUserDate(Request $request)
    {
        //
        $date = $request->date;
        $user = $request->id_user;
        $activity = DB::table('activities')->join('users', 'users.id', '=', 'activities.id_user')
        ->select('users.role', 'activities.id', 'activities.id_user', 'activities.mr', 'activities.nama_pasien', 'activities.jam', 'activities.tanggal', 'activities.status', 'activities.kegiatan')
        ->where('id_user', '=', $user )
        ->where('tanggal', '=', $date)
        ->orderBy('jam', 'ASC')
        ->get();

        return $activity;
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
        $this->validate($request, [
            'jam' => 'required',
            'kegiatan' => 'required',
        ]);

        Activity::create($request->all());
        return ['message' => "success"];
    }

    public function createBidPer(Request $request)
    {
        //
        $this->validate($request, [
            'jam' => 'required',
            'nama_pasien' => 'required',
            'mr' => 'sometimes|min:8|max:11',
            'kegiatan' => 'required',
        ]);

        Activity::create($request->all());
        return ['message' => "success"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
        $this->validate($request, [
            'jam' => 'required',
            'kegiatan' => 'required',
        ]);

        $activity->update($request->all());
        return ['message' => "success"];
    }

    public function updateBidPer(Request $request, Activity $activity)
    {
        $activity = Activity::findOrFail($request->id);
        $this->validate($request, [
            'jam' => 'required',
            'nama_pasien' => 'required',
            'mr' => 'required|min:8|max:10',
            'kegiatan' => 'required',
        ]);

        $activity->update($request->all());
        return ['message' => "success"];
    }

    public function ApproveDecline(Request $request)
    {
        //
        $activity = Activity::findOrFail($request->id);
        $this->validate($request, [
            'status' => 'required',
        ]);

        $activity->update($request->all());
        return ['message' => "success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
        $activity->delete();
        return ['message' => 'Delete Success'];
    }
}
