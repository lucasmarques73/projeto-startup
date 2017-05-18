<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Entities\Item;
use DB;
use Excel;

class MaatwebsiteDemoController extends Controller
{
	public static function limpaCPF_CNPJ($valor){
	 $valor = trim($valor);
	 $valor = str_replace(".", "", $valor);
	 $valor = str_replace(",", "", $valor);
	 $valor = str_replace("-", "", $valor);
	 $valor = str_replace("/", "", $valor);
	 return $valor;
	}

	public static function genero($sexo){
		$sexo = str_replace("M", "1", $sexo);
		$sexo = str_replace("F", "2", $sexo);
		return $sexo;
	}


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

					$value->cpfcnpj = MaatwebsiteDemoController::limpaCPF_CNPJ($value->cpfcnpj);
					$value->data_nascimento = str_replace("00/00/0000", null, $value->data_nascimento);
					$value->data_nascimento = date('Y-m-d', strtotime($value->data_nascimento));
					$value->sexo = MaatwebsiteDemoController::genero($value->sexo);

					if (strlen($value->cpfcnpj) <= 11){
						$pessoaFisica[] = [
							'nome' => $value->nome ,					
							'apelido' => $value->contato ,
							'cpf' => (string) $value->cpfcnpj ,
							'cnh' => (string) $value->cnh ,
							'rg' => (string) $value->rg ,
							'nascimento' =>  $value->data_nascimento ,
							'cnh_categoria' => $value->categoria_cnh ,
							'genero' => (integer) $value->sexo ,
							'Matricula' => (string) $value->matricula ,
							'Id_Externo' => (string) $value->id_extero ,
							'Situacao' => (string) $value->situacao
						];
					}
					else{
						$pessoaJuridica[] = [
							'cnpj' => $value->cpfcnpj ,
							'razao_social' => $value->nome ,
							'nome_fantasia' => $value->nome ,
							'Matricula' => (string) $value->matricula ,
							'Id_Externo' => (string) $value->id_extero ,
							'Situacao' => (string) $value->situacao
						];
					}
					
				}
				
				if(!empty($pessoaFisica)){
					
					foreach (array_chunk($pessoaFisica,1000) as $pf) {
						DB::table('pessoa_fisicas')->insert($pf);
					}
				}
				if(!empty($pessoaJuridica)){
					
					foreach (array_chunk($pessoaJuridica,1000) as $pj) {
						DB::table('pessoa_juridicas')->insert($pj);
					}
				}

				dd('Dados inseridos nas tabelas pessoa_fisicas e pessoa_juridicas');
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

					$value->receber_e_mail = str_replace("SIM","1" , $value->receber_e_mail);

					$insert[] = [
					'end_cep' => (string) $value->cep ,
					'end_logradouro' => (string) $value->logradouro ,
					'end_complemento' => (string) $value->complemento ,
					'end_bairro' => (string) $value->bairro ,
					'end_cidade' => (string) $value->cidade ,
					'end_uf' => (string) $value->uf ,
					'end_numero' => (string) $value->numero ,

					'tel_preferencial' => (string) $value->telefone ,
					'tel_alternativo' => (string) $value->telefone_celular ,					
					
					'email' => (string) $value->email ,
					'email_alternativo' => (string) $value->email_auxiliar ,
					
					
					//'regional' => (string) $value->regional ,					
					//'profissao' => (string) $value->profissao ,
					
					'pref_email' => (integer) $value->receber_e_mail,
					'pref_sms' => 0,
					'pref_boleto' => 0,

					'Matricula' => (string) $value->matricula ,
					'Id_Externo' => (string) $value->id_extero
					];
				}		
				
				
				if(!empty($insert)){
					foreach (array_chunk($insert,1000) as $i) {

						foreach ($i as $val) {
							$x = DB::table('pessoas')->where('Matricula', array_get($val,'Matricula'))->value('Matricula');
							if ($x == null) {
								if (array_get($val, 'Matricula') != "") {
									DB::table('pessoas')->insert($val);
			 					}
							}
								
						}
						
					}
					
					dd('<h1>Dados inseridos tabela pessoas</h1>');

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
