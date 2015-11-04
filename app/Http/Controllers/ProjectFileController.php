<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;
use Illuminate\Http\Request;


class ProjectFileController extends Controller
{

    /**
     * @var ProjectFileRepository
     */
    private $repository;

    /**
     * @var ProjectFileService
     */
    private $service;

    /**
     * @param ProjectFileRepository $repository
     * @param ProjectFileService $service
     */
    public function __construct(ProjectFileRepository $repository, ProjectFileService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Listagem
     * @return Response
     */
    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        //dd($request->name);
        //dd($request);

        $file = $request->file('file');
        //dd($file);
        $extension = $file->getClientOriginalExtension();
        //$data['extension'] = $data['file']->getClientOriginalExtension();

        $data = [
            'file' => $request->file,
            'extension' => $extension,
            'name' => $request->name,
            'project_id' => $request->project_id,
            'description' => $request->description,
        ];

        //dd($data);

        return $this->service->create($data);
    }

    public function showFile($id, $idFile)
    {
        //if($this->service->checkProjectPermissions($id) == false){
        //    return ['error' => 'Access Forbidden'];
        //}

        $filePath = $this->service->getFilePath($idFile);

        $fileContent = file_get_contents($filePath);
        $file64 = base64_encode($fileContent);

        return [
            'file' => $file64,
            'size' => filesize($filePath),
            'name' => $this->service->getFileName($idFile)
        ];
        //return response()->download($this->service->getFilePath($id));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show($id, $idFile)
    {
        $result = $this->repository->findWhere(['project_id' => $id, 'id' => $idFile]);
        if(isset($result['data']) && count($result['data']) == 1){
            $result = [
                'data' => $result['data'][0]
            ];
        }
        return $result;
        /*
        if($this->service->checkProjectPermissions($id) == false){
            return ['error' => 'Access Forbidden'];
        }

        return $this->repository->find($id);
        */
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Reponse
     */
    public function update(Request $request, $id, $idFile)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->update($data, $idFile);
        /*
        if($this->service->checkProjectOwner($id) == false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->update($request->all(), $id);
        */

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, $idFile)
    {
        //$this->repository->delete($idFile);
        /*
        //if($this->service->checkProjectPermissions($id) == false){
        if($this->service->checkProjectOwner($id) == false){
            return ['error' => 'Access Forbidden'];
        }

        //return $this->service->delete($id);
        */
        $this->service->delete($idFile);
    }

}
