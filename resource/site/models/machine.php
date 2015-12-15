<?php

defined('_JEXEC') or die;

class ResourceModelMachine extends JModelForm
{
	public function getForm($data = array(),$loadData =true)
	{
	//	echo 'getform';die;
		$form = $this->loadForm('com_resource.machine', 'machine', array('control' => 'jform', 'load_data' => $loadData));
	
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	public function getItem()
	{
		$app = JFactory::getApplication();
		$id = $app->input->get('id',null);
		//var_dump($id);die;
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query
			->select('a.*,COUNT(a.id) as times')
			->from($db->quoteName('#__resource_machine','a'))
			->join('INNER',$db->quoteName('#__resource_maintain','b').'ON ('.$db->quoteName('a.id').'='.$db->quoteName('b.machine_id').')')
			->group('a.id');
		
		$db->setQuery($query);
		try {
			$results = $db->loadObject();
		} catch (Exception $e) {
			return false;
		}
			
		return $results;
	}
	
	public function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_resource.edit.machine.data', array());
		
		if (empty($data))
		{
			$data = $this->getItem();

		}
		
		$this->preprocessData('com_resource.machine', $data);
		
		return $data;
	}
	
	public function getMaintain($data)
	{
		//var_dump($data);die;
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($db->quoteName(array('a.id', 'w.name','a.oper_time', 'a.limit_time', 'a.oper_name')))
			->from('#__resource_maintain AS a')
			->join('LEFT', $db->quoteName('#__resource_welder') . ' AS w ON w.id = a.welder_id')
			//->join('LEFT', $db->quoteName('#__resource_machine') . ' AS m ON m.id = a.machine_id')
			->where($db->quoteName('machine_id').'='.$data);

		$db->setQuery($query);

		try{
			$ret = $db->loadObjectList();
		}catch (Exception $e){
			return false;
		}
		return $ret;
		
	}
	
	public function edit($data)
	{
		//var_dump($data);die;
		$profile = new stdClass();
		$profile->id = $data['id'];
		$profile->num= $data['num'];
		$profile->model=$data['model'];
		$profile->position = $data['position'];
		$profile->response_person= $data['response_person'];
		$profile->use_time=$data['use_time'];
		$profile->weld_time = $data['weld_time'];
		$profile->workshop_id= $data['workshop_id'];

		try {
			$db = JFactory::getDbo();
			$db->transactionStart();
			
			$result = JFactory::getDbo()->updateObject('#__resource_machine', $profile, 'id');
			$db->transactionCommit();
		} catch (Exception $e) {
		
			$db->transactionRollback();
			return false;
		}
		return $result;
	}
	
	public function save($data)
	{

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
	
		$profile = new stdClass();
		$profile->id = $data['id'];
		$profile->num= $data['num'];
		$profile->model=$data['model'];
		$profile->position = $data['position'];
		$profile->response_person= $data['response_person'];
		$profile->use_time=$data['use_time'];
		$profile->weld_time = $data['weld_time'];
		$profile->workshop_id= $data['workshop_id'];
		try{

			$db->transactionStart();
			
			$result = JFactory::getDbo()->insertObject('#__resource_machine', $profile);
			$db->transactionCommit();
		}catch (Exception $e){

			$db->transactionRollback();
			return false;
		}
	
		return $result;
	}
	

}