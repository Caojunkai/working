<?php
defined('_JEXEC') or die;

/**
 * Class SourceModelGas
 */
class ResourceModelWelding extends JModelForm{

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
	public function getTable($type = 'Welding', $prefix = 'ResourceTable', $config = array())
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

	public function getParameter(){
		$jinput = JFactory::getApplication()->input;
		$id = $jinput->get('id',null,'INT');
		return $id;
	}


	public function getItem($pk = null)
	{
		$pk = (!empty($pk)) ? $pk : (int) JFactory::getApplication()->input->getint('id');
		$table = $this->getTable();

		if ($pk > 0)
		{
			// Attempt to load the row.
			$return = $table->load($pk);

			// Check for a table object error.
			if ($return === false && $table->getError())
			{
				$this->setError($table->getError());

				return false;
			}
		}

		// Convert to the JObject before adding other data.
		$properties = $table->getProperties(1);
		$item = JArrayHelper::toObject($properties, 'JObject');

		if (property_exists($item, 'params'))
		{
			$registry = new Registry;
			$registry->loadString($item->params);
			$item->params = $registry->toArray();
		}

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
		$this->setState('welding.id',$table->id);
		return true;

	}

	public function delete(&$pks){
		try{
			$db = JFactory::getDbo();
			$db->transactionStart();

			$query = $db->getQuery(true);
			$pks = $db->quote($pks);
			$conditions = $db->quoteName('id')." IN (".implode(',',$pks).")";
			$query->delete($db->quoteName('#__resource_welding'))
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
}