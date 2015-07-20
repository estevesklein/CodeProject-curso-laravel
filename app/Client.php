<?php

namespace CodeProject;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $filleble = [
    	'name',
    	'responsible',
    	'email',
    	'phone',
    	'address',
    	'obs',

    ];

}
