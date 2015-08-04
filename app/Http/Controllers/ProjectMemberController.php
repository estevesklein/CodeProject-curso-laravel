<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ProjectMemberRepository;

class ProjectMemberController extends Controller
{

    /**
     * @var ProjectMemberRepository
     */
    private $repository;

    /**
     * @param ProjectMemberRepository $repository
     * @param ProjectMemberService $service
     */
    public function __construct(ProjectMemberRepository $repository)
    {
        $this->repository = $repository;
    }


    public function members($id)
    {
        //return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
        //return $this->repository->find($id);
        //return $this->repository->with(['members'])->find($id);

        return $this->repository->with(['user'])->findWhere(['project_id' => $id]);
    }
}
