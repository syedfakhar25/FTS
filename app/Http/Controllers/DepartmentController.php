<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departments = new Department;
        if (isset($request->searchq) && !empty($request->searchq)) {
            $departments = $departments->where('title','LIKE','%'.$request->searchq.'%');
        }
        $departments = $departments->paginate(10);

        return view('department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = Department::create($request->all());

        $logo='';
        if($request->has('logo'))
        {

            $file = $request->logo;
            $logo = $file->store('department-files/department-'.$department->id,'public');
        }
        $department->update(['logo_path'=>$logo]);


        session()->flash('message', 'Department created successfully.');
        return redirect()->route('department.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartmentRequest  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $logo='';
        if($request->has('logo'))
        {

            $file = $request->logo;
            $logo = $file->store('department-files/department-'.$department->id,'public');

            $request->merge([
                'logo_path'=> $logo
            ]);
        }



        $department->update($request->all());
        session()->flash('message', 'Department successfully updated.');
        return redirect()->route('department.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        Storage::deleteDirectory('public/department-files/department-' . $department->id);
        $department->delete();
        session()->flash('message', 'Department successfully deleted.');
        return redirect()->route('department.index');
    }
}
