<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\File;
use App\Models\FileDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //

    public function index()
    {
        if(Auth::user()->hasRole('DepartmentDispatchOfficer') )
        {
            $departments = Department::where('id','<>',Auth::user()->department_id)->get();
            return view('dashboard_dispatch_officer',compact('departments'));
        }
        elseif(Auth::user()->hasRole('DepartmentAdmin'))
        {

            $totalFilesCreated = File::where('department_id',Auth::user()->department_id)->count();
            $totalFilesClosed = File::where('department_id',Auth::user()->department_id)->where('status','Closed')->count();
            $totalFilesUnderProcess = File::where('department_id',Auth::user()->department_id)->whereIn('status',['Under Process','Objection','Speak'])->count();
            $totalFilesSpeak = File::where('department_id',Auth::user()->department_id)->where('status','Speak')->count();
            $totalFilesObjection = File::where('department_id',Auth::user()->department_id)->where('status','Objection')->count();

            $totalFilesReceived = File::leftJoin('file_details', 'files.id','=','file_details.file_id')
                ->where('file_details.type','Receive')
                ->where('file_details.by_department_id',Auth::user()->department_id)
                ->where('files.department_id','<>',Auth::user()->department_id)
                ->distinct('files.id')
                ->count();


            $totalFilesReceivedstill = File::leftJoin('file_details', 'files.id','=','file_details.file_id')
                ->where('file_details.type','Receive')
                ->where('file_details.by_department_id',Auth::user()->department_id)
                ->where('files.department_id','<>',Auth::user()->department_id)
                ->where('files.curr_department_id',Auth::user()->department_id)
                ->distinct('files.id')
                ->count();

            $totalFilesReceivedforwarded = File::leftJoin('file_details', 'files.id','=','file_details.file_id')
                ->where('file_details.type','Receive')
                ->where('file_details.by_department_id',Auth::user()->department_id)
                ->where('files.department_id','<>',Auth::user()->department_id)
                ->where(function ($q) {
                    $q->where('files.curr_department_id','<>',Auth::user()->department_id)
                        ->orWhere('files.curr_department_id',null);
                })
                ->distinct('files.id')
                ->count();

            //dd(DB::getQueryLog());
            /*$totalFilesReceivedStillinOffice = FileDetail::leftJoin('files', 'file_details.file_id','=','files.id')
                ->where('file_details.ref_department_id',Auth::user()->department_id)
                ->where('files.department_id','<>',Auth::user()->department_id)
                ->where('file_details.type','Receive')
                ->where('files.curr_department_id',Auth::user()->department_id)
                ->count();

            $totalFilesReceivedReturenBack = FileDetail::leftJoin('files', 'file_details.file_id','=','files.id')
                ->where('file_details.ref_department_id',Auth::user()->department_id)
                ->where('files.department_id','<>',Auth::user()->department_id)
                ->where('file_details.type','Receive')
                ->where('files.curr_department_id','<>',Auth::user()->department_id)
                ->count();
            $totalFilesReceivedInTransit = FileDetail::leftJoin('files', 'file_details.file_id','=','files.id')
                ->where('file_details.ref_department_id',Auth::user()->department_id)
                ->where('files.department_id','<>',Auth::user()->department_id)
                ->where('file_details.type','Receive')
                ->where('files.curr_department_id',null)
                ->count();*/

            return view('dashboard_department_admin',compact('totalFilesCreated','totalFilesClosed','totalFilesUnderProcess'
                ,'totalFilesReceived','totalFilesReceivedstill','totalFilesReceivedforwarded'
            ));
        }
        else
        {
            $totalFilesCreated = File::count();
            $totalFilesClosed = File::where('status','Closed')->count();
            $totalFilesUnderProcess = File::whereIn('status',['Under Process','Objection','Speak'])->count();
            $totalFilesDelayed = File::whereIn('status',['Under Process','Objection','Speak'])->where('delay_after_date','<',date('Y-m-d H:i:s'))->count();
            $totalFilesIntransit = File::whereIn('status',['Under Process','Objection','Speak'])->where('curr_department_id',null)->count();
            $totalFilesSpeak = File::where('status','Speak')->count();
            $totalFilesObjection = File::where('status','Objection')->count();

            $Depfiles = File::get()->groupBy('department_id');

            return view('dashboard_administrator',compact('Depfiles','totalFilesCreated','totalFilesClosed','totalFilesUnderProcess','totalFilesDelayed','totalFilesIntransit','totalFilesObjection', 'totalFilesSpeak'));
        }
    }
    public function fileup()
    {
        if(Auth::user()->hasRole('DepartmentAdmin')) {
            $totalFilesIntransit = File::where('department_id',Auth::user()->department_id)->whereIn('status',['Under Process','Objection','Speak'])->where('curr_department_id',null)->count();
            $totalFilesReceivedBack = File::where('department_id',Auth::user()->department_id)->whereIn('status',['Under Process','Objection','Speak'])->where('curr_department_id',Auth::user()->department_id)->count();
            $totalFilesdelayed = File::where('department_id',Auth::user()->department_id)->whereIn('status',['Under Process','Objection','Speak'])->where('delay_after_date','<',date('Y-m-d H:i:s'))->count();
            $totalFilesOtherDeps = File::where('department_id',Auth::user()->department_id)->whereIn('status',['Under Process','Objection','Speak'])->where('curr_department_id','<>',Auth::user()->department_id)->where('curr_department_id','<>',null)->get()->groupBy('curr_department_id');
            return view('dashboard_department_admin_up',compact('totalFilesIntransit','totalFilesReceivedBack','totalFilesOtherDeps','totalFilesdelayed'));
        }
        else {
            return redirect()->route('dashboard');
        }
    }

    public function depfilesd(Request $request)
    {
        //dd('MIA');
        if(Auth::user()->hasRole('Administrator') &&  $request->dep>0) {
            $dep_id = $request->dep;
            $dep_details = Department::where('id',$dep_id)->first();

            $totalFiles = File::where('department_id',$dep_id)->count();
            $totalFilesClosed = File::where('department_id',$dep_id)->where('status','Closed')->count();
            $totalFilesUnderProcess = File::where('department_id',$dep_id)->whereIn('status',['Under Process','Objection','Speak'])->count();
            return view('dashboard_administrator_depdetails',compact('dep_details','totalFiles','totalFilesClosed','totalFilesUnderProcess'));
        }
        else {
            to_route('dashboard');
        }

    }
}
