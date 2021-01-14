<?php

namespace App\Http\Controllers\API;

use App\Position;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
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
        // if (\Gate::allows('isSuperAdmin') || \Gate::allows('isSys') || \Gate::allows('isAdmin')){
            return Position::all();
        // }
        // return ['message' => "success"];
    }

    public function showJft()
    {
        return Position::where('jenis_jabatan', '=', 'jft')->get();
    }

    public function showJfu()
    {
        return Position::where('jenis_jabatan', '=', 'jfu')->get();
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
            'jabatan' => 'required|string|max:191|unique:positions',
            'kategori' => 'required|string|max:191',
            'shifting' => 'required|string|max:191',
            'jenis_jabatan' => 'required|string|max:191',
        ]);

        Position::create($request->all());

        return ['message' => 'Create Success'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        return $position;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Position $position)
    {
        //edit

        $this->validate($request, [
            'jabatan' => 'required|string|max:255|unique:positions,jabatan,'.$position->id,
            'kategori' => 'required|string|max:191',
            'shifting' => 'required|string|max:191',
            'jenis_jabatan' => 'required|string|max:191',
        ]);

        $position->update($request->all());
        return ['message' => 'Update Success'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        $position->delete();
        return ['message' => 'Delete Success'];
    }
}
