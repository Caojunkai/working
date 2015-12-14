<?php

// echo "san";die();

defined('_JEXEC') or die;

class ResourceViewMachines  extends JViewLegacy

{
	protected $items;


	public function display($tpl = null)
	{
		$this->form = $this->get('form');
		$this->items = $this->get('Item');

		parent::display($tpl);
	}	



}


?>