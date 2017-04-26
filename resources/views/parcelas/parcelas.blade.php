@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Parcelas
                  <a class="pull-right" href="{{url('parcelas/novo')}}">Novo Parcela</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
