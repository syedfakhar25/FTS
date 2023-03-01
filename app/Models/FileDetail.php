<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDetail extends Model
{
    use HasFactory;
    protected $fillable = ['file_id','type','by_department_id','ref_department_id','no_of_attachments','attachments','ref_file_detail'];

    public function file()
    {
        return $this->belongsTo(File::class,'file_id');
    }
    public function by_department()
    {
        return $this->belongsTo(Department::class,'by_department_id');
    }
    public function ref_department()
    {
        return $this->belongsTo(Department::class,'ref_department_id');
    }
}
