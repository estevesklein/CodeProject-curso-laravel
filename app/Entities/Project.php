<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    protected $fillable = [
    	'owner_id',
    	'client_id',
    	'name',
    	'description',
    	'progress',
    	'status',
    	'due_date',
    ];


    public function client()
    {
        return $this->belongsTo('CodeProject\Entities\Client');
    }

    public function user()
    {
        return $this->belongsTo('CodeProject\Entities\User', 'owner_id');
    }

}
