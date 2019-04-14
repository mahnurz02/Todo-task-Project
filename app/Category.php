<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
	protected $dates = ['deleted_at'];
    protected $table = 'category';

    protected $fillable = [
        'name',
    ];

    public function category()
    {
        return $this->belongsToMany( 'App\task','task_category', 'category_id','task_id');
    }
}
