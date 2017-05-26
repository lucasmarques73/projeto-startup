<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Entities\Item;
use DB;
use Excel;

class MaatwebsiteDemoController extends Controller
{
	public static function limpaCampos($valor){
	 $valor = trim($valor);
	 $valor = str_replace(".", "", $valor);
	 $valor = str_replace(",", "", $valor);
	 $valor = str_replace("-", "", $valor);
	 $valor = str_replace("/", "", $valor);
	 $valor = str_replace("(", "", $valor);
	 $valor = str_replace(")", "", $valor);
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

						$value->cpfcnpj = MaatwebsiteDemoController::limpaCampos($value->cpfcnpj);
						$value->data_nascimento = str_replace("00/00/0000", null, $value->data_nascimento);
						$value->data_nascimento = date('Y-m-d', strtotime($value->data_nascimento));
						$value->sexo = MaatwebsiteDemoController::genero($value->sexo);
						$value->cep = MaatwebsiteDemoController::limpaCampos($value->cep);

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
					$value->cpfcnpj = MaatwebsiteDemoController::limpaCampos($value->cpfcnpj);

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
		** 7 - Particular;
		** 8 - Taxi;
		** 9 - Semi Rebocador;
		*/
		$val = trim($val);
		$val = str_replace("PASSEIO", "7", $val);
		$val = str_replace("ALUGUEL", "2", $val);
		$val = str_replace("TAXI", "8", $val); // Confirmar qual a categoria 
		$val = str_replace("SEMI REBOCADOR", "9", $val); // Confirmar qual a categoria 
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
		** 12 - Bio-Gás;
		*/
		$val = trim($val);
		$val = str_replace("BIO-GÁS", "12", $val); // Confirmar qual o tipo de combustível
		$val = str_replace("DIESEL", "3", $val);
		$val = str_replace("ETANOL", "4", $val);
		$val = str_replace("FLEX", "5", $val);
		$val = str_replace("GASOLINA", "6", $val);
		$val = str_replace("NÂO INFORMADO", "12", $val);
		return $val;
	}
	public static function marca($val){
		$val = trim($val);
		$val = str_replace("CITROEN", "CITROËN", $val);
		$val = str_replace("GENERAL MOTORS", "CHEVROLET", $val);
		$val = str_replace("GM - CHEVROLET", "CHEVROLET", $val);
		$val = str_replace("JAC MOTORS", "JAC", $val);
		$val = str_replace("KIA MOTORS", "KIA", $val);
		$val = str_replace("MERCEDES BENZ", "MERCEDES-BENZ", $val);
		$val = str_replace("REBOQUE RECRUSUL", "RECRUSUL", $val);
		$val = str_replace("SAAB-SCANIA", "SCANIA", $val);
		$val = str_replace("VW - VOLKSWAGEN", "VOLKSWAGEN", $val);
		return $val;
	}

	public static function cor($val){
		$val = trim($val);
		$val = str_replace("BRANCA", "Branco", $val);
		$val = str_replace("PRETA", "Preto", $val);
		$val = str_replace("ROXA", "Roxo", $val);
		$val = str_replace("MARRON", "Marrom", $val);		
		$val = str_replace("NÃO ESPECIFICADO", null, $val);		
		return $val;
	}

	
	public static function tipoVec($val){
		$val = str_replace("CL3 AUTOMOVEL LEVE", "AUTOMOVEL", $val);		
		$val = str_replace("CL3 REBOCADOR/TRATOR ACIMA 6,9T", "REBOCADOR/TRATOR ACIMA 6,9T", $val);		
		$val = str_replace("CL3 UTILITARIO DIESEL LEVE", "UTILITARIO DIESEL LEVE", $val);		
		$val = str_replace("CL3 VAN DIESEL LEVE", "VAN DIESEL LEVE", $val);		
		return $val;
	}


	public function importVec()
	{

		if(Input::hasFile('import_file_vec')){

			$path = Input::file('import_file_vec')->getRealPath();
			$data = Excel::load($path, function($reader) {})->get();
			
			$i = 0;
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {

					$value->cpfcnpj = MaatwebsiteDemoController::limpaCampos($value->cpfcnpj);
					$value->placa = MaatwebsiteDemoController::limpaCampos($value->placa);

					$value->cambio = MaatwebsiteDemoController::cambio($value->cambio);
					$value->categoria = MaatwebsiteDemoController::categoria($value->categoria);
					$value->combustivel = MaatwebsiteDemoController::combustivel($value->combustivel);
					$value->montadora = MaatwebsiteDemoController::marca($value->montadora);
					$value->cor = MaatwebsiteDemoController::cor($value->cor);
					$value->tipo_veiculo = MaatwebsiteDemoController::tipoVec($value->tipo_veiculo);
					

					//Não existe o campo Cambio na tabela, por isso estamos inserindo manualmente
					$cambio	= null;


					//Pegar o id da pessoa para inserir nos campos Condutor ou Poprietario
					$id = "";
					$id_pf = null;
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
					//Caso seja PF armazenar como Condutor e Proprietario
					//Se for PJ vamos armazenar apenas como Proprietario
					if (strlen($value->cpfcnpj) <= 11){
						$id_pf = $id;
					}
					if ($id == null) {
						dump('Id == Null');
						dump($value);
					}

					//Pegando o id da cor na tabela de cores
					$cor_id = 0;
					$cor_id = DB::table('cors')->where('descricao',ucfirst(strtolower($value->cor)))->value('id');

					//Pegando o id do tipo na tabela veiculo_tipos
					$tipo_id = null;
					$tipo_id = DB::table('veiculo_tipos')->where('descricao',ucfirst(strtolower($value->tipo_veiculo)))->value('id');

					//Juntando o modelo com a marca. Ex.: A3 1.6 5P;AUDI
					$modelo	= $value->modelo . ";" . $value->montadora;


					//Validando dados e colocando null quando dado inconsistente
					if (strlen($value->chassi) >= 18) {
						$value->chassi = null;
					}

					//Verifica se há algo no campo placa, caso seja 0 salvamos como null
					if (strlen($value->placa) == 0) {
						$value->placa = null;
					}
					//Verifica se o campo placa contém 8 ou mais caracteres
					else if (strlen($value->placa) >= 8) {
						//Caso sim, digitamos a placa errada em obs
						$value->obs = "Placa com digitos a mais: " . $value->placa;
						//E cortamos a string para salvar apenas os 7 primeiros caracteres.
						$value->placa = substr($value->placa,0,7);
					}
					// if ($value->n0_de_passageiros == 0) {
					// 	$value->n0_de_passageiros = null;
					// }
					// if ($value->n0_de_portas == 0) {
					// 	$value->n0_de_portas = null;
					// }
					// if ($value->numero_motor == 0) {
					// 	$value->numero_motor = null;
					// }

					$veiculos[] = [
						'veiculo_tipo_id' => (integer) $tipo_id , //FK
						'cor' => (integer) $cor_id , //FK tabela cors
						'placa' => $value->placa ,
						'chassi' =>  $value->chassi ,
						'renavam' =>  $value->renavam ,
						'categoria' => (integer) $value->categoria ,
						'combustivel' => (integer) $value->combustivel ,
						'ano_fabricacao' => $value->ano ,
						'ano_modelo' => $value->ano_mod ,
						'modelo' => $modelo ,
						//'marca' => (string) $value->montadora,
						'cambio' => $cambio , //Váriavel está com valor fixo pois não há a informação no relatório
						'numero_portas' => $value->n0_de_portas ,
						'numero_passageiros' =>  $value->n0_de_passageiros ,
						'kilometragem' =>  $value->km ,
						'observacao' =>  $value->obs ,
						'niv' =>  $value->chassi , //No Brasil, também é conhecido como Número do Chassi.
						'condutor' => $id_pf ,//(integer) $value->condutor , //FK tabela pessoa
						'proprietario' => $id , //FK tabela pessoa
						'notafiscal_emissao' => $value->notafiscal_emissao ,
						'notafiscal_retirada_veiculo' => $value->notafiscal_retirada_veiculo ,
						'notafiscal_numero' => $value->notafiscal_numero ,
						'notafiscal_chave' =>  $value->notafiscal_chave ,
						'numero_motor' => $value->numero_motor ,
					];


					if (strlen($value->obs) > 0) {
						dump("Contém OBS");
						dump($value);
						//dump($veiculos);
					}
					
				}

				if(!empty($veiculos)){
					
					foreach (array_chunk($veiculos,1000) as $vec) {
						DB::table('veiculos')->insert($vec);
						$i++;
					}
					dd('Foram inseridos ' . $i .'veículos na tabela veiculos');

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

	public function importProf()
	{

		if(Input::hasFile('import_file_prof')){
			$path = Input::file('import_file_prof')->getRealPath();
			$data = Excel::load($path, function($reader) {})->get();

			if(!empty($data) && $data->count()){
				
				foreach ($data as $key => $value) {
					$value->profissao = ucfirst(strtolower($value->profissao));

						$profissao[] = [
							'descricao' => $value->profissao
						];						
											
				}

				if(!empty($profissao)){
					foreach (array_chunk($profissao,1000) as $prof) {
						foreach ($prof as $p) {
							$x = DB::table('profissaos')->where('descricao', array_get($p,'descricao'))->value('descricao');
							if ($x == null) {
								if (array_get($p, 'descricao') != "") {
									DB::table('profissaos')->insert($p);
			 					}
							}
								
						}
					}
				}
				dd('Dados inseridos nas tabelas profissao');
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

	public function importTipoVeiculos()
	{

		if(Input::hasFile('import_file_tipo')){
			$path = Input::file('import_file_tipo')->getRealPath();
			$data = Excel::load($path, function($reader) {})->get();

			if(!empty($data) && $data->count()){
				
				foreach ($data as $key => $value) {
					$value->tipo_veiculo = MaatwebsiteDemoController::tipoVec($value->tipo_veiculo);
					$value->tipo_veiculo = ucfirst(strtolower($value->tipo_veiculo));

						$tipo_veiculo[] = [
							'descricao' => $value->tipo_veiculo
						];													
				}

				if(!empty($tipo_veiculo)){
					foreach (array_chunk($tipo_veiculo,1000) as $tipo) {
						foreach ($tipo as $t) {
							$x = DB::table('veiculo_tipos')->where('descricao', array_get($t,'descricao'))->value('descricao');
							if ($x == null) {
								if (array_get($t, 'descricao') != "") {
									DB::table('veiculo_tipos')->insert($t);
			 					}
							}
								
						}
					}
					dd();
				}
				dd('Dados inseridos nas tabelas veiculo_tipos');
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
