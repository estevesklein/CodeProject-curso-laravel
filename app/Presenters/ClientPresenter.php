<?php
namespace CodeProject\Presenters;

use Prettus\Repository\Presenter\FractalPresenter;
use CodeProject\Transformers\ClientTransformer;

class ClientPresenter extends FractalPresenter
{

	public function getTransformer()
	{
		return new ClientTransformer();
	}
}