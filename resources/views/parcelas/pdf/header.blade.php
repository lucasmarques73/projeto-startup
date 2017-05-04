<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Parcelas</title>
    <style>
    .header,
    .footer {
        width: 100%;
        text-align: center;
        position: fixed;
    }
    .header {
        top: 0px;
    }
    .footer {
        bottom: 0px;
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
    h1,h3{
        font-family: sans-serif;
        text-align: center;
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
      <div class="header">
          Page <span class="pagenum"></span>
          <img src="assets/images/logo.png" alt="">
          <h1>Página de Relatório</h1>
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
          </table>
  </body>