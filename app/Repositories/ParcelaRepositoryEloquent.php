<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ParcelaRepository;
use App\Entities\Parcela;
use App\Validators\ParcelaValidator;

/**
 * Class ParcelaRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ParcelaRepositoryEloquent extends BaseRepository implements ParcelaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Parcela::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ParcelaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
