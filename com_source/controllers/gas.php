<?php
defined('_JEXEC') or die;

class SourceControllerGas extends JControllerForm{

	public function edit($key = NULL, $urlVar = NULL)
	{
		$cid   = $this->input->post->get('cid', array(), 'array');
		var_dump($cid);
	}

	public function save($key = null, $urlVar = null){
		$app   = JFactory::getApplication();
		$model = $this->getModel();
		$id = $app->input->get('id',null,'INT');
		$cid   = $this->input->post->get('cid', array(), 'array');
		$data = $this->input->post->get('jform',array(),'array');
		if($id != NULL){
			$result = $model->save($data);
		}else{
			$result = $model->add($data);
		}
		if($result){
			$this->setRedirect(
					'index.php?option=' . $this->option . '&view=gaslist'
					. $this->getRedirectToListAppend(), false);
			$this->setMessage('保存成功');
		}else{
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(
					JRoute::_(
							'index.php?option=' . $this->option . '&view=' . $this->view_item
							. $this->getRedirectToListAppend(), false
					)
			);

			return false;
		}
	}


}
