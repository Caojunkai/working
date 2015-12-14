<?php

defined('_JEXEC') or die;

class ResourceModelMachines extends JModelList
{
	public function getForm($data = array(),$loadData =true)
	{
		$form = $this->loadForm('com_resource.implement', 'implement', array('control' => 'jform', 'load_data' => $loadData));
		
		if (empty($form))
		{
			return false;
		}
		
		return $form;
	}
	
	public function getItem()
	{
		$app = JFactory::getApplication();
		$from = $app->input->get('from');
		if(isset($from)){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
				
			$query
				->select('*')
				->from($db->quoteName('#__resource_machine'))
				->where($db->quoteName('guzhang').'=1');
					
				
			//var_dump($query->__tostring());die;
			$db->setQuery($query);
			$results = $db->loadObjectList();
			//	var_dump($results);die;
			return $results;
		}else{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			
			$query
			->select($db->quoteName(array('id','sequence','coding','model','position',
					'pic','usetime','hanjietime','baoyantime','records','times')))
					->from($db->quoteName('#__resource_machine'));
				
			
			//var_dump($query->__tostring());die;
			$db->setQuery($query);
			$results = $db->loadObjectList();
			//	var_dump($results);die;
			return $results;
		}
		
	}
	
	public function loadFormData()
	{
		
	}
	
	public function saveImplement($data)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$profile = new stdClass();
		$profile->welder_id = $data['welder_id'];
		$profile->machine_id = $data['machine_id'];
		$profile->oper_time= $data['oper_time'];
		$profile->limit_time=$data['limit_time'];
		$profile->oper_name = $data['oper_name'];

		try{
	
			$db->transactionStart();
	
			$result = JFactory::getDbo()->insertObject('#__resource_maintain', $profile);
			$db->transactionCommit();
			
		}catch (Exception $e){

			$db->transactionRollback();
			return false;
		}
		
		return $result;
	}
	
	
	public function delete($data)
	{
		$did = '('.implode(',',$data).')';
	
		$db = JFactory::getDbo();
	
		$db->transactionStart();

		$query = $db->getQuery(true);
	
		// delete all custom keys for user 1001.
		$conditions = array(
				$db->quoteName('id') . 'in'.$did
		);
			
		$query->delete($db->quoteName('#__resource_machine'));
		$query->where($conditions);
		//	var_dump($query->__tostring());die;
		$db->setQuery($query);
		try {
			$result = $db->execute();
			$db->transactionCommit();
		} catch (Exception $e) {
		
			$db->transactionRollback();
			return false;
		}
		//var_dump($result);die;
		return $result;
		
	}
	

}