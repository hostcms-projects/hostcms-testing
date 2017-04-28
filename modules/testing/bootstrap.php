<?php

/**
 * Класс для инициализации тестирования.
 */
class Testing_Bootstrap
{
	/**
	 * Инициализируем базовые константы для работы HostCMS.
	 *
	 * @return void
	 */
	static public function defineConstants()
	{
		define('HOSTCMS', TRUE);
		define('CHMOD', 664);

    	$reflector = new ReflectionClass('Core');
		$cmsFolder = realpath(dirname($reflector->getFileName()) . '/../../') . '/';

		define('CMS_FOLDER', $cmsFolder);
	}
}