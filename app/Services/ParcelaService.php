<?php

namespace App\Services;

use App\Repositories\ParcelaRepository;
use App\Validators\ParcelaValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

use App\Repositories\MovimentoRepository;

class ParcelaService
{
    /**
     * @var ParcelaRepository
     */
    protected $repository;

    /**
     * @var ParcelaValidator
     */
    protected $validator;

    protected $MovimentoRepository;

    public function __construct(ParcelaRepository $repository,MovimentoRepository $MovimentoRepository, ParcelaValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->MovimentoRepository  = $MovimentoRepository;
    }

    public function store(array $data, $id)
    {
        try {

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $parcela = $this->repository->create($data);

            $response = [
                'message' => 'Parcela created.',
                'data'    => $parcela->toArray(),
            ];

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function update(array $data, $id)
    {
        try {

            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $parcela = $this->repository->update($data, $id);

            $response = [
                'message' => 'Parcela updated.',
                'data'    => $parcela->toArray(),
            ];
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }
}
