<?php
defined('_JEXEC') or die;

/**
 * Class ResourceControllerGas
 */
class ResourceControllerGas extends JControllerForm{

	/**
	 * @param null $key
	 * @param null $urlVar
	 * @return bool
	 * 点击编辑按钮是调用此方法
	 */
	public function edit($key = null, $urlVar = null)
	{
		$cid   = $this->input->post->get('cid', array(), 'array');
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
			$this->setError(JText::_('没有权限'));
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

	/**
	 * @param null $key
	 * @param null $urlVar
	 * @return bool
	 * @throws Exception
	 * 点击保存时调用方法
	 */
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
			$this->setError(JText::_('没有权限'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view='.$this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return false;
		}
		//判断是否存在id 如果存在调用save 不存在调用add
		if($id){
			$result = $model->save($data);
		}else{
			$result = $model->add($data);
		}
		//判断是否执行成功
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

	/**
	 * @param null $key
	 * @return bool
	 * @throws Exception
	 * 删除时调用方法
	 */
	public function delete($key = NULL){
		$model = $this->getModel();
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
		//判断是否登录 是否允许修改
		if (!$this->allowEdit(array($key => $recordId), $key))
		{
			$this->setError(JText::_('没有权限'));
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

	/**
	 *接收表单传递的参数，判断执行什么操作
	 */
	public function manage(){
		switch ($this->input->post->get('submit','','string')){
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
