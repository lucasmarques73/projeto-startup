<table>
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
