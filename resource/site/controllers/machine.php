<?php

defined('_JEXEC') or die;

class ResourceControllerMachine extends JControllerForm
{
	public function manage() {
		call_user_func(array($this, isset($this->input->post->get('jform', array(), 'array')['edit']) ? 'edit' : 'save'));
	}
	
	public function edit($key = NULL, $urlVar = NULL){
		$data = $this->input->post->get('jform', array(), 'array');
			//var_dump($data);die;
		$model = $this->getModel('machine');
		$ret = $model->edit($data);
		if($ret)
		{
			$this->setRedirect(JRoute::_('index.php?option=com_resource&view=machines', false));
		}
	}
	
	public function save($key = NULL, $urlVar = NULL){

		$data = $this->input->post->get('jform', array(), 'array');
		//	var_dump($data);
		$model = $this->getModel('machine');
		$ret = $model->save($data);
		if($ret)
		{
			$this->setRedirect(JRoute::_('index.php?option=com_resource&view=machines', false));
		}else{
			
		}
		
	}
	
	public function delete()
	{
		$data = $this->input->post->get('cid', array(), 'array');
		//var_dump($this->input->post);die;
		$model = $this->getModel('machines');
		$ret = $model -> delete($data);
		if($ret)
		{
			$this->setRedirect(JRoute::_('index.php?option=com_resource&view=machines', false));
		}
	}
	
	public function implement()
	{
		$data = $this->input->post->get('jform', array(), 'array');
		$model = $this->getModel('machines');
		$ret = $model->saveImplement($data);
		if($ret)
		{
			$this->setRedirect(JRoute::_('index.php?option=com_resource&view=machines', false));
		}else{
			
		}
	}

}