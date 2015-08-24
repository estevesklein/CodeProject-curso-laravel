<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Services\ProjectService;

class ProjectFileController extends Controller
{

    /**
     * @var ProjectFileRepository
     */
    private $repository;

    /**
     * @var ProjectService
     */
    private $service;

    /**
     * @param ProjectService $service
     */
    public function __construct(ProjectService $service)
    {

        $this->service = $service;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data = [
            'file' => $request->file,
            'extension' => $extension,
            'name' => $request->name,
            'project_id' => $request->project_id,
            'description' => $request->description,
        ];

        //dd($data);

        // ProjectService
        return $this->service->createFile($data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        if($this->service->checkProjectPermissions($id) == false){
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->deleteFile($id);
    }

}
