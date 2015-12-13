<?php
defined('_JEXEC') or die;

/**
 * Class ProductionModelGlobal
 */
class ProductionModelGlobal extends JModelLegacy{

	/**
	 * @param null $pk
	 * @return mixed
	 * @desc 获取
	 */
	public function getMachine($pk = NULL){
		$db = JFactory::getDbo();
		$query = $db->getQuery(TRUE);
		$query->select('id,state,coding')
				->from($db->quoteName("#__resource_machine"))
				->where($db->quoteName('workshopid')."=".$db->quote($pk))
				->order('state desc');
		$db->setQuery($query);
		try{
			return $db->loadAssocList();
		}catch(Exception $e){
			$e->getMessage();
		}
	}


	/**
	 * @return mixed
	 */
	public function getWorkshop(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(TRUE);
		$query->select('id,name')
				->from($db->quoteName('#__resource_workshop'));
		$db->setQuery($query);
		try{
			return $db->loadObjectList();
		}catch(Exception $e){
			$e->getMessage();
		}
	}
}
