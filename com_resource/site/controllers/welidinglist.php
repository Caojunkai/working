<?php
defined('_JEXEC') or die;

class ResourceControllerWeldingList extends JControllerAdmin{
	public function __construct(array $config)
	{
		$config['view_list'] = 'weldinglist';
		parent::__construct($config);
	}

	public function getModel($name = 'WeldingList', $prefix = 'Resource', $config = array())
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}