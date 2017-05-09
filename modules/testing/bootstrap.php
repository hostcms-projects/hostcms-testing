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
		defined('HOSTCMS') or define('HOSTCMS', TRUE);
		defined('CHMOD') or define('CHMOD', 664);

		if (!defined('CMS_FOLDER')) {
	    	$reflector = new ReflectionClass('Core');
			$cmsFolder = realpath(dirname($reflector->getFileName()) . '/../../') . '/';

			define('CMS_FOLDER', $cmsFolder);
		}
	}
}