<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;

use CodeProject\Services\ProjectService;

class ProjectTaskController extends Controller
{

    /**
     * @var ProjectTaskRepository
     */
    private $repository;

    /**
     * @var ProjectTaskService
     */
    private $service;

    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskService $service
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service, ProjectService $projectService)
    {

        $this->repository = $repository;
        $this->service = $service;
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($projectId)
    {

        if($this->checkProjectTaskPermissions($projectId) == false){
            return ['error' => 'Access Forbidden'];
        }

        return $this->repository->findWhere(['project_id' => $projectId]);
        //return $this->repository->all();
        //return $this->repository->with(['client', 'user'])->all();
        //return $this->repository->findWhere(['project_id' => $id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //dd($request->all());
        return $this->service->create($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //return $this->repository->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($projectId, $id)
    {

        if($this->checkProjectTaskPermissions($projectId) == false){
            return ['error' => 'Access Forbidden'];
        }

        return $this->repository->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $projectTask = $this->repository->skipPresenter()->find($id);

        $projectId = $projectTask->project_id;

        if($this->checkProjectTaskPermissions($projectId) == false){
            return ['error' => 'Access Forbidden'];
        }
        
        return $this->service->update($request->all(),$id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //return $this->repository->delete($taskId);

        $projectTask = $this->repository->skipPresenter()->find($id);
        //$result = $this->repository->delete($id);

        $projectId = $projectTask->project_id;

        if($this->checkProjectTaskPermissions($projectId) == false){
            return ['error' => 'Access Forbidden'];
        }

        $result = $projectTask->delete();

        if($result)
            return ['error' => 0];

        return  ['error' => 1, 'msg' => 'Erro ao tentar deletar a Task'];
        

    }



    private function checkProjectTaskPermissions($projectId){
        
        if($this->projectService->checkProjectOwner($projectId) or $this->projectService->checkProjectMember($projectId)){
            return true;
        }
        return false;

    }
}
