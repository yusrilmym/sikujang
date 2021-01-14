<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        $user = auth('api')->user();
        $schedule= DB::table('schedules')
        ->join('users', 'users.id', '=', 'schedules.id_user')
        ->join('shifts', 'shifts.id', '=', 'schedules.id_shift')
        ->select('users.id AS id_user', 'users.nickname', 'users.fullname', 'users.id_unit', 'shifts.id AS id_shift', 'schedules.tanggal', 'schedules.id', (DB::raw('CONCAT(schedules.tanggal, " ", shifts.in) AS tanggalin')),
        (DB::raw('CONCAT(schedules.tanggal, " ", shifts.out) AS tanggalout')))
        ->where('users.id_unit', '=', $user->id_unit )
        ->get();

        return $schedule;
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
            'tanggal' => 'required',
            'id_shift' => 'required',
            'id_user' => [
                'required',
                Rule::unique('schedules')->where(function ($query) use ($request) {
                    return $query->where('tanggal', $request->tanggal)
                   ->where('id_shift', $request->id_shift);
                })
            ],
        ]);

        Schedule::create($request->all());
        return ['message' => "success"];
    }

    public function filterUnit(Request $request)
    {
        //
        $schedule= DB::table('schedules')
        ->join('users', 'users.id', '=', 'schedules.id_user')
        ->join('shifts', 'shifts.id', '=', 'schedules.id_shift')
        ->select('users.id AS id_user', 'users.nickname', 'users.fullname', 'users.id_unit', 'shifts.id AS id_shift', 'schedules.tanggal', 'schedules.id', (DB::raw('CONCAT(schedules.tanggal, " ", shifts.in) AS tanggalin')),
        (DB::raw('CONCAT(schedules.tanggal, " ", shifts.out) AS tanggalout')))
        ->where('users.id_unit', '=', $request['id_unit'] )
        ->get();

        return $schedule;
    }

    public function viewDay(Request $request)
    {
        //
        $schedule= DB::table('schedules')
        ->join('users', 'users.id', '=', 'schedules.id_user')
        ->join('shifts', 'shifts.id', '=', 'schedules.id_shift')
        ->select('users.id AS id_user', 'users.nickname', 'users.fullname', 'users.id_unit', 'shifts.id AS id_shift', 'schedules.tanggal', 'schedules.id', (DB::raw('CONCAT(schedules.tanggal, " ", shifts.in) AS tanggalin')),
        (DB::raw('CONCAT(schedules.tanggal, " ", shifts.out) AS tanggalout')))
        ->where('schedules.tanggal', '=', $request['date'] )
        ->where('users.id_unit', '=', $request['id_unit'] )
        ->get();

        return $schedule;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
        $this->validate($request, [
            'tanggal' => 'required',
            'id_shift' => 'required',
            'id_user' => [
                'required',
                Rule::unique('schedules')->where(function ($query) use ($request) {
                    return $query->where('tanggal', $request->tanggal)
                   ->where('id_shift', $request->id_shift);
                })->ignore($request->id)
            ],
        ]);

        $schedule->update($request->all());
        return ['message' => "success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
        $schedule->delete();
        return ['message' => 'Delete Success'];
    }
}
