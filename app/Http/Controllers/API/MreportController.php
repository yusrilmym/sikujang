<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mreport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MreportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = auth('api')->user();
        $dateYear = date("Y");
        $date = date("m");
        $report = DB::table('mreports')->where('id_user', '=', $user->id)
        ->whereMonth('date', '=', $date)->whereYear('date', '=', $dateYear)->get();

        return $report;
    }

    public function getByDate(Request $request)
    {
        $user = auth('api')->user();
        $year = substr($request->date, 0, 4);
        $month = substr($request->date, 5, 2);
        $report = DB::table('mreports')->where('id_user', '=', $user->id)
        ->whereMonth('date', '=', $month)->whereYear('date', '=', $year)->get();

        return $report;
    }
    public function getAllByDate(Request $request)
    {
        $year = substr($request->date, 0, 4);
        $month = substr($request->date, 5, 2);
        $report = DB::table('mreports')->whereMonth('date', '=', $month)->whereYear('date', '=', $year)
        ->join('users', 'users.id', '=', 'mreports.id_user')->select('users.fullname', 'mreports.checkdate', 'mreports.created_at')->get();

        return $report;
    }

    public function getUser(Request $request)
    {
        $year = substr($request->date, 0, 4);
        $month = substr($request->date, 5, 2);
        $users = DB::table('mreports')->join('users', 'users.id', '=', 'mreports.id_user')->whereMonth('date', '=', $month)->whereYear('date', '=', $year)
        ->select('users.fullname', 'mreports.id_user')->get();
        return $users;
    }

    public function getUserBelum(Request $request)
    {
        $year = substr($request->date, 0, 4);
        $month = substr($request->date, 5, 2);
        $users = DB::table('mreports')->join('users', 'users.id', '=', 'mreports.id_user')->whereMonth('date', '=', $month)->whereYear('date', '=', $year)->where('mreports.status', '=', 'Menunggu')
        ->select('users.fullname', 'mreports.id_user')->get();
        return $users;
    }

    public function getUserSudah(Request $request)
    {
        $year = substr($request->date, 0, 4);
        $month = substr($request->date, 5, 2);
        $users = DB::table('mreports')->join('users', 'users.id', '=', 'mreports.id_user')->whereMonth('date', '=', $month)->whereYear('date', '=', $year)->where('mreports.status', '=', 'Disetujui')
        ->select('users.fullname', 'mreports.id_user')->get();
        return $users;
    }
    public function getByUserDate(Request $request)
    {
        $year = substr($request->date, 0, 4);
        $month = substr($request->date, 5, 2);
        $report = DB::table('mreports')->where('id_user', '=', $request->id_user)
        ->whereMonth('date', '=', $month)->whereYear('date', '=', $year)
        ->join('users', 'users.id', '=', 'mreports.id_user')
        ->select('mreports.id', 'mreports.id_user', 'users.fullname', 'mreports.plan', 'mreports.do', 'mreports.check', 'mreports.action', 'mreports.date',
        'mreports.status', 'mreports.checkdate', 'mreports.catatan', 'mreports.created_at')
        ->get();

        return $report;
    }

    public function getEventUser(Request $request)
    {
        //
        $dateYear = substr($request->date, 0, 4);
        $event = DB::table('mreports')->where('status', '=', 'Menunggu')->whereYear('date', '=', $dateYear)
        ->select(DB::raw("DATE_FORMAT(date, '%Y-%m') as date"))->groupBy('date')->pluck('date');
        return $event;
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
            'plan' => 'required',
            'do' => 'required',
            'check' => 'required',
            'action' => 'required',
            'date' => [
                'required',
                Rule::unique('mreports')->where(function ($query) use ($request) {
                    return $query->where('id_user', $request->id_user);
                //    ->where('butir_kegiatan', $request->butir_kegiatan);
                })->ignore($request->id)
            ],
        ]);

        Mreport::create($request->all());

        return ['message' => "success"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mreport  $mreport
     * @return \Illuminate\Http\Response
     */
    public function show(Mreport $mreport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mreport  $mreport
     * @return \Illuminate\Http\Response
     */
    public function edit(Mreport $mreport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mreport  $mreport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $mreport = Mreport::findOrFail($request->id);
        $this->validate($request, [
            'plan' => 'required',
            'do' => 'required',
            'check' => 'required',
            'action' => 'required',
            'date' => [
                'required',
                Rule::unique('mreports')->where(function ($query) use ($request) {
                    return $query->where('id_user', $request->id_user);
                //    ->where('butir_kegiatan', $request->butir_kegiatan);
                })->ignore($request->id)
            ],
        ]);

        $mreport->update($request->all());
        return ['message' => "success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mreport  $mreport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $mreport = Mreport::findOrFail($request->id);
        $mreport->delete();
        return ['message' => 'Delete Success'];
    }
}
