<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{
	protected $rules = [
		'file' => 'required', // required|max:3000
		'project_id' => 'required|integer',
		'name' => 'required|max:255',
		'extension' => 'required|max:255',
	];
}