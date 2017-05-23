<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Entities\Item;
use DB;
use Excel;

class MaatwebsiteDemoController extends Controller
{
	public static function limpaCPF_CNPJ_CEP($valor){
	 $valor = trim($valor);
	 $valor = str_replace(".", "", $valor);
	 $valor = str_replace(",", "", $valor);
	 $valor = str_replace("-", "", $valor);
	 $valor = str_replace("/", "", $valor);
	 $valor = str_replace(" ", "", $valor);
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
		/**
		*
		***********************   IMPORTAR REL(2)
		*
		**/

		if(Input::hasFile('import_file_ass')){
			$path = Input::file('import_file_ass')->getRealPath();
			$data = Excel::load($path, function($reader) {})->get();

			
			if(!empty($data) && $data->count()){
				
				foreach ($data as $key => $value) {
					
					if ($value->cpfcnpj == null) {
						dump($value);
					}
					else{

						$value->cpfcnpj = MaatwebsiteDemoController::limpaCPF_CNPJ_CEP($value->cpfcnpj);
						$value->data_nascimento = str_replace("00/00/0000", null, $value->data_nascimento);
						$value->data_nascimento = date('Y-m-d', strtotime($value->data_nascimento));
						$value->sexo = MaatwebsiteDemoController::genero($value->sexo);
						$value->cep = MaatwebsiteDemoController::limpaCPF_CNPJ_CEP($value->cep);

						$pessoa = [
							'end_cep' => (string) $value->cep ,
							'end_logradouro' => (string) $value->logradouro ,
							'end_numero' => (string) $value->numero ,
							'end_complemento' => (string) $value->complemento ,
							'end_bairro' => (string) $value->bairro ,
							'end_cidade' => (string) $value->cidade ,
							'end_uf' => (string) $value->uf ,
							'email_preferencial' => (string) $value->email ,
							'email_alternativo' => (string) $value->email_auxiliar,
							'pref_email' => 0,
							'pref_sms' => 0,
							'pref_boleto' => 0
						];

						$id = DB::table('pessoas')->insertGetId($pessoa);					

						if (strlen($value->cpfcnpj) <= 11){
							$pessoaFisica = [
								'id' => $id,
								'cpf' => (string) $value->cpfcnpj ,
								'cnh' => (string) $value->cnh ,
								'rg' => (string) $value->rg ,
								'nome' => (string) $value->nome ,					
								'apelido' => (string) $value->contato ,								
								'nascimento' =>  $value->data_nascimento ,
								'genero' => (integer) $value->sexo,
								'cnh_categoria' => (string) $value->categoria_cnh								
							];
							if(!empty($pessoaFisica)){								
								DB::table('pessoa_fisicas')->insert($pessoaFisica);							
							}							
						}
						else{
							$pessoaJuridica = [
								'id' => $id,
								'cnpj' => (string) $value->cpfcnpj ,
								'razao_social' => (string) $value->nome
							];
							if(!empty($pessoaJuridica)){
								DB::table('pessoa_juridicas')->insert($pessoaJuridica);
							}
						}
					}
				}				

				dd('Dados inseridos nas tabelas pessoa, pessoa_fisicas e pessoa_juridicas');
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
		/**
		*
		***********************   IMPORTAR REL(3)
		*
		**/

		if(Input::hasFile('import_file_ass_end')){

			$path = Input::file('import_file_ass_end')->getRealPath();
			$data = Excel::load($path, function($reader) {})->get();

			if(!empty($data) && $data->count()){

				foreach ($data as $key => $value) {

					$value->receber_e_mail = str_replace("SIM","1" , $value->receber_e_mail);
					$value->receber_sms = str_replace("SIM","1" , $value->receber_sms);
					$value->cpfcnpj = MaatwebsiteDemoController::limpaCPF_CNPJ_CEP($value->cpfcnpj);

					$id = "";

					$id = DB::table('pessoa_fisicas')->where([
						['cpf', '=', $value->cpfcnpj],
						['nome', '=', $value->nome]
						])->value('id');

					if ($id == "") {
						$id = DB::table('pessoa_juridicas')->where([
						['cnpj', '=', $value->cpfcnpj],
						['razao_social', '=', $value->nome]
						])->value('id');
					}

					$pessoa = [
						'tel_preferencial' => (string) $value->telefone ,
						'tel_alternativo' => (string) $value->telefone_celular ,

						'pref_email' => (integer) $value->receber_e_mail,
						'pref_sms' => (integer) $value->receber_sms,
						'pref_boleto' => 0
					];

					if(!empty($pessoa)){
							DB::table('pessoas')->where('id', $id)->update($pessoa);
						}
				}

				dd('Dados inseridos na tabela pessoa');
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

	public static function cambio($val){
		/*
		** 1- Manual
		** 2- Automático
		** 3- Não Informado
		*/
		$val = str_replace("Manual", "1", $val);
		$val = str_replace("Automatico", "2", $val);
		$val = str_replace("", "3", $val);
		return $val;
	}

	public static function categoria($val){
		/*
		** 1 - Particular;
		** 2 - Comercial (Aluguel e Aprendizagem);
		** 3 - Oficial e Representação;
		** 4 - Diplomático/Consular;
		** 5 - Especiais;
		** 6 - Coleção;
		*/
		$val = str_replace("PASSEIO", "1", $val);
		$val = str_replace("ALUGUEL", "2", $val);
		$val = str_replace("TAXI", "2", $val); // Confirmar qual a categoria 
		$val = str_replace("SEMI REBOCADOR", "5", $val); // Confirmar qual a categoria 
		return $val;
	}

	public static function combustivel($val){
		/*
		** 1  - Biodiesel;
		** 2  - Carvão;
		** 3  - Diesel;
		** 4  - Etanol;
		** 5  - Flex (Gasolina & Etanol);
		** 6  - Gasolina;
		** 7  - Gás Natural Veicular;
		** 8  - Gás Natural;
		** 9  - Hidrogênio;
		** 10 - Querosene;
		** 11 - Tetra-fuel;
		** 12 - Não Informado;
		*/
		$val = str_replace("BIO-GÁS", "7", $val); // Confirmar qual o tipo de combustível
		$val = str_replace("DIESEL", "3", $val);
		$val = str_replace("FLEX", "5", $val);
		$val = str_replace("GASOLINA", "6", $val);
		$val = str_replace("NÂO INFORMADO", "12", $val);
		return $val;
	}

	public function importVec()
	{

		if(Input::hasFile('import_file_vec')){

			$path = Input::file('import_file_vec')->getRealPath();
			$data = Excel::load($path, function($reader) {})->get();
			
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {

					$value->cpfcnpj = MaatwebsiteDemoController::limpaCPF_CNPJ_CEP($value->cpfcnpj);
					$value->placa = MaatwebsiteDemoController::limpaCPF_CNPJ_CEP($value->cpfcnpj);

					$value->cambio = MaatwebsiteDemoController::cambio($value->cambio);
					$value->categoria = MaatwebsiteDemoController::categoria($value->categoria);
					$value->combustivel = MaatwebsiteDemoController::combustivel($value->combustivel);

					$cambio = 3;

					//dd($value);

					$id = "";

					$id = DB::table('pessoa_fisicas')->where([
						['cpf', '=', $value->cpfcnpj],
						['nome', '=', $value->nome]
						])->value('id');

					if ($id == "") {
						$id = DB::table('pessoa_juridicas')->where([
						['cnpj', '=', $value->cpfcnpj],
						['razao_social', '=', $value->nome]
						])->value('id');
					}

					$veiculos[] = [
						'tipo' => (integer) $value->tipo , //FK
						'cor' => (integer) $value->cor , //FK tabela cors
						'placa' => (string) $value->placa ,
						'chassi' => (string) $value->chassi ,
						'renavam' => (string) $value->renavam ,
						'categoria' => (integer) $value->categoria ,
						'combustivel' => (integer) $value->combustivel ,
						'ano_fabricacao' => $value->ano ,
						'ano_modelo' => $value->ano_mod ,
						'tipo' => (string) $value->tipo ,
						'cambio' => (integer) $cambio , //Váriavel está com valor fixo pois não há a informação no relatório
						'numero_portas' => (string) $value->n0_de_portas ,
						'numero_passageiros' => (string) $value->n0_de_passageiros ,
						'kilometragem' => (string) $value->km ,
						'obs' => (string) $value->obs ,
						'niv' => (string) $value->chassi , //No Brasil, também é conhecido como Número do Chassi.
						'condutor' => $id ,//(integer) $value->condutor , //FK tabela pessoa
						'proprietario' => (integer) $value->proprietario , //FK tabela pessoa
						'notafiscal_emissao' => $value->notafiscal_emissao ,
						'notafiscal_retirada_veiculo' => $value->notafiscal_retirada_veiculo ,
						'notafiscal_numero' => (string) $value->notafiscal_numero ,
						'notafiscal_chave' => (string) $value->notafiscal_chave ,
						'numero_motor' => (string) $value->numero_motor ,
					];
				}

				dd($veiculos);
				
				if(!empty($veiculos)){
					
					foreach (array_chunk($veiculos,1000) as $vec) {
						DB::table('veiculos')->veiculos($vec);
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
