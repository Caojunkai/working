<?php
defined('_JEXEC') or die;

/**
 * Class SourceModelWelding
 */
class ResourceModelWelding extends JModelAdmin{
	/**
	 * @param array $data
	 * @param bool|TRUE $loadData
	 * @return bool|mixed
	 */
	public function getForm($data = array(), $loadData = TRUE)
	{
		$form = $this->loadForm(
			'com_resource.welding',
			'welding',
			array(
				'control' => 'jform',
				'load_data' => $loadData
			)
		);
		if (empty($form)){
			return FALSE;
		}

		return $form;
	}

	/**
	 * @return array|mixed|object
	 * @throws Exception
	 */
	public function loadFormData()
	{
		$dada = JFactory::getApplication()->getUserState(
			'com_resource.edit.welding.data',
			array()
		);
		if (empty($dada)){
			$dada = $this->getItem();

			return $dada;
		}
	}

	/**
	 * @param null $pk
	 * @return array|mixed|object
	 * @throws Exception
	 */
	public function getItem($pk = NULL)
	{
		$id = JFactory::getApplication()->input->get('id',NULL,'INT');
		if ($id){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('*')
				->from($db->quoteName('#__weldingmanagement'))
				->where($db->quoteName('id')."=".$db->quote($id));
			$db->setQuery($query);
			try{
				$item = $db->loadObject();
			}
			catch(Exception $e){
				$this->setError($e->getMessage());
			}
			if(!$item){
				$item = array('id'=>'','name'=>'','brand'=>'','diameter'=>'','density'=>'','number'=>'','desc'=>'');
				$item = JArrayHelper::toObject($item, 'JObject');
			}
			return $item;
		}else{
			$item = array('id'=>'','name'=>'','brand'=>'','diameter'=>'','density'=>'','number'=>'','desc'=>'');
			$item = JArrayHelper::toObject($item, 'JObject');
			return $item;

		}
	}


	/**
	 * @param array $data
	 * @return mixed
	 * @throws Exception
	 */
	public function save($data)
	{
		$id = JFactory::getApplication()->input->get('id',NULL,'INT');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$fields = array(
			$db->quoteName("a.name").'='.$db->quote($data['name']),
			$db->quoteName("a.brand").'='.$db->quote($data['brand']),
			$db->quoteName("a.diameter").'='.$db->quote($data['diameter']),
			$db->quoteName("a.density").'='.$db->quote($data['density']),
			$db->quoteName("a.number").'='.$db->quote($data['number']),
			$db->quoteName("a.desc").'='.$db->quote($data['desc']),
		);
		$query->update($db->quoteName('#__weldingmanagement','a'))
			->set($fields)
			->where($db->quoteName('a.id')."=".$db->quote($id));
		$db->setQuery($query);
		try{
			return $db->execute();
		}catch(Exception $e){
			$this->setError($e->getMessage());
		}
	}

	/**
	 * @param $data 从form中获取到的数据
	 * @return bool true or false
	 * 添加信息是调用的方法
	 */
	public function add($data){
		$db = JFactory::getDbo();
		$query = $db->getQuery(TRUE);
		$columns = array('name','brand','diameter','density','number','desc');
		$values = $db->quote($data);
		$query->insert($db->quoteName('#__weldingmanagement'))
			->columns($db->quoteName($columns))
			->values(implode(',',$values));
		$db->setQuery($query);
		try{
			return $db->execute();
		}catch(Exception $e){
			$this->setError($e->getMessage());
		}
	}

	public function delete(&$pks){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$pks = $db->quote($pks);
		$conditions = $db->quoteName('id')." IN (".implode(',',$pks).")";
		$query->delete($db->quoteName('#__weldingmanagement'))
			->where($conditions);
		$db->setQuery($query);
		$this->cleanCache();
		try{
			return $db->execute();
		}catch(Exception $e){
			$this->setError($e->getMessage());
		}
	}
}