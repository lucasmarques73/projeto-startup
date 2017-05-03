<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ParcelaCreateRequest;
use App\Http\Requests\ParcelaUpdateRequest;
use App\Repositories\ParcelaRepository;

use App\Repositories\MovimentoRepository;
use App\Services\ParcelaService;


class ParcelasController extends Controller
{

    /**
     * @var ParcelaRepository
     */
    protected $repository;

    /**
     * @var MovimentoRepository
     */
    protected $MovimentoRepository;

    /**
     * @var ParcelaService
     */
     protected $service;

    public function __construct(ParcelaRepository $repository, MovimentoRepository $MovimentoRepository, ParcelaService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->MovimentoRepository = $MovimentoRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $parcelas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $parcelas,
            ]);
        }

        return view('parcelas.index', ['parcelas' => $parcelas]);
    }

    public function create()
    {
      $movimentos = $this->MovimentoRepository->lists('descricao', 'id');

      return view('parcelas.form-parcela', ['movimentos' => $movimentos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ParcelaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ParcelaCreateRequest $request)
    {
        return $this->service->store($request->all());
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($movimento_id)
    {
        $parcelas = $this->repository->findWhere(['movimento_id' => $movimento_id]);

        return view('parcelas.index', ['parcelas' => $parcelas]);
    }
    public function showStatus($movimento_id, $status)
    {
        $parcelas = $this->repository->findWhere(['movimento_id' => $movimento_id, 'status' => $status]);

        return view('parcelas.index', ['parcelas' => $parcelas]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $movimentos = $this->MovimentoRepository->lists('descricao', 'id');
      $parcela = $this->repository->find($id);

      return view('parcelas.form-parcela', ['movimentos' => $movimentos, 'parcela' => $parcela]);
    }


    public function registrarPagamento(Request $request, $id)
    {
        $parcela = $this->repository->find($id);

        $data = [
          'data_pagamento'  => date('Y-m-d'),
          'valor_pago'      => $parcela->valor_parcela,
          'status'          => 'pago',
        ];

        $parcela = $this->repository->update($data, $id);

        $response = [
            'message' => 'Parcela paga.',
            'data'    => $parcela->toArray(),
        ];

        return redirect()->back()->with('message', $response['message']);
    }


    public function update(ParcelaUpdateRequest $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Parcela deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Parcela deleted.');
    }
}
