<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Tupoksijft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TupoksiJftController extends Controller
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
        // $jft= DB::table('positions')
        // ->join('tupoksijft', 'tupoksijft.id_jabatan', '=', 'positions.id')
        // ->get();

        $user = auth('api')->user();
        $jft= DB::table('tupoksijft')
        ->where('id_jabatan', '=', $user->id_jafung )
        ->get();

        return $jft;
    }

    public function filterJabatan(Request $request)
    {
        //
        $this->validate($request, [
            'id_jabatan' => 'required',
        ]);

        $jft= DB::table('tupoksijft')
        ->where('id_jabatan', '=', $request['id_jabatan'] )
        ->get();

        $jabatan= DB::table('positions')
        ->where('id', '=', $request['id_jabatan'])
        ->first();

        return ['jft'=>$jft, 'jabatan'=>$jabatan->jabatan, 'id'=>$jabatan->id];
    }

    public function jftById($id)
    {
        //
        $jft= DB::table('tupoksijft')
        ->where('id_jabatan', '=', $id )
        ->get();

        $jabatan= DB::table('positions')
        ->where('id', '=', $id)
        ->first();

        return ['jft'=>$jft, 'jabatan'=>$jabatan->jabatan, 'id'=>$jabatan->id];
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
                Rule::unique('tupoksijft')->where(function ($query) use ($request) {
                    return $query->where('id_jabatan', $request->id_jabatan);
                //    ->where('butir_kegiatan', $request->butir_kegiatan);
                })
            ],
        ]);

        Tupoksijft::create($request->all());
        return ['message' => 'Create Success'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tupoksijft  $tupoksijft
     * @return \Illuminate\Http\Response
     */
    public function show(Tupoksijft $tupoksijft)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tupoksijft  $tupoksijft
     * @return \Illuminate\Http\Response
     */
    public function edit(Tupoksijft $tupoksijft)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tupoksijft  $tupoksijft
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tupoksijft $tupoksijft)
    {
        //
        $tupoksijft = Tupoksijft::findOrFail($request->id);

        $this->validate($request, [
            'id_jabatan' => 'required',
            'butir_kegiatan' => [
                'required',
                Rule::unique('tupoksijft')->where(function ($query) use ($request) {
                    return $query->where('id_jabatan', $request->id_jabatan);
                //    ->where('butir_kegiatan', $request->butir_kegiatan);
                })->ignore($request->id)
            ],
        ]);
        $tupoksijft->update($request->all());
        return ['message' => "success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tupoksijft  $tupoksijft
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tupoksijft = Tupoksijft::findOrFail($id);
        $tupoksijft->delete();
        return ['message' => 'Tupoksi Deleted'];
    }
}
