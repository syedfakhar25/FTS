<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::leftJoin('departments', 'users.department_id','=','departments.id');
        if (isset($request->searchq) && !empty($request->searchq)) {
            $users = $users->where('users.name','LIKE','%'.$request->searchq.'%')
                ->orwhere('users.email','LIKE','%'.$request->searchq.'%')
                ->orWhere('departments.title','LIKE','%'.$request->searchq.'%');
        }
        $users = $users->role(['DepartmentAdmin','DepartmentDispatchOfficer'])->select('users.*','departments.title as department')->paginate(10);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        return view('user.create',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        $request->merge(['password' => Hash::make($request->password)]);

        $user = User::create($request->all());
        $user->assignRole($request->role);

        $profile_photo='';
        if($request->has('profile_photo'))
        {
            $file = $request->profile_photo;
            $profile_photo = $file->store('profile-photos','public');
        }
        $user->update(['profile_photo_path'=>$profile_photo]);


        session()->flash('message', 'User created successfully.');
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if($user->getRoleNames() == '["Administrator"]')
        {
            return redirect()->route('user.index');
        }
        else
        {
            $departments = Department::all();
            return view('user.edit', compact('user','departments'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $profile_photo='';
        if($request->has('profile_photo'))
        {

            $file = $request->profile_photo;
            $profile_photo = $file->store('profile-photos','public');

            $request->merge([
                'profile_photo_path'=> $profile_photo
            ]);
        }
        if(!empty($request->password))
            $request->merge(['password' => Hash::make($request->password)]);
        else
            unset($request['password']);


        $user->update($request->all());

        $user->removeRole($user->roles->first());
        $user->assignRole($request->role);

        session()->flash('message', 'User successfully updated.');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Storage::delete('public/profile-photos/' . $user->profile_photo_path);
        $user->delete();
        session()->flash('message', 'User successfully deleted.');
        return redirect()->route('user.index');
    }
}
