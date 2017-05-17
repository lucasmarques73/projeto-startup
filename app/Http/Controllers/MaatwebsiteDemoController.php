<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Entities\Item;
use DB;
use Excel;

class MaatwebsiteDemoController extends Controller
{
    public function importExport()
	{
		return view('importExport');
	}

	public function importAss()
	{

		if(Input::hasFile('import_file_ass')){
			$path = Input::file('import_file_ass')->getRealPath();
			$data = Excel::load($path, function($reader) {})->get();

			
			if(!empty($data) && $data->count()){
				
				foreach ($data as $key => $value) {
					$insert[] = [
					'Nome' => (string) $value->nome ,
					'Matricula' => (string) $value->matricula ,
					'Contato' => (string) $value->contato ,
					'Id_Externo' => (string) $value->id_extero ,
					'CPF_CNPJ' => (string) $value->cpfcnpj ,
					'Classificacao' => (string) $value->classificacao ,
					'CNH' => (string) $value->cnh ,
					'RG' => (string) $value->rg ,
					'Data_Nascimento' => (string) $value->data_nascimento ,
					'Situacao' => (string) $value->situacao ,
					'Data_Cadastro' => (string) $value->data_cadastro ,
					'Data_Exclusao' => (string) $value->data_exclusao ,
					'Data_Contrato' => (string) $value->data_contrato ,
					'Categoria_CNH' => (string) $value->categoria_cnh ,
					'Data_Vencimento' => (string) $value->data_vencimento_cnh ,
					'Sexo' => (string) $value->sexo ,
					'Hora_de_Cadastro' => (string) $value->hora_de_cadastro ,
					'Hora_Exclusao' => (string) $value->hora_exclusao ,
					'Data_Final_Contrato' => (string) $value->data_final_contrato
					];
				}
				
				if(!empty($insert)){
					
					foreach (array_chunk($insert,1000) as $i) {
						DB::table('aux_associados')->insert($i);
					}
					
					dd('<h1>Insert Record successfully.</h1>');

				}
				else{
					dd('Erro1');
				}
			}
			else{
				dd('Erro2');
			}
		}
		else{
			dd('Erro3');
		}
		return back();
	}

	public function importAssEnd()
	{

		if(Input::hasFile('import_file_ass_end')){

			$path = Input::file('import_file_ass_end')->getRealPath();
			$data = Excel::load($path, function($reader) {})->get();

			if(!empty($data) && $data->count()){

				foreach ($data as $key => $value) {
					$insert[] = [
					'matricula' => (string) $value->matricula ,
					'id_externo' => (string) $value->id_externo ,
					'placas_ativas' => (string) $value->placas_ativas ,
					'logradouro' => (string) $value->logradouro ,
					'bairro' => (string) $value->bairro ,
					'cidade' => (string) $value->cidade ,
					'email' => (string) $value->email ,
					'regional' => (string) $value->regional ,
					'naturalidade' => (string) $value->naturalidade ,
					'telefone' => (string) $value->telefone ,
					'telefone_celular' => (string) $value->telefone_celular ,
					'id_radio' => (string) $value->id_radio ,
					'numero_radio' => (string) $value->numero_radio ,
					'data_alteracao_situacao' => (string) $value->data_alteracao_situacao ,
					'cep' => (string) $value->cep ,
					'numero' => (string) $value->numero ,
					'complemento' => (string) $value->complemento ,
					'email_auxiliar' => (string) $value->email_auxiliar ,
					'uf' => (string) $value->uf ,
					'usuario' => (string) $value->usuario ,
					'telefone_comercial' => (string) $value->telefone_comercial ,
					'telefone_celular_auxiliar' => (string) $value->telefone_celular_auxiliar ,
					'id_radio_aux' => (string) $value->id_radio_aux ,
					'telefone_fax' => (string) $value->telefone_fax ,
					'tipo_boleto_veiculo' => (string) $value->tipo_boleto_veiculo ,
					'mes_aniversario' => (string) $value->mes_aniversario ,
					'observacoes' => (string) $value->observacoes ,
					'tipo_pessoa' => (string) $value->tipo_pessoa ,
					'numero_radio_aux' => (string) $value->numero_radio_aux ,
					'operadora' => (string) $value->operadora ,
					//'0' => (string) $value-> ,
					'profissao' => (string) $value->profissao ,
					'nome_do_pai' => (string) $value->nome_do_pai ,
					'quantidade_veiculos' => (string) $value->quantidade_veiculos ,
					'valor_produto_adicional' => (string) $value->valor_produto_adicional ,
					'receber_e_mail' => (string) $value->receber_e_mail ,
					'categoria' => (string) $value->categoria ,
					'descricao_produto_adicional' => (string) $value->descricao_produto_adicional
					];
				}
				
				
				if(!empty($insert)){
					foreach (array_chunk($insert,1000) as $i) {
						
						foreach ($i as $val) {
							if (array_get($val, 'matricula') != "") {								
								DB::table('aux_associados_end')->insert($val);
					 		}	
						}
						
					}
					
					dd('<h1>Insert Record successfully.</h1>');

				}
				else{
					dd('Erro1');
				}
			}
			else{
				dd('Erro2');
			}
		}
		else{
			dd('Erro3');
		}
		return back();
	}

	public function importVec()
	{

		if(Input::hasFile('import_file_vec')){

			$path = Input::file('import_file_vec')->getRealPath();
			$data = Excel::load($path, function($reader) {})->get();
			
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {
					$insert[] = [
					'nome' => (string) $value->nome,
					'placa' => (string) $value->placa,
					'id_externo' => (string) $value->id_externo,
					'id_externo_associado' => (string) $value->id_externo_associado,
					'cod_veiculo' => (string) $value->cod_veiculo,
					'matricula_associado' => (string) $value->matricula_associado,
					'mes_final_carne' => (string) $value->mes_final_carne,
					'proprietario' => (string) $value->proprietario,
					'classificacao_associado' => (string) $value->classificacao_associado,
					'estado_civil_associado' => (string) $value->estado_civil_associado,
					'nome_mae' => (string) $value->nome_mae,
					'veiculo_vinculado' => (string) $value->veiculo_vinculado,
					'modelo' => (string) $value->modelo,
					'tipo_veiculo' => (string) $value->tipo_veiculo,
					'cpf_cnpj' => (string) $value->cpfcnpj,
					'cpf_cnpj_proprietario' => (string) $value->cpfcnpj_proprietario,
					'naturalidade' => (string) $value->naturalidade,
					'nome_pai' => (string) $value->nome_pai,
					'veiculo_agreagado' => (string) $value->veiculoagreagado,
					'cavalo_veiculo' => (string) $value->cavalo_veiculo,
					'montadora' => (string) $value->montadora,
					'categoria' => (string) $value->categoria,
					'cota' => (string) $value->cota,
					'ano_mod' => (string) $value->ano_mod,
					'cor' => (string) $value->cor,
					'chassi' => (string) $value->chassi,
					'valor_protegido' => (string) $value->valor_protegido,
					'porcentagem_fipe_protegido' => (string) $value->porcentagem_fipe_protegido,
					'forma_pagamento_protecao' => (string) $value->forma_pagamento_protecao,
					'km' => (string) $value->km,
					'n_portas' => (string) $value->n0_de_portas,
					'alienacao' => (string) $value->alienacao,
					'n_passageiros' => (string) $value->n0_de_passageiros,
					'cilindrada' => (string) $value->cilindrada,
					'tipo_pagamento_protecao' => (string) $value->tipo_pagamento_da_protecao,
					'valor_fipe_veiculo' => (string) $value->valor_fipe_veiculo,
					'codigo_fipe' => (string) $value->codigo_fipe,
					'numero_motor' => (string) $value->numero_motor,
					'renavam' => (string) $value->renavam,
					'combustivel' => (string) $value->combustivel,
					'ano' => (string) $value->ano
					];
				}
				
				if(!empty($insert)){
					
					foreach (array_chunk($insert,1000) as $i) {
						DB::table('aux_veiculos')->insert($i);
					}
					dd('<h1>Insert Record successfully.</h1>');

				}
				else{
					dd('Erro1');
				}
			}
			else{
				dd('Erro2');
			}
		}
		else{
			dd('Erro3');
		}
		return back();
	}
}
