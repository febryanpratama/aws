<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileOrderDocument extends Model
{
    use HasFactory;
    
    public function fileorder(){
        return $this->belongsTo('App\Models\FileOrder');
    }
}
