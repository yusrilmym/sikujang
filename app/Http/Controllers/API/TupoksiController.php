<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tupoksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TupoksiController extends Controller
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
    }

    public function filterJabatan(Request $request)
    {
        //
        $this->validate($request, [
            'id_jabatan' => 'required',
        ]);

        $tupoksi= DB::table('tupoksis')
        ->where('id_jabatan', '=', $request['id_jabatan'] )
        ->get();

        $jabatan= DB::table('positions')
        ->where('id', '=', $request['id_jabatan'])
        ->first();

        return ['tupoksi'=>$tupoksi, 'jabatan'=>$jabatan->jabatan, 'id'=>$jabatan->id];
    }

    public function tupoksiById($id)
    {
        //
        $tupoksi= DB::table('tupoksis')
        ->where('id_jabatan', '=', $id )
        ->get();

        $jabatan= DB::table('positions')
        ->where('id', '=', $id)
        ->first();

        return ['tupoksi'=>$tupoksi, 'jabatan'=>$jabatan->jabatan, 'id'=>$jabatan->id];
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
            'butir_kegiatan' => [
                'required',
                Rule::unique('tupoksis')->where(function ($query) use ($request) {
                    return $query->where('id_jabatan', $request->id_jabatan);
                //    ->where('butir_kegiatan', $request->butir_kegiatan);
                })
            ],
        ]);

        Tupoksi::create($request->all());
        return ['message' => 'Create Success'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tupoksi  $tupoksi
     * @return \Illuminate\Http\Response
     */
    public function show(Tupoksi $tupoksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tupoksi  $tupoksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Tupoksi $tupoksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tupoksi  $tupoksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tupoksi $tupoksi)
    {
        //
        $this->validate($request, [
            'id_jabatan' => 'required',
            'butir_kegiatan' => [
                'required',
                Rule::unique('tupoksis')->where(function ($query) use ($request) {
                    return $query->where('id_jabatan', $request->id_jabatan);
                //    ->where('butir_kegiatan', $request->butir_kegiatan);
                })->ignore($request->id)
            ],
        ]);
        $tupoksi->update($request->all());
        return ['message' => "success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tupoksi  $tupoksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tupoksi $tupoksi)
    {
        //
        $tupoksi->delete();
        return ['message' => 'Tupoksi Deleted'];
    }
}
