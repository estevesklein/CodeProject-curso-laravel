<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;

use CodeProject\Entities\ProjectNote;

class ProjectNoteTransformer extends TransformerAbstract
{

	public function transform(ProjectNote $data)
	{
		return [
			'id' => $data->id,
			'project_id' => $data->project_id,
			'title' => $data->title,
			'note' => $data->note,
		];
	}
}