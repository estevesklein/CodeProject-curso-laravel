<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

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

	public function __construct(ProjectRepository $repository, ProjectValidator $validator, ProjectMemberRepository $repositoryMember)
	{
        $this->repository = $repository;
		$this->validator = $validator;

        $this->repositoryMember = $repositoryMember;
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
}