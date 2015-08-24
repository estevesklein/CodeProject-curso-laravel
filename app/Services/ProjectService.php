<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Validators\ProjectValidator;
use CodeProject\Validators\ProjectFileValidator;

use Prettus\Validator\Exceptions\ValidatorException;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectService
{
	/**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * @var ProjectMemberRepository
     */
    protected $repositoryMember;

    /**
     * @var ProjectValidator
     */
    protected $validator;

    private $filesystem;

    private $storage;

    /**
     * @var ProjectFileValidator
     */
    protected $validatorProjectFile;

	public function __construct(ProjectRepository $repository, ProjectValidator $validator, ProjectMemberRepository $repositoryMember, Filesystem $filesystem, Storage $storage, ProjectFileValidator $validatorProjectFile)
	{
        $this->repository = $repository;
		$this->validator = $validator;

        $this->repositoryMember = $repositoryMember;

        $this->filesystem = $filesystem;
        $this->storage = $storage;

        $this->validatorProjectFile = $validatorProjectFile;
	}

	public function create(array $data)
	{
		// diversos serviços
		// enviar email
		// disparar notificacao
		try {

            //dd($data);

            $this->validator->with($data)->passesOrFail();


            $result = $this->repository->create($data);

            //dd($result);

            // adiciona somente um membro ao projeto
            if(!empty($result->id) && !empty($data['user_id']))
                $this->addMember(['project_id' => $result->id, 'user_id' => $data['user_id']]);

            return $result;

        } catch(ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
	}

	public function update(array $data, $id)
	{
		try {
			
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);

        } catch(ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }

	}


    // 04.08.2015 - Para adicionar um novo member em um projeto
    public function addMember(array $data)
    {

        //dd($data);
        $result = $this->repositoryMember->create($data);

        //dd($result);
        return $result;
    }

    // 04.08.2015 - Para remover um membro de um projeto
    public function removeMember($project_id, $user_id)
    {



        $result = $this->repositoryMember
            ->findWhere(['project_id' => $project_id, 'user_id' => $user_id])
            ->delete();

        return $result;
    }

    // 04.08.2015 - Para verificar se um usuário é membro de um determinado projeto
    public function isMember($project_id, $user_id)
    {

        $result = $this->repositoryMember
            ->findWhere(['project_id' => $project_id, 'user_id' => $user_id]);


        if(count($result)>0)
            return true;

        return false;
    }



    public function createFile(array $data)
    {
        // name
        // description
        // extension
        // file

        try {
            //dd($data);
            
            $this->validatorProjectFile->with($data)->passesOrFail();

            // sem transformers
            $project = $this->repository->skipPresenter()->find($data['project_id']);
            $projectFile = $project->files()->create($data);

            //$this->storage->put($data['name'] . '.' . $data['extension'], $this->filesystem->get($data['file']));
            $r = $this->storage->put($projectFile->id . '.' . $data['extension'], $this->filesystem->get($data['file']));

            if($r)
                return ['error' => false];

        } catch(ValidatorException $e) {

            //dd($e->getMessageBag()->getMessages());

            return [
                'error' => true,
                'message' => $e->getMessageBag()
                //'message' => $e->getMessageBag()->getMessages(),
            ];
        }

    }


    public function deleteFile($projectId)
    {
        // recupera somente os Files
        $files = $this->repository->skipPresenter()->find($projectId)->files;

        //dd($files);

        $deletar = [];
        foreach ($files as $file) {
            $path = $file->id . '.' . $file->extension;

            // deletar da bd
            if($file->delete($file->id))
                $deletar[] = $path;
        }

        //dd($deletar);

        $r = $this->storage->delete($deletar);

        if($r)
            return ['error' => false];
        else
            return ['error' => true];

    }



    public function checkProjectOwner($projectId)
    {

        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId, $userId);
    }


    public function checkProjectMember($projectId)
    {
        
        $userId = \Authorizer::getResourceOwnerId();
        return $this->repository->hasMember($projectId, $userId);
    }

    public function checkProjectPermissions($projectId){
        
        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }
        return false;
    }
}