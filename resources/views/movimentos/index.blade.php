@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Movimentações
                  <a class="pull-right" href="{{url('movimentacoes/novo')}}">Nova Movimentação</a>
                </div>

                <table class="table">
                    <thead>
                      <th>Tipo</th>
                      <th>Categoria</th>
                      <th>Descrição</th>
                      <th>Data de Emissão</th>
                      <th>Parcelas</th>
                    </thead>
                    <tbody>
                      @foreach($movimentos as $movimentacao)
                      <tr>
                        <td>{{$movimentacao->tipo}}</td>
                        <td>{{$movimentacao->categoria}}</td>
                        <td>{{$movimentacao->descricao}}</td>
                        <td>{{$movimentacao->data_emissao}}</td>
                        <td>
                        @foreach ($movimentacao->Parcela as $parcela)
                          {{$parcela->numero_parcela}}: {{$parcela->status}}
                        @endforeach
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>

            </div>
        </div>
    </div>
</div>
@endsection
