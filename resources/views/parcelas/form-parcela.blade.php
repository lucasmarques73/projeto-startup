@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Dados da Parcela
                  <a class="pull-right" href="{{url('parcelas')}}">Lista de Parcelas</a>
                </div>
                <div class="panel-body">
                  @if(Session::has('message'))
                    <div class='alert '>{{Session::get('message')}}</div>
                  @endif

                  {!! Form::open(['route' => 'parcelas.salvar', 'method' => 'POST']) !!}

                  {!! Form::label('tbl_movimentacao_id', 'Movimentação') !!}
                  {!! Form::select('tbl_movimentacao_id', $movimentos, null, ['class' => 'form-control']) !!}

                  {!! Form::label('status', 'Status') !!}
                  {!! Form::input('text', 'status', null, ['class' => 'form-control', 'placeholder' => 'Status'])!!}

                  {!! Form::label('numero_parcela', 'Número da Parcela') !!}
                  {!! Form::input('number', 'numero_parcela', null, ['class' => 'form-control', 'placeholder' => 'Número da Parcela'])!!}

                  {!! Form::label('data_vencimento', 'Data de Vencimento') !!}
                  {!! Form::input('date', 'data_vencimento', null, ['class' => 'form-control'])!!}

                  {!! Form::label('data_pagamento', 'Data de Pagamento') !!}
                  {!! Form::input('date', 'data_pagamento', null, ['class' => 'form-control'])!!}

                  {!! Form::label('valor_parcela', 'Valor da Parcela') !!}
                  {!! Form::input('number', 'valor_parcela', null, ['class' => 'form-control'])!!}

                  {!! Form::label('valor_pago', 'Valor Pago') !!}
                  {!! Form::input('number', 'valor_pago', null, ['class' => 'form-control'])!!}

                  {!! Form::submit('Salvar', ['class' => 'btn btn-primary'])!!}

                  {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
