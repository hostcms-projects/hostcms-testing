<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Класс ядра с конфигом для тестирования.
 */
class Testing_Core extends Core
{
	/**
	 * Инициализирует ядро.
	 *
	 * @return boolean
	 */
	static public function init()
	{
		if (self::isInit())
		{
			return TRUE;
		}

		$fBeginTime = Core::getmicrotime();

		self::setModulesPath();
		self::registerCallbackFunction();

		mb_internal_encoding('UTF-8');

		self::$config = Testing_Core_Config::instance();

		// Main config
		self::mainConfig();

		self::$log = Core_Log::instance();

		// Constants init
		$oConstants = Core_Entity::factory('Constant');
		$oConstants->queryBuilder()->where('active', '=', 1);
		$aConstants = $oConstants->findAll();
		foreach ($aConstants as $oConstant)
		{
			$oConstant->define();
		}

		!defined('TMP_DIR') && define('TMP_DIR', 'hostcmsfiles/tmp/');
		!defined('DEFAULT_LNG') && define('DEFAULT_LNG', 'ru');
		!defined('BACKUP_DIR') && define('BACKUP_DIR', CMS_FOLDER . 'hostcmsfiles' . DIRECTORY_SEPARATOR . 'backup' . DIRECTORY_SEPARATOR);

		// Если есть ID сессии и сессия еще не запущена - то стартуем ее
		// Запускается здесь для получения языка из сессии.
		/* && !isset($_SESSION)*/
		(isset($_REQUEST[session_name()]) || isset($_COOKIE[session_name()])) && Core_Session::start();

		// Before _loadModuleList()
		if (isset($_REQUEST['lng_value']) && Core_Auth::logged())
		{
			Core_Auth::setCurrentLng($_REQUEST['lng_value']);
		}

		// Observers
		Core_Event::attach('Core_DataBase.onBeforeConnect', array('Core_Database_Observer', 'onBeforeConnect'));
		Core_Event::attach('Core_DataBase.onAfterConnect', array('Core_Database_Observer', 'onAfterConnect'));
		Core_Event::attach('Core_DataBase.onBeforeSelectDb', array('Core_Database_Observer', 'onBeforeSelectDb'));
		Core_Event::attach('Core_DataBase.onAfterSelectDb', array('Core_Database_Observer', 'onAfterSelectDb'));

		self::_loadModuleList();

		self::$_init = TRUE;

		Core_Registry::instance()->set('Core_Statistics.totalTimeBegin', $fBeginTime);

		return TRUE;
	}
}