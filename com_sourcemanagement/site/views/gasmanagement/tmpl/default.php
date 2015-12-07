<?php
defined('_JEXEC') or die;
JHtml::_('formbehavior.chosen', 'select');

$listOrder     = $this->escape($this->state->get('list.ordering'));
$listDirn      = $this->escape($this->state->get('list.direction'));
?>
<form action="index.php?option=com_sourcemanagement&view=gasmanagement" method="post" id="adminForm" name="adminForm">
	<div class="row-fluid">
		<div class="span6">
			<?php echo JText::_('COM_HELLOWORLD_HELLOWORLDS_FILTER'); ?>
<?php
echo JLayoutHelper::render(
	'joomla.searchtools.default',
	array('view' => $this)
);
?>
</div>
</div>
<table class="table table-striped table-hover">
	<thead>
	<tr>
		<th width="2%"><?php echo JText::_('#'); ?></th>
		<th width="3%">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>)" />
		</th>
		<th width="15%">
			<?php echo JHtml::_('grid.sort', 'id', 'id', $listDirn, $listOrder);?>
		</th>
		<th width="30%">
			<?php echo JHtml::_('grid.sort', 'name', 'name', $listDirn, $listOrder);?>
		</th>
		<th width="30%">
			<?php echo JHtml::_('grid.sort', 'standard', 'standar', $listDirn, $listOrder); ?>
		</th>
		<th width="20%">
			<?php echo JHtml::_('grid.sort', 'brand', 'brand', $listDirn, $listOrder); ?>
		</th>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<td colspan="6">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
	</tfoot>
	<tbody>
	<?php if (!empty($this->items)) : ?>
		<?php foreach ($this->items as $i => $row) :
			$link = JRoute::_('index.php?option=com_sourcemanagementld&task=helloworld.edit&id=' . $row->id);
			?>
			<tr>
				<td>
					<?php echo $this->pagination->getRowOffset($i); ?>
				</td>

				<td>
					<?php echo JHtml::_('grid.id', $i, $row->id); ?>
				</td>
				<td align="center">
					<?php echo $row->id; ?>
				</td>
				<td>
					<a href="<?php echo $link; ?>" title="<?php echo JText::_(''); ?>">
						<?php echo $row->name; ?>
					</a>
				</td>
				<td align="center">
					<?php echo $row->standar; ?>
				</td>
				<td align="center">
					<?php echo $row->brand; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="boxchecked" value="0"/>
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
<?php echo JHtml::_('form.token'); ?>
</form>
