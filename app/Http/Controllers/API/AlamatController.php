<?php

namespace App\Http\Controllers\API;

use App\Alamat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlamatController extends Controller
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
        if (\Gate::allows('isSuperAdmin') || \Gate::allows('isAdmin') || \Gate::allows('isLord')){
            return Alamat::all();
        }
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
        //tambah
        $this->validate($request, [
            'jabatan' => 'required|string|max:191|unique:alamats',
            'kategori' => 'required|string|max:191',
        ]);

        Alamat::create($request->all());
        return ['message' => "success"];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Alamat  $alamat
     * @return \Illuminate\Http\Response
     */
    public function show(Alamat $alamat)
    {
        return $alamat;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Alamat  $alamat
     * @return \Illuminate\Http\Response
     */
    public function edit(Alamat $alamat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Alamat  $alamat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alamat $alamat)
    {
        $this->validate($request, [
            //
        ]);

        $alamat->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Alamat  $alamat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alamat $alamat)
    {
        $alamat->delete();
        return ['message' => 'User Delete'];
    }
}
