<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;

use CodeProject\Entities\ProjectTask;

class ProjectTaskTransformer extends TransformerAbstract
{

	public function transform(ProjectTask $data)
	{
		return [
			'id' => $data->id,
			'project_id' => $data->project_id,
			'name' => $data->name,
			'start_date' => $data->start_date,
			'due_date' => $data->due_date,
			'status' => $data->status,
		];
	}
}