<?php
defined('_JEXEC') or die;

/**
 * Class SourceModelGas
 */
class WeldResourceModelMachine extends JModelForm{

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Machine', $prefix = 'WeldResourceTable', $config = array())
	{
		JTable::addIncludePath(JPATH_COMPONENT.'/tables');
		return JTable::getInstance($type, $prefix, $config);
	}


	/**
	 * @param array $data
	 * @param bool|TRUE $loadData
	 * @return bool|mixed
	 */
	public function getForm($data = array(), $loadData = TRUE)
	{
		$form = $this->loadForm(
			'com_weldresource.machine',
			'machine',
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
			'com_weldresource.edit.machine.data',
			array()
		);
		if (empty($dada)){
			$dada = $this->getItem();

			return $dada;
		}
	}

	public function getParameter(){
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id',null,'INT');
		return $id;
	}


	public function getItem($pk = NULL)
	{
		$pk = (!empty($pk)) ? $pk : (int) $this->getParameter();
		if ($pk > 0)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query
				->select('a.*,COUNT(b.id) as times')
				->from($db->quoteName('#__weldresource_machine','a'))
				->join('LEFT',$db->quoteName('#__weldresource_maintain','b').'ON ('.$db->quoteName('a.id').'='.$db->quoteName('b.machine_id').')')
				->where($db->quoteName('a.id').'='.$db->quote($pk))
				->group('a.id');
			$db->setQuery($query);
			try {
				$item = $db->loadObject();
			} catch (Exception $e) {
				return false;
			}
		}else {
			$table = $this->getTable();
			// Convert to the JObject before adding other data.
			$properties = $table->getProperties(1);
			$item = JArrayHelper::toObject($properties, 'JObject');

		}

//		var_dump($item);die;
		return $item;

	}
	public function save($data){
		$db = JFactory::getDbo();
		$db->transactionStart();
		$table = $this->getTable();
		if(!$table->save($data)){
			$db->transactionRollback();
			return false;
		}
		$db->transactionCommit();
		$this->setState('machine.id',$table->id);
		return true;

	}

	public function delete(&$pks){
		try{
			$db = JFactory::getDbo();
			$db->transactionStart();

			$query = $db->getQuery(true);
			$pks = $db->quote($pks);
			$conditions = $db->quoteName('id')." IN (".implode(',',$pks).")";
			$query->delete($db->quoteName('#__weldresource_machine'))
				->where($conditions);
			$db->setQuery($query);
			$db->execute();
			$db->transactionCommit();
		}catch (Exception $e){
			$db->transactionRollback();
			return false;
		}

		return true;
	}

	public function getMaintain($id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($db->quoteName(array('b.name','a.oper_time',  'a.oper_name','a.limit_time')))
			->from('#__weldresource_maintain AS a')
			->join('LEFT','#__weldresource_welder' . ' AS b ON b.id = a.welder_id')
			->where($db->quoteName('a.machine_id').'='.$id)
			->order('a.oper_time ASC');
		$db->setQuery($query);
		try{
			$result = $db->loadAssocList();
		}catch (Exception $e){
			return false;
		}
		return $result;

	}
}