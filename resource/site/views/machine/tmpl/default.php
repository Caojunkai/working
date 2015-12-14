<?php
defined('_JEXEC') or die;


JHtml::_('behavior.core');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');

JText::script('ERROR');

JFactory::getDocument()->addScriptDeclaration("
		Joomla.submitbutton = function(task)
		{
			var form = document.getElementById('item-form');
			if (task == 'menu.cancel' || document.formvalidator.isValid(form))
			{
				Joomla.submitform(task, form);
			}
		};
");

?>
<form action="<?php echo JRoute::_('index.php?option=com_resource'); ?>" method="post" name="adminForm" id="item-form" class="form-horizontal">
	<fieldset>
		<legend><?php echo JText::_('COM_WORKSHOP_EDIT_DETAILS');?></legend>
		<?php foreach ($this->form->getFieldset() as $key => $field):?>
			<div class="control-group">
				<div class="control-label">
					<?php echo $field->label;?>
				</div>
				<div class="controls">
					<?php echo $field->input;?>
				</div>
			</div>
		<?php endforeach;?>

	</fieldset>
	<?php if(!isset($_GET['id'])) :?>
	<input type="submit" name="jform[save]" value="保存" />
	<?php else:?>
	<input type="submit" name="jform[edit]" value="修改" />
	<?php endif;?>
	<input type="hidden" name="jform[id]" value="<?php echo isset($_GET['id']) ? $_GET['id'] : null; ?>" />
	<input type="hidden" name="task" value="machine.manage" />
	<a href="<?php echo JRoute::_('index.php?option=com_resource&view=machines'); ?>"><button type="button">取消</button></a>
</form>

<script>
jQuery(document).ready(function($) 
{
	function getdata()
	{
		return 'machine.edit';
	}
})
</script>


