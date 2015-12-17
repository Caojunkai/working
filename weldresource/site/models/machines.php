<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_weldresource
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * This models supports retrieving lists of articles.
 *
 * @since  1.6
 */
class WeldResourceModelMachines extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'num', 'a.num',
				'model', 'a.model',
				'position','a.position',
				'use_time','a.use_time',
				'weld_time','a.weld_time',
				'times','welder_name'
			);

			if (JLanguageAssociations::isEnabled())
			{
				$config['filter_fields'][] = 'association';
			}
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$access = $this->getUserStateFromRequest($this->context . '.filter.num', 'filter_num');
		$this->setState('filter.num', $access);


		$categoryId = $this->getUserStateFromRequest($this->context . '.filter.model', 'filter_model');
		$this->setState('filter.model', $categoryId);

		// List state information.
		parent::populateState('a.id', 'desc');

	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return  string  A store id.
	 *
	 * @since   1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.num');
		$id .= ':' . $this->getState('filter.model');
		$id .= ':' . $this->getState('filter.position');
		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return  JDatabaseQuery
	 *
	 * @since   1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$user = JFactory::getUser();
		$app = JFactory::getApplication();
		// Select the required fields from the table.
		$query->select(
			$this->getState('list.select',
				'a.id, a.num , a.model, a.position, b.name as welder_name, a.use_time, a.weld_time, COUNT(c.id) as times')
		);
		$query->from('#__weldresource_machine AS a');
		$query->join('LEFT', '#__weldresource_welder AS b ON a.response_person = b.id');
		$query->join('LEFT','#__weldresource_maintain AS c ON a.id = c.machine_id');
		if ($num = $this->getState('filter.num'))
		{
			$query->where('a.num = ' . $db->quote($num));
		}


		if ($model = $this->getState('filter.model'))
		{
			$query->where('a.model = ' . $db->quote($model));
		}

		// Filter by published state
		$published = $this->getState('filter.published');

		// Filter by search in title.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($search), true) . '%'));
				$query->where('(a.model LIKE ' . $search . ')');
			}
		}
		$query->group('a.id');
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'a.id');
		$orderDirn 	= $this->state->get('list.direction', 'desc');
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
		return $query;

	}

	public function getForm($data = array(),$loadData =true)
	{
		$form = $this->loadForm('com_weldresource.implement', 'implement', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}
		return $form;
	}


	//保存维修保养实施信息
	public function saveImplement($cid,$data)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(TRUE);
		$columns = array('welder_id','machine_id','oper_time','limit_time','oper_name');
		$values = array();
		foreach($cid as $key => $value){
			$values[] = $db->quote($data['welder_id']).','.
						$db->quote($value).','.
						$db->quote($data['oper_time']).','.
						$db->quote($data['limit_time']).','.
						$db->quote($data['oper_name']);
		}
		$query->insert($db->quoteName('#__weldresource_maintain'));
		$query->columns($db->quoteName($columns));
		$query->values($values);

		try{
			$db->transactionStart();
				$db->setQuery($query);
				$result = $db->execute();
			$db->transactionCommit();

		}catch (Exception $e){

			$db->transactionRollback();
			return false;
		}

		return $result;
	}

}