<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MovimentoRepository;
use App\Entities\Movimento;
use App\Validators\MovimentoValidator;

/**
 * Class MovimentoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class MovimentoRepositoryEloquent extends BaseRepository implements MovimentoRepository
{

  public function lists($column = 'title', $key = 'id', $limit = null)
  {
      return $this->model->pluck($column, $key)->all();
  }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Movimento::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MovimentoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
