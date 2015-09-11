<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

	// vai incluir os membros no final do resultado
	protected $defaultIncludes = ['members'];

	public function transform(Project $project)
	{
		return [
			'project_id' => $project->id,
			'project' => $project->name,
			//'members' => $project->members,
			'description' => $project->description,
			'progress' => $project->progress,
			'status' => $project->status,
			'due_date' => $project->due_date,
		];
	}

	public function includeMembers(Project $project)
	{
		//return $this->collection($project->members, new ProjectMemberTransformer());
		return $this->collection($project->members, new UserTransformer());
	}
}