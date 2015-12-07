<?php
defined('_JEXEC') or die;

class SourceManagementControllerGasManagement extends JControllerAdmin{
	public function getModel($name = 'GasManagement', $prefix = 'SourceManagementMOdel', $config = array())
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}