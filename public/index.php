<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

/** Funcao de debug para auxiliar no desenvolvimento */
require_once APPLICATION_PATH . '/configs/utildevelpment.php';

//Cria a instancia da base que esta configurado no application.ini
$dbConfig = new Zend_Config_Ini(APPLICATION_PATH .'/configs/application.ini','production');

//Registra na sessao
$registro = Zend_Registry::getInstance();
$registro->set('application',$dbConfig);

//Captura todos os parametros que estÃ£o setados no application.ini na configuracao de banco de dados
$db = Zend_Db::factory($dbConfig->resources->db->adapter, $dbConfig->resources->db->params->toArray());

//Seta como adaptador padrao
Zend_Db_Table::setDefaultAdapter($db);

//Registra a variavel db na sessao
Zend_Registry::set('db',$db);

$application->bootstrap()
            ->run();

