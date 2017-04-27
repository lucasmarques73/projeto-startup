<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MovimentoCreateRequest;
use App\Http\Requests\MovimentoUpdateRequest;
use App\Repositories\MovimentoRepository;
use App\Validators\MovimentoValidator;

use App\Repositories\ParcelaRepository;


class MovimentosController extends Controller
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $movimentos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $movimentos,
            ]);
        }

        return view('movimentos.index', compact('movimentos'));
    }

    public function create()
    {
      $movimentos = $this->repository->all();

      return view('movimentos.form-movimento', ['movimentos' => $movimentos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MovimentoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(MovimentoCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $movimento = $this->repository->create($request->all());
            $valor_parcela = $request->get('valor_total') / $request->get('numero_parcela');

            /**
            *   $data = date('Y-m-d', strtotime("+1 month", strtotime($data)));
            *
            *   Adionando 1 mês para data;
            **/
            $data_emissao = $request->get('data_emissao');

            for ($i = 1; $i <= $request->get('numero_parcela'); $i++) {

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
        $movimento = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $movimento,
            ]);
        }

        return view('movimentos.show', compact('movimento'));
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

        $movimento = $this->repository->find($id);

        return view('movimentos.edit', compact('movimento'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  MovimentoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(MovimentoUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $movimento = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Movimento updated.',
                'data'    => $movimento->toArray(),
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
                'message' => 'Movimento deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Movimento deleted.');
    }
}
