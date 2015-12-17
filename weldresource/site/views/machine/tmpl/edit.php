<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<form action="<?php echo JRoute::_('index.php?option=com_weldresource&layout=edit&id=' . (int) $this->item->id); ?>"
	  method="post" name="adminForm" id="adminForm">
	<div class="form-horizontal">
		<fieldset class="adminform">
			<legend><?php echo JText::_('焊机信息管理'); ?></legend>
			<div class="row-fluid">
				<div class="span6">
					<?php foreach ($this->form->getFieldset() as $field): ?>
						<div class="control-group ">
							<div class="control-label"><?php echo $field->label; ?></div>
							<div class="controls"><?php echo $field->input; ?></div>
						</div>
					<?php endforeach; ?>
					<div>
						<div>
		</fieldset>
		<div>
			<div class="control-group">
				<div class="controls">

					<button type="submit" class="btn btn-default btn-primary"style="margin-left: 200px;margin-right: 30px" ><span class="icon-save"></span>提交</button>
					<input type="hidden" name="task" value="weldresource.apply">
					<input type="hidden" name="weldresource" value="machine" />
					<a href="index.php?option=com_weldresource&view=machines">	<button type="button" class="btn"><span class="icon-cancel"></span>取消</button></a>
				</div>
			</div>

			<?php echo JHtml::_('form.token'); ?>
</form>
