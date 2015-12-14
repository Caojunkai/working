<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_jobtemplate
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HelloWorld Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_jobtemplate
 * @since       0.0.9
 */
class ResourceControllerResource extends JControllerForm
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JControllerLegacy
	 * @since   3.2
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->context = $this->input->get($this->view_item);
		$this->view_item = $this->input->get($this->view_item);
	}
	
	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($this->view_item, 'ResourceModel', $config);
	
	}
	
	public function delete(){
		$app   = JFactory::getApplication();
		$model = $this->getModel();
		$id = $app->input->get('id',null,'INT');
		$cid   = $this->input->post->get('cid', array(), 'array');
		$recordId = (int) (count($cid) ? $cid[0] : $this->input->getInt('id'));
		if (empty($recordId) || !$this->allowEdit(array('id' => $recordId), 'id'))
		{
		
			$this->setMessage('删除失败', 'error');
			$this->setRedirect(JRoute::_($this->getReturnPage(), false));
			return false;
		}
		if($model->delete($cid)){
			$this->setMessage('删除成功');
		}else{
			$this->setMessage('删除失败', 'error');
			
		}
		$this->setRedirect(JRoute::_($this->getReturnPage(), false));
	}
	
	protected function getReturnPage()
	{
		$return = $this->input->get('return', null, 'base64');

		if (empty($return) || !JUri::isInternal(base64_decode($return)))
		{
			return JUri::base();
		}
		else
		{
			return base64_decode($return);
		}
	}
	
	public function manage(){
	
		if(empty($this->input->get('sub')) || !method_exists($this,$this->input->get('sub')) ){
			$this->setMessage('无效的操作', 'error');
			$this->setRedirect(JRoute::_($this->getReturnPage(), false));
			return false;
		}
		return call_user_func(array($this,$this->input->get('sub')));
		
	}
	
}
