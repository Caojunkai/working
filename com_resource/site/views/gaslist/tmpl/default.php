<?php
defined('_JEXEC') or die;
JHtml::_('formbehavior.chosen', 'select');
$listOrder     = $this->escape($this->state->get('list.ordering'));
$listDirn      = $this->escape($this->state->get('list.direction'));
?>


<form action="index.php?option=com_resource&view=gaslist" method="post" id="adminForm" name="adminForm">
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
		<th width="20%">
			<?php echo JHtml::_('grid.sort', '编号', 'number', $listDirn, $listOrder);?>
		</th>
		<th width="25%">
			<?php echo JHtml::_('grid.sort', '名称', 'name', $listDirn, $listOrder);?>
		</th>
		<th width="30%">
			<?php echo JHtml::_('grid.sort', '规格', 'standard', $listDirn, $listOrder); ?>
		</th>
		<th width="20%">
			<?php echo JHtml::_('grid.sort', '牌号', 'brand', $listDirn, $listOrder); ?>
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
			$link = JRoute::_('index.php?option=com_resource&view=gas&id=' . $row->id);
			?>
			<tr>
				<td>
					<?php echo $this->pagination->getRowOffset($i); ?>
				</td>

				<td>
					<?php echo JHtml::_('grid.id', $i, $row->id); ?>
				</td>
				<td align="center">
					<a href="<?php echo $link; ?>" title="<?php echo JText::_('显示详情'); ?>">
						<?php echo $row->number; ?>
					</a>
				</td>
				<td>
					<a href="<?php echo $link; ?>" title="<?php echo JText::_('显示详情'); ?>">
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
