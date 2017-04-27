@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Parcelas
                  <a class="btn btn-danger" href="{{url('parcelas/pdf')}}">PDF</a>
                  <a class="pull-right" href="{{url('parcelas/novo')}}">Novo Parcela</a>
                </div>

                <table class="table">
                    <thead>
                      <th>Movimentação</th>
                      <th>Status</th>
                      <th>Número da Parcela</th>
                      <th>Data de Vencimento</th>
                      <th>Data de Pagamento</th>
                      <th>Valor da Parcela</th>
                      <th>Valor Pago</th>
                      <th>Opções</th>
                      <th></th>
                    </thead>
                    <tbody>
                      @foreach($parcelas as $parcela)
                      <tr>
                        <td>{{$parcela->movimento_id}}: {{ $parcela->Movimento->descricao }}</td>
                        <td>{{$parcela->status}}</td>
                        <td>{{$parcela->numero_parcela}}</td>
                        <td>{{$parcela->data_vencimento}}</td>
                        <td>{{$parcela->data_pagamento}}</td>
                        <td>{{$parcela->valor_parcela}}</td>
                        <td>{{$parcela->valor_pago}}</td>
                        <td><button class="btn btn-success" data-toggle="modal" data-target="#myModal">Pagar</button></td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>

            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog">
   <div class="modal-dialog">
     {!! Form::open(['route' => 'parcelas.salvar', 'method' => 'POST']) !!}
       <!-- Modal content-->
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title">Dados do Pagamento</h4>
         </div>

           <div class="modal-body">
             <div class="container-fluid">
               <div class="col-md-6">
                 {!! Form::label('data_vencimento', 'Data de Vencimento') !!}
                 {!! Form::input('date', 'data_vencimento', null, ['class' => 'form-control'])!!}

                 {!! Form::label('valor_parcela', 'Valor da Parcela') !!}
                 {!! Form::input('number', 'valor_parcela', null, ['class' => 'form-control'])!!}

               </div>
               <div class="col-md-6">
                 {!! Form::label('data_pagamento', 'Data de Pagamento') !!}
                 {!! Form::input('date', 'data_pagamento', null, ['class' => 'form-control'])!!}

                 {!! Form::label('valor_pago', 'Valor Pago') !!}
                 {!! Form::input('number', 'valor_pago', null, ['class' => 'form-control'])!!}

               </div>
             </div>
           </div>
           <div class="modal-footer">
             {!! Form::submit('Pagar', ['class' => 'btn btn-success', 'data-dismiss' => 'modal'])!!}
           </div>

       </div>
     {!! Form::close() !!}
   </div>
 </div>
