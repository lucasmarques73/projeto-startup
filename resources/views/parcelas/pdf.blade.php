<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Parcelas</title>
    <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid black;
    }
    </style>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      Parcelas
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
                          </tr>
                        @endforeach
                        </tbody>
                      </table>

                </div>
            </div>
        </div>
    </div>
  </body>
</html>
