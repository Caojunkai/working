<?php
defined('_JEXEC') or die;

class SourceViewGasList extends JViewLegacy{

	public function display($tpl = NULL)
	{
		// Get data from the model
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');


		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		// Set the tool-bar and number of found items
//		$this->addToolBar();
		//添加侧边栏
		$sidebarData = [
				['set','index.php?option=com_content&view=articles',TRUE],
				['net','index.php?option=com_categories&extension=com_content',FALSE]
		];
		JHtmlSidebar::addEntry('set' , 'index.php?option=com_content&view=articles',TRUE);
		JHtmlSidebar::addEntry('more' , 'index.php?option=com_categories&extension=com_content' ,FALSE);
		$this->sidebar = JHtmlSidebar::render();

		// Display the template
		parent::display($tpl);
	}


	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar()
	{
		$title = JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLDS');

		if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}

		JToolBarHelper::title($title, 'helloworld');
		JToolBarHelper::deleteList('', 'helloworlds.delete');
		JToolBarHelper::editList('helloworld.edit');
		JToolBarHelper::addNew('helloworld.add');
	}
}
