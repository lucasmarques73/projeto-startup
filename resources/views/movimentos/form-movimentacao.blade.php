@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Dados da Movimentação
                  <a class="pull-right" href="{{url('movimentacoes')}}">Lista de Movimentações</a>
                </div>

                <div class="panel-body">
                  @if(Session::has('message'))
                    <div class='alert '>{{Session::get('message')}}</div>
                  @endif

                  {!! Form::open(['route' => 'movimentacao.salvar', 'method' => 'POST']) !!}

                  {!! Form::label('tipo', 'Tipo') !!}
                  {!! Form::input('text', 'tipo', null, ['class' => 'form-control','autofocus', 'placeholder' => 'Tipo'])!!}

                  {!! Form::label('categoria', 'Categoria') !!}
                  {!! Form::input('text', 'categoria', null, ['class' => 'form-control', 'placeholder' => 'Categoria'])!!}

                  {!! Form::label('descricao', 'Descrição') !!}
                  {!! Form::input('text', 'descricao', null, ['class' => 'form-control', 'placeholder' => 'Descrição'])!!}

                  {!! Form::label('data_emissao', 'Data de Emissão') !!}
                  {!! Form::input('date', 'data_emissao', null, ['class' => 'form-control'])!!}

                  {!! Form::submit('Salvar', ['class' => 'btn btn-primary'])!!}

                  {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
