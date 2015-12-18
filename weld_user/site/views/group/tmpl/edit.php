<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');

JFactory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == 'group.cancel' || document.formvalidator.isValid(document.getElementById('group-form')))
		{
			Joomla.submitform(task, document.getElementById('group-form'));
		}
	};
");
?>

<form action="<?php echo JRoute::_('index.php?option=com_weldusers&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="group-form" class="form-validate form-horizontal">
	<fieldset>
		<legend><?php echo JText::_('COM_USERS_USERGROUP_DETAILS');?></legend>
		<div class="control-group">
			<div class="control-label">
				<?php echo $this->form->getLabel('title'); ?>
			</div>
			<div class="controls">
				<?php echo $this->form->getInput('title'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php $parent_id = $this->form->getField('parent_id');?>
			<?php if (!$parent_id->hidden) : ?>
				<div class="control-label">
					<?php echo $parent_id->label; ?>
				</div>
			<?php endif;?>
			<div class="controls">
				<?php echo $parent_id->input; ?>
			</div>
		</div>
	</fieldset>
	<button type="submit" class="btn btn-default btn-primary"style="margin-left: 200px;margin-right: 30px" ><span class="icon-save"></span>提交</button>
	<input type="hidden" name="task" value="group.save">
	<a href="index.php?option=com_weldusers&view=groups">	<button type="button" class="btn"><span class="icon-cancel"></span>取消</button></a>
	</div>
	<?php echo JHtml::_('form.token'); ?>
</form>
