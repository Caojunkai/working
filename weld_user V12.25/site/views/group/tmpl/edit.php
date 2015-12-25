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

	Joomla.twoFactorMethodChange = function(e)
	{
		var selectedPane = 'com_users_twofactor_' + jQuery('#jform_twofactor_method').val();

		jQuery.each(jQuery('#com_users_twofactor_forl;                                                                                              ms_container>div'), function(i, el) {
			if (el.id != selectedPane)
			{
				jQuery('#' + el.id).hide(0);
			}
			else
			{
				jQuery('#' + el.id).show(0);
			}
		});
	};
");
$fieldsets = $this->form->getFieldsets();
?>

<form action="<?php echo JRoute::_('index.php?option=com_weldusers&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="group-form" class="form-validate form-horizontal">
	<?php echo JLayoutHelper::render('joomla.edit.item_title', $this); ?>
	<fieldset>
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('用户组设置', true)); ?>


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

		<?php echo JHtml::_('bootstrap.endTab'); ?>


		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'levels', JText::_('用户组访问级别设置', true)); ?>
			<?php foreach($this->levels as $keys => $values) : ?>
				<?php if(@in_array((int)$this->item->id,$this->groupLevel[$values['id']])){$checked = TRUE;}else{$checked=FALSE;} ?>
				<div class="control-group">
					<div class="controls">
						<label class="checkbox" for="<?php echo "levels_".$values['id'];  ?>" aria-invalid="true">
							<input type="checkbox" name="jform[levels][]" value="<?php echo $values['id'] ?>" id="<?php echo "levels_".$values['id']; ?>" <?php if($checked){echo "checked=\"checked\"";}?> aria-invalid="false"><?php echo $values['title']?>
						</label>
					</div>
				</div>
			<?php endforeach ?>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.endTabSet'); ?>







	</fieldset>
	<button type="submit" class="btn btn-default btn-primary"style="margin-left: 200px;margin-right: 30px" ><span class="icon-save"></span>提交</button>
	<input type="hidden" name="task" value="group.save">
	<a href="index.php?option=com_weldusers&view=groups">	<button type="button" class="btn"><span class="icon-cancel"></span>取消</button></a>
	</div>
	<?php echo JHtml::_('form.token'); ?>
</form>
