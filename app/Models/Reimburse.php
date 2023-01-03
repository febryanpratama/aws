<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reimburse extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function submitted()
    {
        return $this->belongsTo(User::class, 'submitted_id');
    }

    public function detailReimburse()
    {
        return $this->hasMany(DetailReimburse::class, 'reimburse_id', 'id');
    }
}
