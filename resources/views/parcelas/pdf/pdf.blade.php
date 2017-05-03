<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Parcelas</title>
    <link rel="stylesheet" href="css/app.css">
    <style>
    @page {
        margin: 150px 25px 100px 25px;
    }
    header,
    footer {
        width: 100%;
        text-align: center;
        position: fixed;
        left: 0px;
        right: 0px;
        height: 60px;
    }
    header {
        top: -130px;
    }
    footer {
        bottom: -80px;
    }
    .pagenum:before {
        content: counter(page);
    }
    img{
      height: 50px;
      width: 50px;
      padding: 5px;
      float: left;
    }
    th,td{
        text-align: center;
        padding: 3px;
    }
    th{
        background-color: #ffad99;
    }
    td.1{
        text-align: left;
    }
    th.1,td.1{
        width: 28%;
    }
    th.2,td.2{
        width: 7%;
    }
    th.3,td.3{
        width: 15%;
    }
    th.4,td.4{
        width: 15%;
    }
    th.5,td.5{
        width: 15%;
    }
    th.6,td.6{
        width: 10%;
    }
    th.7,td.7{
        width: 10%;
    }
    </style>
  </head>
  <body>
      <header>
          <img src="assets/images/logo.png" alt="">
          <h1>Página de Relatório - Page <span class="pagenum"></span></h1>
          <table class="table">
              <tr>
                  <th class="1">Movimentação</th>
                  <th class="2">Status</th>
                  <th class="3">Número da Parcela</th>
                  <th class="4">Data de Vencimento</th>
                  <th class="5">Data de Pagamento</th>
                  <th class="6">Valor da Parcela</th>
                  <th class="7">Valor Pago</th>
              </tr>
          </table>
      </header>
      <footer>
          <h3>Página de Relatório - Page <span class="pagenum"></span></h3>
      </footer>

      <table class="table">
          @foreach($parcelas as $parcela)
            <tr>
              <td class="1">{{$parcela->movimento_id}}: {{ $parcela->Movimento->descricao }}</td>
              <td class="2">{{$parcela->status}}</td>
              <td class="3">{{$parcela->numero_parcela}}</td>
              <td class="4">{{$parcela->data_vencimento}}</td>
              <td class="5">{{$parcela->data_pagamento}}</td>
              <td class="6">{{$parcela->valor_parcela}}</td>
              <td class="7">{{$parcela->valor_pago}}</td>
            </tr>
          @endforeach
      </table>
  </body>
