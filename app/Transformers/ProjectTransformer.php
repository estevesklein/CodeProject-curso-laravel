<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;

class ProjectTransformer extends TransformerAbstract
{

	// vai incluir os membros no final do resultado
	protected $defaultIncludes = ['members', 'client'];

	public function transform(Project $project)
	{
		return [
			'id' => $project->id,
			'name' => $project->name,
			'client_id' => $project->client_id,
			'owner_id' => $project->owner_id,
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


	public function includeClient(Project $project)
	{
		//dd($project->client);
		return $this->item($project->client, new ClientTransformer());
	}
}