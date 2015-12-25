<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_weldusers
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidator');

JFactory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == 'level.cancel' || document.formvalidator.isValid(document.getElementById('level-form')))
		{
			Joomla.submitform(task, document.getElementById('level-form'));
		}
	};
");
/*
window.addEvent('domready', function(){
	document.id('user-groups').getElements('input').each(function(i){
		// Event to check all child groups.
		i.addEvent('check', function(e){
			// Check the child groups.
			document.id('user-groups').getElements('input').each(function(c){
				if (this.getProperty('rel') == c.id)
				{
					c.setProperty('checked', true);
					c.setProperty('disabled', true);
					c.fireEvent('check');
				}
			}.bind(this));
		}.bind(i));

		// Event to uncheck all the parent groups.
		i.addEvent('uncheck', function(e){
			// Uncheck the parent groups.
			document.id('user-groups').getElements('input').each(function(c){
				if (c.getProperty('rel') == this.id)
				{
					c.setProperty('checked', false);
					c.setProperty('disabled', false);
					c.fireEvent('uncheck');
				}
			}.bind(this));
		}.bind(i));

		// Bind to the click event to check/uncheck child/parent groups.
		i.addEvent('click', function(e){
			// Check the child groups.
			document.id('user-groups').getElements('input').each(function(c){
				if (this.getProperty('rel') == c.id)
				{
					c.setProperty('checked', true);
					if (this.getProperty('checked'))
					{
						c.setProperty('disabled', true);
					} else {
						c.setProperty('disabled', false);
					}
					c.fireEvent('check');
				}
			}.bind(this));

			// Uncheck the parent groups.
			document.id('user-groups').getElements('input').each(function(c){
				if (c.getProperty('rel') == this.id)
				{
					c.setProperty('checked', false);
					c.setProperty('disabled', false);
					c.fireEvent('uncheck');
				}
			}.bind(this));
		}.bind(i));

		// Initialise the widget.
		if (i.getProperty('checked'))
		{
			i.fireEvent('click');
		}
	});
});
*/
?>

<form action="<?php echo JRoute::_('index.php?option=com_weldusers&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="level-form" class="form-validate form-horizontal">
	<fieldset>
		<legend><?php echo JText::_('COM_USERS_LEVEL_DETAILS');?></legend>
		<div class="control-group">
			<div class="control-label">
				<?php echo $this->form->getLabel('title'); ?>
			</div>
			<div class="controls">
				<?php echo $this->form->getInput('title'); ?>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?php echo JText::_('COM_USERS_USER_GROUPS_HAVING_ACCESS');?></legend>
		<?php echo JHtml::_('access.usergroups', 'jform[rules]', $this->item->rules); ?>
	</fieldset>
	<button type="submit" class="btn btn-default btn-primary"style="margin-left: 200px;margin-right: 30px" ><span class="icon-save"></span>提交</button>
	<input type="hidden" name="task" value="level.save">
	<a href="index.php?option=com_weldusers&view=levels">	<button type="button" class="btn"><span class="icon-cancel"></span>取消</button></a>
	</div>
	<?php echo JHtml::_('form.token'); ?>
</form>
