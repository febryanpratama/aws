<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileOrder extends Model
{
    use HasFactory;
    
    public function fileorderreceivers(){
        return $this->hasMany('App\FileOrderReceiver');
    }
    public function fileorderdocuments(){
        return $this->hasMany('App\FileOrderDocument', 'fileorder_id', 'id');
    }
}
