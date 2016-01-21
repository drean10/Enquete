<?php

class IndexController extends Zend_Controller_Action {

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
		$this->_helper->layout->DisableLayout();
		
		$objEnquete 	= new Application_Model_Enquete();
		$objPergunta 	= new Application_Model_Pergunta();
		$objResposta 	= new Application_Model_Resposta();
		
		/* Verifica se eh uma opcao de salvar, contendo dados vindo do post */		 
		if ( $this->getRequest()->isPost()) {
			/* Preenche o array com o post e salva */
			$arrEnquete = $this->getRequest()->getParam('arrEnquete' );
			
			$arrSaveEnquete["no_titulo"] = $arrEnquete["no_titulo"];
			unset($arrEnquete["no_titulo"]);
			
			$idEnquete = $objEnquete->save( $arrSaveEnquete );
			
			foreach( $arrEnquete as $k => $value ){
				$arrSavePergunta["no_pergunta"] 		= $value["pergunta"];
				$arrSavePergunta["enquete_id_enquete"] 	= $idEnquete;
				
				$idPergunta = $objPergunta->save( $arrSavePergunta );
				
				foreach( $value["resposta"] as $kr => $valuer ){
					$arrSaveResposta["no_resposta"] 			= $valuer;
					$arrSaveResposta["pergunta_id_pergunta"] 	= $idPergunta;
					
					$objResposta->save( $arrSaveResposta );
				}
				
			}
			$this->_redirect('index/enquete');
		}
		
	}
	
	public function enqueteAction()
    {
		$this->_helper->layout->DisableLayout();
		
		$objEnquete 	= new Application_Model_Enquete();
		$objPergunta 	= new Application_Model_Pergunta();
		$objResposta 	= new Application_Model_Resposta();
		$objResultado 	= new Application_Model_Resultado();
		
		/* Verifica se eh uma opcao de salvar, contendo dados vindo do post */		 
		if ( $this->getRequest()->isPost()) {
			/* Preenche o array com o post e salva */
			$arrResultado = $this->getRequest()->getParam('arrResultado' );
			
			foreach( $arrResultado as $kres => $valueres ){
				$arrSaveResultado[$kres]["id_enquete"] 	= $valueres["id_enquete"];
				$arrSaveResultado[$kres]["id_pergunta"] 	= $valueres["id_pergunta"];
				$arrSaveResultado[$kres]["id_resposta"] 	= $valueres["id_resposta"];
				
				$objResultado->save( $arrSaveResultado[$kres] );
			}
			
			$this->_redirect('index/relatorio');
		}
		
		if( $this->getRequest()->getParam('id') ){
			$arrEnquete = $objEnquete->listarId( $this->getRequest()->getParam('id') );
		}else{
			$arrEnquete = $objEnquete->listar();
		}
		
		foreach( $arrEnquete as $k => $value ){
			$arrPerguntas = $objPergunta->fetchAll( "enquete_id_enquete = " . $value["id_enquete"] )->toarray();
			
			foreach( $arrPerguntas as $kp => $valuep ){
				$arrRespostas = $objResposta->fetchAll( "pergunta_id_pergunta = " . $valuep["id_pergunta"] )->toarray();
				$arrDados[$k][$kp]["id_enquete"] 	= $value["id_enquete"];
				$arrDados[$k][$kp]["no_titulo"] 	= $value["no_titulo"];
				$arrDados[$k][$kp]["id_pergunta"] 	= $valuep["id_pergunta"];
				$arrDados[$k][$kp]["no_pergunta"] 	= $valuep["no_pergunta"];
				$arrDados[$k][$kp]["respostas"] 	= $arrRespostas;
			}
			
		}
		
		$this->view->arrEnquete = $arrDados;
		
	}

	public function relatorioAction()
    {
		$this->_helper->layout->DisableLayout();
		
		$objEnquete 	= new Application_Model_Enquete();
		$objPergunta 	= new Application_Model_Pergunta();
		$objResposta 	= new Application_Model_Resposta();
		$objResultado 	= new Application_Model_Resultado();
		
		$arrEnquete = $objEnquete->fetchAll();
		
		foreach( $arrEnquete as $k => $value ){
			$arrPerguntas = $objPergunta->fetchAll( "enquete_id_enquete = " . $value["id_enquete"] )->toarray();
			
			foreach( $arrPerguntas as $kp => $valuep ){
				$arrRespostas = $objResposta->fetchAll( "pergunta_id_pergunta = " . $valuep["id_pergunta"] )->toarray();
				$arrDados[$k][$kp]["id_enquete"] 	= $value["id_enquete"];
				$arrDados[$k][$kp]["no_titulo"] 	= $value["no_titulo"];
				$arrDados[$k][$kp]["id_pergunta"] 	= $valuep["id_pergunta"];
				$arrDados[$k][$kp]["no_pergunta"] 	= $valuep["no_pergunta"];
				
				foreach( $arrRespostas as $kr => $valuer ){
				
					$quantidadeRespostas 	= $objResultado->fetchAll( "id_pergunta = " . $valuer["pergunta_id_pergunta"] )->toarray();
					$percentualPergunta 	= $objResultado->fetchAll( "id_enquete = " . $value["id_enquete"] . " AND id_pergunta = " . $valuer["pergunta_id_pergunta"] . " AND id_resposta = " . $valuer["id_resposta"] )->toarray();
					
					$arrRespostas[$kr]["total_respostas"] 		= sizeof($quantidadeRespostas);
					$arrRespostas[$kr]["total_desta_resposta"] 	= sizeof($percentualPergunta);
					
				}
				
				$arrDados[$k][$kp]["respostas"] 	= $arrRespostas;
				
			}
			
		}
		
		$this->view->arrEnquete = $arrDados;
		
	}
}