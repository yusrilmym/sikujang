<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tupoksijfu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TupoksiJfuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jfu= DB::table('positions')
        ->join('tupoksijfu', 'tupoksijfu.id_jabatan', '=', 'positions.id')
        ->get();

        return $jfu;
    }
    public function filterJabatan(Request $request)
    {
        //
        $this->validate($request, [
            'id_jabatan' => 'required',
        ]);

        $jfu= DB::table('tupoksijfu')
        ->where('id_jabatan', '=', $request['id_jabatan'] )
        ->get();

        $jabatan= DB::table('positions')
        ->where('id', '=', $request['id_jabatan'])
        ->first();

        return ['jfu'=>$jfu, 'jabatan'=>$jabatan->jabatan, 'id'=>$jabatan->id];
    }

    public function jfuById($id)
    {
        //
        $jfu= DB::table('tupoksijfu')
        ->where('id_jabatan', '=', $id )
        ->get();

        $jabatan= DB::table('positions')
        ->where('id', '=', $id)
        ->first();

        return ['jfu'=>$jfu, 'jabatan'=>$jabatan->jabatan, 'id'=>$jabatan->id];
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
            'id_jabatan' => 'required',
            'uraian_tugas' => [
                'required',
                Rule::unique('tupoksijfu')->where(function ($query) use ($request) {
                    return $query->where('id_jabatan', $request->id_jabatan);
                })
            ],
        ]);

        Tupoksijfu::create($request->all());
        return ['message' => 'Create Success'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tupoksijfu  $tupoksijfu
     * @return \Illuminate\Http\Response
     */
    public function show(Tupoksijfu $tupoksijfu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tupoksijfu  $tupoksijfu
     * @return \Illuminate\Http\Response
     */
    public function edit(Tupoksijfu $tupoksijfu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tupoksijfu  $tupoksijfu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tupoksijfu $tupoksijfu)
    {
        //
        $tupoksijfu = Tupoksijfu::findOrFail($request->id);

        $this->validate($request, [
            'id_jabatan' => 'required',
            'uraian_tugas' => [
                'required',
                Rule::unique('tupoksijfu')->where(function ($query) use ($request) {
                    return $query->where('id_jabatan', $request->id_jabatan);
                })->ignore($request->id)
            ],
        ]);
        $tupoksijfu->update($request->all());
        return ['message' => "success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tupoksijfu  $tupoksijfu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tupoksijfu = Tupoksijfu::findOrFail($id);
        $tupoksijfu->delete();
        return ['message' => 'Tupoksi Deleted'];
    }
}
