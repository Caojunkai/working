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
class WeldResourceControllerMachine extends JControllerLegacy
{

	public function maintain()
	{
		$id = $this->input->post->get('id');
		$model = $this->getModel('machine');
		$result = $model->getMaintain($id);
		if($result){
			$str = "";
			foreach($result as $key => $value){
			$str .=
				"<span data-name=\"".$value['name']."\" data-desc=\"".$value['oper_name']."\">焊机在：".$value['oper_time']."进行了第".($key+1)."次维修保养 有效期至：".$value['limit_time']."</span><br />";
			}
			echo $str;
		}else{
			return FALSE;
		}
	}
	
	
	
}