<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'logo_path','short_code','delay_threshhold','file_year','file_month','file_date','file_counter' ,'system_installed'
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function filedetails()
    {
        return $this->hasMany(FileDetail::class);
    }
}
