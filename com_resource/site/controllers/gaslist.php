<?php
defined('_JEXEC') or die;

/**
 * Class ResourceControllerGasList
 */
class ResourceControllerGasList extends JControllerAdmin{
	/**
	 * ResourceControllerGasList constructor.
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$config['view_list'] = 'gaslist';
		parent::__construct($config);
	}

	/**
	 * @param string $name
	 * @param string $prefix
	 * @param array $config
	 * @return object
	 */
	public function getModel($name = 'GasList', $prefix = 'Resource', $config = array())
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}