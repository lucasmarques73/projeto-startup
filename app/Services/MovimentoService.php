<?php

namespace App\Services;

use App\Repositories\MovimentoRepository;
use App\Validators\MovimentoValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

use App\Repositories\ParcelaRepository;

class MovimentoService
{
    /**
     * @var MovimentoRepository
     */
    protected $repository;

    /**
     * @var MovimentoValidator
     */
    protected $validator;

    protected $Parcelarepository;

    public function __construct(MovimentoRepository $repository,ParcelaRepository $Parcelarepository, MovimentoValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->Parcelarepository  = $Parcelarepository;
    }

    public function store(array $data)
    {
        try {

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $movimento = $this->repository->create($data);
            $valor_parcela = array_get($data, 'valor_total') / array_get($data, 'numero_parcela');
            $data_emissao = array_get($data, 'data_emissao');

            for ($i = 1; $i <= array_get($data, 'numero_parcela'); $i++) {

                $data_vencimento = date('Y-m-d', strtotime("+" . $i . " month", strtotime($data_emissao)));

                $parcela = $this->Parcelarepository->create([
                  'movimento_id' => $movimento['id'],
                  'numero_parcela'      => $i              ,
                  'valor_parcela'       => $valor_parcela  ,
                  'status'              => 'à pagar'       ,
                  'data_vencimento'     => $data_vencimento
                ]);
            }

            $response = [
                'message' => 'Movimento created.',
                'data'    => $movimento->toArray(),
            ];

            return $response;
        } catch (ValidatorException $e) {

            return redirect()->back()->with(['message' => $e->getMessageBag()])->withInput();
        }
    }

    public function update(array $data, $id)
    {

        try {

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $movimento = $this->repository->update($data, $id);

            $response = [
                'message' => 'Movimento updated.',
                'data'    => $movimento->toArray(),
            ];

            return $response;
        } catch (ValidatorException $e) {

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }
}
