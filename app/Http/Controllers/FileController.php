<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\FileDetail;
use App\Models\MasterFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->type) && $request->type=='received')
        {
            $files = new File();
            $files = $files->leftJoin('file_details', 'files.id','=','file_details.file_id')
                ->where('file_details.type','Receive')
                ->where('file_details.by_department_id',Auth::user()->department_id)
                ->where('files.department_id','<>',Auth::user()->department_id);

            if(isset($request->status) && $request->status=='in')
            {
                $files = $files->where('files.curr_department_id',Auth::user()->department_id);
            }

            if(isset($request->status) && $request->status=='out')
            {
                $files = $files->where(function ($q) {
                    $q->where('files.curr_department_id','<>',Auth::user()->department_id)
                        ->orWhere('files.curr_department_id',null);
                });
            }

            $files = $files->select('files.*')->distinct('files.id')->paginate();
            //dd($files);
            return view('file.received', compact('files'));
        }
        else
        {
            $files = new File();
            if (isset($request->searchq) && !empty($request->searchq)) {

                $files = $files->where('files.title','LIKE','%'.$request->searchq.'%')
                    ->orWhere('files.tracking_no','LIKE','%'.$request->searchq.'%')
                    ->orWhere('files.description','LIKE','%'.$request->searchq.'%');
            }
            if (isset($request->status) && !empty($request->status)) {
                if($request->status == 'Delayed')
                {
                    $files = $files->where('files.status','Under Process')->where('files.delay_after_date','<',date('Y-m-d'));
                }
                else
                {
                    $files = $files->where('files.status',$request->status);

                    if($request->status == 'Under Process' && isset($request->indep) && !empty($request->indep))
                    {
                        if($request->indep == 'intransit')
                        {
                            $files = $files->where('files.curr_department_id',null);
                        }
                        else if($request->indep == 'self')
                        {
                            $files = $files->where('files.curr_department_id',Auth::user()->department_id);
                        }
                        else if($request->indep == 'other')
                        {
                            $files = $files->where('files.curr_department_id','<>',Auth::user()->department_id);
                        }
                        else
                        {
                            $files = $files->where('files.curr_department_id',$request->indep);
                        }
                    }
                }
            }

            $departments = [];
            if(!Auth::user()->hasRole('Administrator'))
            {
                $files = $files->where('files.department_id','=',Auth::user()->department_id);
            }
            else
            {
                $departments = Department::all();
                if(isset($request->department_id) && $request->department_id>0)
                {
                    $files = $files->where('files.department_id','=',$request->department_id);
                }
            }

            $files = $files->select('files.*')->paginate(10);

            return view('file.index', compact('files','departments'));
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::where('id','<>',Auth::user()->department_id)->get();
        return view('file.create',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileRequest $request)
    {
        if($request->file_type =='copy')
        {
            $tc = $request->tracking_code;
            $oFile = File::where('tracking_no',$tc)->first();

            if($oFile){
                if($oFile->curr_department_id == Auth::user()->department_id)
                {
                    $request->merge(['title'=>'Copy - '.$oFile->title]);
                    $request->merge(['copy_of'=>$oFile->id]);
                    $request->merge(['attachments'=>$oFile->attachments]);

                }
                else
                {
                    session()->flash('err_message', 'You cannot create copy of this file.');
                    return to_route('file.create');

                }
            }
            else
            {
                session()->flash('err_message', 'File not found.');
                return to_route('file.create');
            }
        }

        $dep_shrtcode = Auth::user()->department->short_code;
        $year = Auth::user()->department->file_year;
        $month = Auth::user()->department->file_month;
        $day = Auth::user()->department->file_date;
        $filenum =  Auth::user()->department->file_counter;

        if($year != date('y'))
        {
            $year= date('y');
            $month= date('m');
            $day= date('d');
            $filenum= 1;
        }
        else{
            if($month != date('m'))
            {
                $month= date('m');
            }
            if($day != date('d'))
            {
                $day= date('d');
            }
            if(empty($filenum))
            {
                $filenum= 1;
            }
            else
            {
                $filenum++;
            }
        }

        $tn = $dep_shrtcode.'-'.$year.$month.'-'.$day.$filenum;

        Auth::user()->department->update(['file_year'=>$year,'file_month'=>$month,'file_date'=>$day,'file_counter'=>$filenum]);
        $request->merge(['department_id'=>Auth::user()->department_id]);
        $request->merge(['tracking_no'=>$tn]);

        $newfile = File::create($request->all());


        $attachments='';
        if($request->has('attach_files'))
        {
            foreach($request->attach_files as $file)
                $attachments .= $file->store('file-attachments/file-'.$newfile->id,'public').',';
            $newfile->update(['attachments'=>$attachments]);
        }

        FileDetail::create([
            'file_id'=>$newfile->id,
            'type'=>'Send',
            'by_department_id'=>Auth::user()->department_id,
            'ref_department_id'=>$request->send_to,
            'no_of_attachments'=>$request->no_of_attachments,
            'attachments'=>$attachments,
        ]);

        session()->flash('message', 'File Created & please make sure to paste QR code on file before dispatching.');
        session()->flash('fileprintlabel', $newfile->id);
        return to_route('dashboard');
    }
    public function printlabel(File $file)
    {
        if($file)
        {
            if($file->department_id != Auth::user()->department_id)
            {
                session()->flash('err_message', 'You cannot create label for this file.');
            }
        }
        else
        {
            session()->flash('err_message', 'File Not found.');
        }
        return view('file.printlabel',compact('file'));
    }
    public function checkattachments(Request $request)
    {
        $tracking_code=$request->tracking_code;
        $file = File::where('tracking_no',$tracking_code)->first();
        $status = true;
        $no_of_attachments = 0;
        if($file) {
            $no_of_attachments = $file->no_of_attachments;
            $msg = 'File found.';
        }else{
            $status = false;
            $msg = 'File not found.';
        }

        $r_msg ='';
        if($status)
        {
            $r_msg = '<div class="pb-5 msg_alert">
                            <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-700 bg-green-100 border border-green-300 ">
                                <div slot="avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle w-5 h-5 mr-2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </div>
                                <div class="font-normal  max-w-full flex-initial">'.$msg.'</div>
                                <div class="flex flex-auto flex-row-reverse">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2" onclick="$(\'.msg_alert\').hide();">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                    </div>';
        }
        else
        {
            $r_msg = '<div class="pb-5 msg_alert">
                            <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-red-700 bg-red-100 border border-red-300 ">
                                <div slot="avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="font-normal  max-w-full flex-initial">'.$msg.'</div>
                                <div class="flex flex-auto flex-row-reverse">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2" onclick="$(\'.msg_alert\').hide();">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                    </div>';
        }
        $rarray = ['status'=>$status,'message'=>$r_msg,'no_of_attachments'=>$no_of_attachments];

        return $rarray;
    }
    public function send(Request $request){
        //dd('MIA');
        $status=false;
        $msg='';
        $tracking_code=$request->tracking_code;
        $department_to=$request->send_to;
        $file_status=$request->status;
        $no_of_attachments=$request->no_of_attachments;

        if(!empty($tracking_code) && !empty($department_to))
        {
            $file = File::where('tracking_no',$tracking_code)->first();
            if($file)
            {
                if($file->curr_department_id == Auth::user()->department_id)
                {
                    $prev_recvied = FileDetail::where('file_id',$file->id)
                        ->where('type','receive')
                        ->WhereNull('ref_file_detail')->orderBy('created_at', 'desc')->first();
                    if($prev_recvied) {

                        $recv_det = $prev_recvied->ref_department->short_code . '-' . date('Ymd',strtotime($prev_recvied->created_at)) . '-' . $prev_recvied->id;

                        $sent_file = FileDetail::create([
                            'file_id' => $file->id,
                            'type' => 'Send',
                            'by_department_id' => Auth::user()->department_id,
                            'ref_department_id' => $department_to,
                            'no_of_attachments' => $no_of_attachments,
                            'ref_file_detail' => $recv_det,
                        ]);
                        $file->update(['curr_department_id' => null, 'curr_received_date' => null, 'delay_after_date' => null, 'no_of_attachments' => $no_of_attachments, 'status' => $file_status]);

                        $send_det = $sent_file->ref_department->short_code . '-' . date('Ymd',strtotime($sent_file->created_at))  . '-' . $sent_file->id;

                        $prev_recvied->update([
                            'ref_file_detail' => $send_det,
                        ]);

                        $status = true;
                        $msg = 'File has been sent successfully.';


                    }
                    else
                    {
                        $msg='You have not received this file ever.';
                    }
                }
                else{
                    $msg='You cannot send this file.';
                }

            }
            else
            {
                $msg='Invalid tracking code provided.';
            }
        }
        else
        {
            $msg='Please provide all the required data.';
        }

        $r_msg ='';
        if($status)
        {
            $r_msg = '<div class="pb-5 msg_alert">
                            <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-700 bg-green-100 border border-green-300 ">
                                <div slot="avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle w-5 h-5 mr-2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </div>
                                <div class="font-normal  max-w-full flex-initial">'.$msg.'</div>
                                <div class="flex flex-auto flex-row-reverse">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2" onclick="$(\'.msg_alert\').hide();">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                    </div>';
        }
        else
        {
            $r_msg = '<div class="pb-5 msg_alert">
                            <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-red-700 bg-red-100 border border-red-300 ">
                                <div slot="avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="font-normal  max-w-full flex-initial">'.$msg.'</div>
                                <div class="flex flex-auto flex-row-reverse">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2" onclick="$(\'.msg_alert\').hide();">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                    </div>';
        }

        $rarray = ['status'=>$status,'message'=>$r_msg];

        return $rarray;
    }
    public function receive(Request $request){
        $status=false;
        $msg='';
        $tracking_code=$request->tracking_code;
        $no_of_attachments=$request->no_of_attachments;
        if(!empty($tracking_code) )
        {
            $file = File::where('tracking_no',$tracking_code)->first();

            if($file)
            {
                if(empty($file->curr_department_id))
                {
                    $fdetails = $file->filedetails->last();

                    //dd($fdetails);
                    if($fdetails && $fdetails->ref_department_id == Auth::user()->department_id && $fdetails->type == 'Send')
                    {

                        FileDetail::create([
                            'file_id'=>$file->id,
                            'type'=>'Receive',
                            'by_department_id'=>Auth::user()->department_id,
                            'ref_department_id'=>$fdetails->by_department_id,
                            'no_of_attachments'=>$no_of_attachments,
                        ]);
                        $due_date = date("Y-m-d H:i:s",strtotime('+'.Auth::user()->department->delay_threshhold.' days'));
                        $file->update(['curr_department_id'=>Auth::user()->department_id,'curr_received_date'=>date('Y-m-d H:i:s'),'delay_after_date'=>$due_date]);
                        $status=true;
                        $msg='File has been received successfully.';
                    }
                    else{
                        $msg='You cannot receive this file.';
                    }
                }
                else
                {
                    $msg='You cannot receive this file.';
                }
            }
            else
            {
                $msg='Invalid tracking code provided.';
            }
        }
        else
        {
            $msg='Please provide all the required data.';
        }

        $r_msg ='';
        if($status)
        {
            $r_msg = '<div class="pb-5 msg_alert">
                            <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-green-700 bg-green-100 border border-green-300 ">
                                <div slot="avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle w-5 h-5 mr-2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </div>
                                <div class="font-normal  max-w-full flex-initial">'.$msg.'</div>
                                <div class="flex flex-auto flex-row-reverse">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2" onclick="$(\'.msg_alert\').hide();">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                    </div>';
        }
        else
        {
            $r_msg = '<div class="pb-5 msg_alert">
                            <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-md text-red-700 bg-red-100 border border-red-300 ">
                                <div slot="avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="font-normal  max-w-full flex-initial">'.$msg.'</div>
                                <div class="flex flex-auto flex-row-reverse">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x cursor-pointer hover:text-green-400 rounded-full w-5 h-5 ml-2" onclick="$(\'.msg_alert\').hide();">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                    </div>';
        }

        $rarray = ['status'=>$status,'message'=>$r_msg];

        return $rarray;
    }
    public function close(File $file){
        if($file->department_id == Auth::user()->department_id)
        {
            if($file->department_id == $file->curr_department_id)
            {
                if($file->status == 'Under Process')
                {
                    FileDetail::create([
                        'file_id'=>$file->id,
                        'type'=>'Close',
                        'by_department_id'=>Auth::user()->department_id,
                    ]);
                    $file->update(['status'=>'Closed']);
                    $childFiles = File::where('copy_of',$file->id)-get();
                    if($childFiles)
                    {
                        foreach($childFiles as $cFile)
                        {
                            FileDetail::create([
                                'file_id'=>$cFile->id,
                                'type'=>'Close',
                                'by_department_id'=>Auth::user()->department_id,
                            ]);
                            $cFile->update(['status'=>'Closed']);
                        }
                    }

                    session()->flash('message', 'File has been closed successfully, you will not be able to send this file now.');
                }
                else
                {
                    session()->flash('err_message', 'You cannot close a file that already been closed.');
                }
            }
            else
            {
                session()->flash('err_message', 'You cannot close this file, until it comes to your department.');
            }
        }
        else
        {
            session()->flash('err_message', 'You can only close your own deprtment\'s files.');
        }
        return to_route('file.show',$file->id);
    }
    public function reopen(File $file){
        if($file->department_id == Auth::user()->department_id)
        {
            if($file->department_id == $file->curr_department_id)
            {
                if($file->status == 'Closed')
                {
                    FileDetail::create([
                        'file_id'=>$file->id,
                        'type'=>'Reopen',
                        'by_department_id'=>Auth::user()->department_id,
                    ]);
                    $file->update(['status'=>'Under Process']);
                    session()->flash('message', 'File has been reopened successfully, you will be able to send this file now.');
                }
                else
                {
                    session()->flash('err_message', 'You cannot reopen a file that already been under process.');
                }
            }
            else
            {
                session()->flash('err_message', 'You cannot reopen this file, until it comes to your department.');
            }
        }
        else
        {
            session()->flash('err_message', 'You can only reopen your own deprtment\'s files.');
        }
        return to_route('file.show',$file->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //dd($file->filedetails);
        if(Auth::user()->hasRole('Administrator') || $file->department_id == Auth::user()->department_id || $file->curr_department_id == Auth::user()->department_id || $file->filedetails->where('by_department_id',Auth::user()->department_id)->count() > 0)
        {
            return view('file.show', compact('file'));
        }
        else
        {
            session()->flash('err_message', 'You cannot see details for selected file.');
            return redirect()->route('file.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {

        return view('file.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFileRequest  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        $file->update($request->all());

        session()->flash('message', 'file successfully updated.');
        return redirect()->route('file.show',$file->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $file->delete();
        session()->flash('message', 'File successfully deleted.');
        return redirect()->route('file.index');
    }


    public function reports(Request $request)
    {
        return view('file.reports');
    }
    public function reports_receive(Request $request)
    {
        $departments = Department::all();
        $filesDetails = DB::table('file_details')
            ->leftJoin('departments', 'file_details.ref_department_id', '=', 'departments.id')
            ->leftJoin('files', 'file_details.file_id', '=', 'files.id')
            ->select('file_details.*','files.title','files.status','files.tracking_no','departments.title as department_name')
            ->where('file_details.type','Receive')
            ->where('file_details.by_department_id',Auth::user()->department_id);


        if (isset($request->date_range) && !empty($request->date_range)) {
            $dates = explode(' – ', $request->date_range);

            $fdate = @$dates[0];
            $tdate = @$dates[1];
            if (!empty($fdate) && !empty($tdate)) {
                $datetime1 = new \DateTime($fdate);
                $datetime2 = new \DateTime($tdate);
                $interval = $datetime1->diff($datetime2);
                $days = $interval->format('%a');

                if ($days >= 0) {
                    $filesDetails = $filesDetails
                        ->where('file_details.created_at', '>=', $datetime1->format('Y-m-d 00:00:00'))
                        ->where('file_details.created_at', '<=', $datetime2->format('Y-m-d 23:59:59'));
                } else {
                    return redirect()->route('reports_receive');
                }
            } else {
                return redirect()->route('reports_receive');
            }
        }
        if(isset($request->department_id) && $request->department_id>0)
        {
            $filesDetails = $filesDetails->where('file_details.ref_department_id','=',$request->department_id);
        }
        if (isset($request->status) && !empty($request->status)) {
            if($request->status == 'Delayed')
            {
                $filesDetails = $filesDetails->where('files.status','Under Process')->where('files.delay_after_date','<',date('Y-m-d'));
            }
            else
            {
                $filesDetails = $filesDetails->where('files.status',$request->status);
            }
        }
        $filesDetails = $filesDetails->get();

        //dd($filesDetails);
        return view('file.reports_receive',compact('filesDetails','departments'));
    }
    public function reports_dispatch(Request $request)
    {
        $departments = Department::all();

        $filesDetails = DB::table('file_details')
            ->leftJoin('departments', 'file_details.ref_department_id', '=', 'departments.id')
            ->leftJoin('files', 'file_details.file_id', '=', 'files.id')
            ->select('file_details.*','files.title','files.status','files.tracking_no','departments.title as department_name')
            ->where('file_details.type','Send')
            ->where('file_details.by_department_id',Auth::user()->department_id);


        if (isset($request->date_range) && !empty($request->date_range)) {
            $dates = explode(' – ', $request->date_range);

            $fdate = @$dates[0];
            $tdate = @$dates[1];
            if (!empty($fdate) && !empty($tdate)) {
                $datetime1 = new \DateTime($fdate);
                $datetime2 = new \DateTime($tdate);
                $interval = $datetime1->diff($datetime2);
                $days = $interval->format('%a');

                if ($days >= 0) {
                    $filesDetails = $filesDetails
                        ->where('file_details.created_at', '>=', $datetime1->format('Y-m-d 00:00:00'))
                        ->where('file_details.created_at', '<=', $datetime2->format('Y-m-d 23:59:59'));
                } else {
                    return redirect()->route('reports_dispatch');
                }
            } else {
                return redirect()->route('reports_dispatch');
            }
        }

        if(isset($request->department_id) && $request->department_id>0)
        {
            $filesDetails = $filesDetails->where('file_details.ref_department_id','=',$request->department_id);
        }
        if (isset($request->status) && !empty($request->status)) {
            if($request->status == 'Delayed')
            {
                $filesDetails = $filesDetails->where('files.status','Under Process')->where('files.delay_after_date','<',date('Y-m-d'));
            }
            else
            {
                $filesDetails = $filesDetails->where('files.status',$request->status);
            }
        }
        $filesDetails = $filesDetails->get();

        //dd($filesDetails);
        return view('file.reports_dispatch',compact('filesDetails','departments'));
    }
}
