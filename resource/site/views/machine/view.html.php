<?php

// echo "san";die();

defined('_JEXEC') or die;

class ResourceViewMachine  extends JViewLegacy

{
	protected $items;


	public function display($tpl = null)
	{

		$this->form = $this->get('Form');
		$this->items = $this->get('Item');
	/*	foreach ($this->form->getFieldset() as $key => $filed)
		{
			var_dump($filed->label);

		}	*/
		parent::display($tpl);
	}	



}


?>