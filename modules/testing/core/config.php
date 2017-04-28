<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Класс конфигурации для тестирования.
 */
class Testing_Core_Config extends Core_Config
{
	/**
	 * Список кастомных конфигов.
	 *
	 * @var array
	 */
	static protected $_aCustomConfigs = array();

	/**
	 * Задает кастомный конфиг.
	 *
	 * @return void
	 */
	static public function setCustomConfig(array $aCustomConfig)
	{
		self::$_aCustomConfigs += $aCustomConfig;
	}

	/**
	 * Экземпляр класса.
	 *
	 * @var self
	 */
	static private $_instance = NULL;

	/**
	 * Создает и возвращает экземпляр класса.
	 *
	 * @return self
	 */
	static public function instance()
	{
		if (!isset(self::$_instance))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Возвращает конфиг, если задан кастомный конфиг, то возвращается именно он,
	 * в остальных случая работает стандартное поведение.
	 *
	 * @param  string  $name
	 * @param  mixed  $defaultValue=NULL
	 * @return array
	 */
	public function get($name, $defaultValue = NULL)
	{
		if (isset(self::$_aCustomConfigs[$name]))
		{
			return self::$_aCustomConfigs[$name];
		}

		return parent::get($name);
	}
}