<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;



/**
 * Content Component Article Model
 *
 * @since  1.5
 */
class ResourceModelWelder extends JModelForm
{
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
	public function getTable($type = 'Welder', $prefix = 'ResourceTable', $config = array())
	{
		JTable::addIncludePath(JPATH_COMPONENT.'/tables');
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_resource.welder','welder',	array(	'control' => 'jform','load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
				'com_resource.edit.welder.data', array());
		if (empty($data)) {
			$data = $this->getItem();

			return $data;
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
		$this->setState('welder.id',$table->id);
		return true;
		
	}
	
	public function delete(&$pks){
		try{
			$db = JFactory::getDbo();
			$db->transactionStart();
			
			$query = $db->getQuery(true);
			$pks = $db->quote($pks);
			$conditions = $db->quoteName('id')." IN (".implode(',',$pks).")";
			$query->delete($db->quoteName('#__resource_welder'))
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