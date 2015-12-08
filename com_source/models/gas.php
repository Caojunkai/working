<?php
defined('_JEXEC') or die;

/**
 * Class SourceModelGas
 */
class SourceModelGas extends JModelAdmin{
	/**
	 * @param array $data
	 * @param bool|TRUE $loadData
	 * @return bool|mixed
     */
	public function getForm($data = array(), $loadData = TRUE)
	{
		$form = $this->loadForm(
			'com_source.gas',
			'gas',
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
				'com_source.edit.gas.data',
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
				->from($db->quoteName('#__gasmanagement'))
				->where($db->quoteName('id')."=".$db->quote($id));
			$db->setQuery($query);
			$item = $db->loadAssoc();
			if(!$item){
				$item = array('id'=>'','name'=>'','brand'=>'','standard'=>'');
			}
			$item =  JArrayHelper::toObject($item, 'JObject');
			return $item;
		}else{
			$item = array('id'=>'','name'=>'','brand'=>'','standard'=>'');
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
				$db->quoteName("a.id").'='.$db->quote($data['id']),
				$db->quoteName("a.name").'='.$db->quote($data['name']),
				$db->quoteName("a.brand").'='.$db->quote($data['brand']),
				$db->quoteName("a.standard").'='.$db->quote($data['standard']),
		);
		$query->update($db->quoteName('#__gasmanagement','a'))
				->set($fields)
				->where($db->quoteName('a.id')."=".$db->quote($id));
		$db->setQuery($query);
		return $db->execute();
	}

	/**
	 * @param $data 从form中获取到的数据
	 * @return bool true or false
	 * 添加信息是调用的方法
     */
	public function add($data){
		$db = JFactory::getDbo();
		$query = $db->getQuery(TRUE);
		$columns = array('id','name','brand','standard');
		$values = $db->quote($data);
		$query->insert($db->quoteName('#__gasmanagement'))
			  ->columns($db->quoteName($columns))
			  ->values(implode(',',$values));
		$db->setQuery($query);
		return $db->execute();
	}

	public function delete(&$pks){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$pks = $db->quote($pks);
		$conditions = $db->quoteName('id')." IN (".implode(',',$pks).")";
		$query->delete($db->quoteName('#__gasmanagement'))
			->where($conditions);
		$db->setQuery($query);
		$this->cleanCache();
		return $db->execute();
	}
}