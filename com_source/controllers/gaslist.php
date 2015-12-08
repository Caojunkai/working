<?php
defined('_JEXEC') or die;

class SourceControllerGasList extends JControllerAdmin{
	public function __construct(array $config)
	{
		$config['view_list'] = 'gaslist';
		parent::__construct($config);
	}

	public function getModel($name = 'GasList', $prefix = 'Source', $config = array())
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
	public function edit(){
		echo "dddd";
	}
}