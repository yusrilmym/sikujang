<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
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
        //show all
            return Unit::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //tambah
        $this->validate($request, [
            'nama_unit' => 'required|string|max:191|unique:units',
            'bagian' => 'required',
        ]);

        return Unit::create([
            'nama_unit' => $request['nama_unit'],
            'bagian' => $request['bagian'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
        return $unit;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        //edit
        $this->validate($request, [
            'nama_unit' => 'required|string|max:255|unique:units,nama_unit,'.$unit->id,
            'bagian' => 'required',
        ]);

        $unit->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return ['message' => 'Unit Deleted'];
    }

    public function unitByBagian(Request $request)
    {
        $user = auth('api')->user();
        $bagian = Unit::where('id', '=', $user->id_unit)->select('bagian')->first();
        $query = DB::table('units')->where('bagian', '=', $bagian->bagian)
        ->select('id','bagian', 'nama_unit')->get();
        return $query;
    }
}
