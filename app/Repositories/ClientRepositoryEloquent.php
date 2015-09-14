<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

use CodeProject\Presenters\ClientPresenter;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{
	protected $fieldSearchable = [
		'name'=>'like',
	];

	public function model()
	{
		return Client::class;
	}

	public function presenter()
    {
        return ClientPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app(RequestCriteria::class) );
        //$this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }
}