<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\MovimentoCreateRequest;
use App\Http\Requests\MovimentoUpdateRequest;
use App\Repositories\MovimentoRepository;

use App\Services\MovimentoService;


class MovimentosController extends Controller
{

    /**
     * @var MovimentoRepository
     */
    protected $repository;

    /**
     * @var MovimentoService
     */
     protected $service;


    public function __construct(MovimentoRepository $repository, MovimentoService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $movimentos = $this->repository->paginate(5);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $movimentos,
            ]);
        }

        return view('movimentos.index', compact('movimentos'));
    }

    public function create()
    {
      return view ('movimentos.form-movimento');
    }

    public function store(MovimentoCreateRequest $request)
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
        return $this->service->update($data, $id);
    }


    /**
     * Remove the specified resource from storage.
     *update($data, $id)
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
