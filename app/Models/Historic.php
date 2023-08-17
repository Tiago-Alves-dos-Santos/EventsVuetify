<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Historic extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['registry'];
    /*****************************************MUTATORS*******************************************/
    public function setCreatedAtFormattedAttribute($value)
    {
        $this->attributes['created_at_formatted'] = $value;
    }
    public function getCreatedAtFormattedAttribute()
    {
        return  Carbon::parse($this->attributes['created_at_formatted'])->format('d/m/Y H:i:s');
    }
}
