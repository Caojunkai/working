<?php
defined('_JEXEC') or die;

class SourceControllerGas extends JControllerForm{

	public function edit($key = null, $urlVar = null)
	{
		$app   = JFactory::getApplication();
		$model = $this->getModel();
		$cid   = $this->input->post->get('cid', array(), 'array');
		$context = "$this->option.edit.$this->context";

		// Determine the name of the primary key for the data.
		if (empty($key))
		{
			$key = 'id';
		}

		// To avoid data collisions the urlVar may be different from the primary key.
		if (empty($urlVar))
		{
			$urlVar = $key;
		}
		// Get the previous record id (if any) and the current record id.
		$recordId = (int) (count($cid) ? $cid[0] : $this->input->getInt($urlVar));
		// Access check.

		if (!$this->allowEdit(array($key => $recordId), $key))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=gaslist'
					. $this->getRedirectToListAppend(), false
				)
			);
			return false;
		}
		$this->setRedirect(
			JRoute::_(
				'index.php?option=' . $this->option . '&view=' . $this->view_item
				. $this->getRedirectToItemAppend($recordId, $urlVar), false
			)
		);

	}

	public function save($key = null, $urlVar = null){
		$app   = JFactory::getApplication();
		$model = $this->getModel();
		$id = $app->input->get('id',null,'INT');
		$cid   = $this->input->post->get('cid', array(), 'array');
		if (empty($key))
		{
			$key = 'id';
		}

		if (empty($urlVar))
		{
			$urlVar = $key;
		}
		$recordId = (int) (count($cid) ? $cid[0] : $this->input->getInt($urlVar));


		$data = $this->input->post->get('jform',array(),'array');
		if (!$this->allowEdit(array($key => $recordId), $key))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view='.$this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return false;
		}
		if($id){
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
							. $this->getRedirectToItemAppend($recordId, $urlVar), false
					)
			);

			return false;
		}
	}

	public function delete(){
		$app   = JFactory::getApplication();
		$model = $this->getModel();
		$id = $app->input->get('id',null,'INT');
		$cid   = $this->input->post->get('cid', array(), 'array');
		if (empty($key))
		{
			$key = 'id';
		}

		if (empty($urlVar))
		{
			$urlVar = $key;
		}
		$recordId = (int) (count($cid) ? $cid[0] : $this->input->getInt($urlVar));
		if (!$this->allowEdit(array($key => $recordId), $key))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_EDIT_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=gaslist'
					. $this->getRedirectToListAppend(), false
				)
			);

			return false;
		}
		if($model->delete($cid)){
			$this->setRedirect(
				'index.php?option=' . $this->option . '&view=gaslist'
				. $this->getRedirectToListAppend(), false);
			$this->setMessage('删除成功');
		}else{
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(
				'index.php?option=' . $this->option . '&view=gaslist'
				. $this->getRedirectToListAppend(), false);
		}

	}

	public function manage(){
		switch ($_POST['submit']){
			case 'edit' :
				$this->edit('id');
				break;
			case 'delete' :
				$this->delete('id');
				break;
			case 'add' :
				$this->setRedirect(
					JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_item, false)
				);
				break;
		}
	}

}
