<?php
defined('_JEXEC') or die;

class SourceModelGas extends JModelAdmin{
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
			$item = JArrayHelper::toObject($item, 'JObject');
			return $item;

		}
	}


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
}