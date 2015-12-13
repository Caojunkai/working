<?php
defined('_JEXEC') or die;

class ProductionControllerGlobal extends JControllerLegacy{
	public function showMachine(){
		$input = JFactory::getApplication()->input;
		$data = $input->post->get('id',NULL);
		$model = $this->getModel('global');
		$result = $model->getMachine($data);
		echo json_encode($result);
	}
}