<?php

namespace App\Http\Controllers;

use App\Models\FileDetail;
use App\Http\Requests\StoreFileDetailRequest;
use App\Http\Requests\UpdateFileDetailRequest;

class FileDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreFileDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileDetail  $fileDetail
     * @return \Illuminate\Http\Response
     */
    public function show(FileDetail $fileDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileDetail  $fileDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(FileDetail $fileDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFileDetailRequest  $request
     * @param  \App\Models\FileDetail  $fileDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileDetailRequest $request, FileDetail $fileDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileDetail  $fileDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileDetail $fileDetail)
    {
        //
    }
}
