<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_media
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * File Media Controlle
 *
 * @since  1.6
 */
class ResourceControllerMachine extends JControllerLegacy
{
	public function refreash()
	{
		$model = $this->getModel('machines');
		$ret = $model->getItem();
		if($ret){
			echo  json_encode($ret);
			return ;
		}else{
			echo 'false';
			return ;
		}
		
	}
	
	public function maintain()
	{
		$data = $this->input->post->get('id');
		$model = $this->getModel('machine');
		$ret = $model->getMaintain($data);
		//var_dump($ret);die;
		if($ret){
				echo  json_encode($ret);
				return ;
		}else{
				echo 'false';
				return ;
		}
	}
	
	
	
}