<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;

use CodeProject\Entities\User;

class MemberTransformer extends TransformerAbstract
{

	public function transform(User $member)
	{
		return [
			'user_id' => $member->id,
			'name' => $member->name,
		];
	}

}