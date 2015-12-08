<?php
defined('_JEXEC') or die;
JHtml::_('formbehavior.chosen', 'select');
$doc = JFactory::getDocument();
$doc->addScript('media/system/js/core.js');
$listOrder     = $this->escape($this->state->get('list.ordering'));
$listDirn      = $this->escape($this->state->get('list.direction'));
?>


<form action="index.php?option=com_source&view=gaslist" method="post" id="adminForm" name="adminForm">
	<div class="row-fluid">
		<div class="span6">
			<h3>气体管理列表</h3>
			<?php
			echo JLayoutHelper::render(
					'joomla.searchtools.default',
					array('view' => $this)
			);
			?>
		</div>
	</div>
	<button type="submit" name="submit" value="add" class="btn btn-primary btn-success"><span class="icon-new"></span>新建</button>
	<button type="submit" name="submit" value="edit" class="btn btn-warning"><span class="icon-edit"></span>编辑</button>
	<button type="submit" name="submit" value="delete" class="btn btn-danger"><span class="icon-delete"></span>删除</button>
	<input type="hidden" name="task" value="gas.manage">
<table class="table table-striped table-hover">
	<thead>
	<tr>
		<th width="2%"><?php echo JText::_('#'); ?></th>
		<th width="3%">
			<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
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
			$link = JRoute::_('index.php?option=com_source&view=gas&id=' . $row->id);
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
					<?php echo $row->brand; ?>
				</td>
				<td align="center">
					<?php echo $row->standard; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
	</tbody>
</table>
</form>
