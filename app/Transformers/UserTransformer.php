<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;

use CodeProject\Entities\User;

class UserTransformer extends TransformerAbstract
{

	public function transform(User $data)
	{
		return [
			'id' => $data->id,
			'name' => $data->name,
			'email' => $data->email,
			//'password' => $data->password,
			'remember_token' => $data->remember_token,
		];
	}

}