<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'tracking_no', 'title','description','status','attachments','department_id','curr_department_id','curr_received_date','delay_after_date','no_of_attachments','file_type','copy_of'
    ];

    public function filedetails()
    {
        return $this->hasMany(FileDetail::class);
    }
    public function currDepartment()
    {
        return $this->belongsTo(Department::class,'curr_department_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }

    public function copy_of_file()
    {
        return $this->belongsTo(File::class,'copy_of');
    }








}
