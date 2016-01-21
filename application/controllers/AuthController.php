<?php

/**
 * Classe AuthController - Responsavel por verificar autenticacao, efetuar o login, efetuar o lougout
 * @author felipe.araujo
 *
 */
class AuthController extends Zend_Controller_Action {
	
	/**
	 * The default action - show the home page
	 */
	public function loginAction() {
		//debug(oi,1);
		/* Usa o layout proprio do sistenma quando o usuario estiver logado */
		//$this->_helper->layout->setLayout('login');
		$this->_helper->layout->DisableLayout();
		
		/* Verifica se o formulario de login foi submetido */		 
		if ( $this->getRequest()->isPost() ) {
			
			/* Preenche o array com o post e salva */
       		$arrDataForm = $this->getRequest()->getParam('arrDataForm' );
       		//debug($arrDataForm,1);
			if(empty($arrDataForm['ds_login'])){
				$this->_redirect( "/auth/login" );
			}
			
       		/* Configura o zend auth adapter dbtable para autenticacao */
			$objAuthAdapter = new Zend_Auth_Adapter_DbTable(
	        	Zend_Registry::get( 'db' ) , 'usuario' , 'ds_login' , 'ds_senha'  , 'md5(?)'
	        );
			
	        $objAuthAdapter->setIdentity( $arrDataForm['ds_login'] )->setCredential( $arrDataForm['ds_senha'] );
	        
	        $objResult = $objAuthAdapter->authenticate();
			
	        if(  $objResult->isValid() ){
                    
	        	$objAuth = Zend_Auth::getInstance();
	        	$objUser = $objAuthAdapter->getResultRowObject( array( 'id_usuario' , 'ds_login' , 'ds_senha'  ) , 'ds_senha' );
				
	        	$objAuth->getStorage()->write( $objUser );
                   
                        //povoado sessao para a intranet
                        $user = new Zend_Session_Namespace('user');
                        $user->id_usuario = $objAuth->getIdentity()->id_usuario;
                        
                        //povoado sessao para a intranet
                        $usuario           = new Zend_Session_Namespace('usuario');
                        $usuario->id       = $objAuth->getIdentity()->id_usuario;
						$usuario->ds_login = $objAuth->getIdentity()->ds_login;
						
                        //redireciono para a index
                        //$this->_redirect( "/index" );
						$this->_redirect( "/gerenciador/listarmidia" );
                        
	        }
	        else{
	        	$this->_redirect( "/auth/login" );
	        }
		}
	}
	
	public function logoutAction(){
		$objAuth = Zend_Auth::getInstance();
		$objAuth->clearIdentity();
		$this->_redirect( "/auth/login" );
	}
}

