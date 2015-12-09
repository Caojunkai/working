<?php
defined('_JEXEC') or die;
?>
<form action="<?php echo JRoute::_('index.php?option=com_resource&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" role="form">
	<div class="form-horizontal">
		<fieldset class="adminform">
			<legend>焊丝信息设定</legend>
			<div class="row-fluid">
				<div class="span6">
					<?php foreach ($this->form->getFieldset() as $field): ?>
						<div class="control-group">
							<div class="control-label"><?php echo $field->label; ?></div>
							<div class="controls"><?php echo $field->input; ?></div>
						</div>
					<?php endforeach; ?>
					<div>
						<div>
		</fieldset>
	</div>
	<button type="submit" class="btn btn-default btn-primary" style="margin-left: 30%;margin-right: 20px"><span class="icon-save"></span>提交</button>
	<input type="hidden" name="task" value="welding.save">
	<a href="index.php?option=com_resource&view=weldinglist">	<button type="button" class="btn"><span class="icon-cancel"></span>取消</button>
	</a>
</form>
