<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Rkk;
use Illuminate\Http\Request;

class RkkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rkk = Rkk::all();
        return $rkk;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rkk  $rkk
     * @return \Illuminate\Http\Response
     */
    public function show(Rkk $rkk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rkk  $rkk
     * @return \Illuminate\Http\Response
     */
    public function edit(Rkk $rkk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rkk  $rkk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rkk $rkk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rkk  $rkk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rkk $rkk)
    {
        //
    }
}
