<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ParcelaCreateRequest;
use App\Http\Requests\ParcelaUpdateRequest;
use App\Repositories\ParcelaRepository;
use App\Validators\ParcelaValidator;

use App\Repositories\MovimentoRepository;


class ParcelasController extends Controller
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
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $parcela = $this->repository->create($request->all());

            $response = [
                'message' => 'Parcela created.',
                'data'    => $parcela->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parcela = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $parcela,
            ]);
        }

        return view('parcelas.show', compact('parcela'));
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

        $parcela = $this->repository->find($id);

        return view('parcelas.edit', compact('parcela'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ParcelaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(ParcelaUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $parcela = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Parcela updated.',
                'data'    => $parcela->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
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
