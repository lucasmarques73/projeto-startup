@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Movimentações
                  <a class="pull-right" href="{{route('movimentos.novo')}}">Novo Movimento</a>
                </div>

                <table class="table">
                    <thead>
                      <th>#</th>
                      <th>Tipo</th>
                      <th>Categoria</th>
                      <th>Descrição</th>
                      <th>Data de Emissão</th>
                      <th>Parcelas</th>
                      <th>Opções</th>
                      <th></th>
                    </thead>
                    <tbody>
                      @foreach($movimentos as $movimento)
                      <tr>
                          <td>{{$movimento->id}}</td>
                          <td>{{$movimento->tipo}}</td>
                          <td>{{$movimento->categoria}}</td>
                          <td>{{$movimento->descricao}}</td>
                          <td>{{$movimento->data_emissao}}</td>
                          <td>
                              @foreach ($movimento->Parcela as $parcela)
                                  {{$parcela->numero_parcela}}: {{$parcela->status}}
                              @endforeach
                          </td>
                          <td>
                              {!! Form::open(['route' => ['movimentos.parcela', $movimento->id], 'method' => 'get']) !!}
                              {!! Form::submit('Parcelas', ['class' => 'btn btn-info']) !!}
                              {!! Form::close() !!}
                          </td>
                          <td>
                              {!! Form::open(['route' => ['movimentos.reportParcela', $movimento->id], 'method' => 'get']) !!}
                              {!! Form::submit('PDF', ['class' => 'btn btn-danger']) !!}
                              {!! Form::close() !!}
                          </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                  <div class="pagination-bar text-center">
                      {{$movimentos->render()}}
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
