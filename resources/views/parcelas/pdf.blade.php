<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Parcelas</title>
    <style>
    img{
      height: 50px;
      width: 50px;
      padding: 5px;
    }
    table{
      width: 100%;
      border-collapse: collapse;
      border: 1px solid black;
      padding: 5px;
      font-family: sans-serif;
      text-align: center;
    }
    th{
      border-bottom: 1px solid black;
      background-color: #ffad99;
      padding: 5px;
    }
    td{
      padding: 5px;
    }
    </style>
  </head>
  <body>
    <img src="assets/images/logo.png" alt="">
      <table>
          <tr>
            <th>Movimentação</th>
            <th>Status</th>
            <th>Número da Parcela</th>
            <th>Data de Vencimento</th>
            <th>Data de Pagamento</th>
            <th>Valor da Parcela</th>
            <th>Valor Pago</th>
          </tr>
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
        </table>
  </body>
</html>
