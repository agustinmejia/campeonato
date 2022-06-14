<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Championship;

class ChampionshipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('championships.browse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('championships.edit-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        dd(array_unique(array_merge($request->local_id,$request->visitor_id), SORT_REGULAR));
        try {
            $championship = Championship::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'start' => $request->start,
                'finish' => $request->finish,
                'year' => date('Y', strtotime($request->start)) == date('Y', strtotime($request->finish)) ? date('Y', strtotime($request->start)) : date('Y', strtotime($request->start)).'-'.date('Y', strtotime($request->finish))
            ]);
        } catch (\Throwable $th) {
            //dd($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
