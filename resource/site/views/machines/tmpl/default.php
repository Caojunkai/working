<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_resource
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$app       = JFactory::getApplication();
$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$archived  = $this->state->get('filter.published') == 2 ? true : false;
$trashed   = $this->state->get('filter.published') == -2 ? true : false;
$saveOrder = $listOrder == 'a.ordering';
$columns   = 10;

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_resourcel&task=articles.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();
JFactory::getDocument()->addScriptDeclaration('

jQuery(document).ready(function() {

	jQuery(".action").click(function(){

		if (document.adminForm.boxchecked.value==0){alert("请从列表中先做选择");return false}
		jQuery("input[name=\"task\"]").val("resource.manage");
		jQuery("input[name=\"sub\"]").val(jQuery(this).val());
		jQuery("#adminForm").submit();

	});

});

');


?>

<form action="<?php echo JRoute::_('index.php?option=com_resource&view=machines'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="control-group">
		<div class="controls">
			<a href="<?php echo JRoute::_('index.php?option=com_resource&view=machine&layout=edit', false);?>"><button type="button" class=" btn btn-small btn-success"><span class="icon-new icon-white"></span>新建</button></a>
			<button type="button" value="edit" class="action btn btn-small"><span class="icon-edit"></span>编辑</button>
			<button type="button" value="delete" class="action btn btn-small"><span class="icon-unpublish"></span>删除</button>

		</div>
	</div>
	<?php echo JHtml::_('form.token');?>

	<?php
	// Search tools bar
	echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
	?>
	<?php if (empty($this->items)) : ?>
		<div class="alert alert-no-items">
			<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
		</div>
	<?php else : ?>
		<table class="table table-striped" id="articleList">
			<thead>
			<tr>

				<th width="1%" class="nowrap center">
					<?php echo JHtml::_('grid.checkall'); ?>
				</th>

				<th width="1%" class="center nowrap hidden-phone">
					<?php echo JHtml::_('searchtools.sort', '序列号', 'a.id', $listDirn, $listOrder); ?>
				</th>

				<th width="10%" style="min-width:55px" class="center nowrap center">
					<?php echo JHtml::_('searchtools.sort', '焊机编号', 'a.num', $listDirn, $listOrder); ?>
				</th>

				<th width="10%" class="center nowrap hidden-phone">
					<?php  echo JHtml::_('searchtools.sort', '焊机型号', 'a.model', $listDirn, $listOrder); ?>
				</th>

				<th width="10%" class="center nowrap hidden-phone">
					<?php echo JHtml::_('searchtools.sort', '焊机台位', 'a.position', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="center nowrap hidden-phone">
					<?php echo JHtml::_('searchtools.sort', '责任人员', 'a.response_person', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="center nowrap hidden-phone">
					<?php echo JHtml::_('searchtools.sort', '使用日期', 'a.use_time', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="center nowrap hidden-phone">
					<?php echo JHtml::_('searchtools.sort', '焊接时间', 'a.weld_time', $listDirn, $listOrder); ?>
				<th width="10%" class="center nowrap hidden-phone">
					<?php echo JHtml::_('searchtools.sort', '保养次数', 'times', $listDirn, $listOrder); ?>
				</th>

			</tr>
			</thead>
			<tfoot>
			<tr>
				<td colspan="<?php echo $columns; ?>">
				</td>
			</tr>
			</tfoot>
			<tbody>
			<?php foreach ($this->items as $i => $item) :?>
				<tr class="row<?php echo $i % 2; ?>" >


					<td class="center">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>

					<td class="center hidden-phone">
						<?php echo $this->pagination->getRowOffset($i); ?>
					</td>

					<td class="center">
						<a href="<?php echo JRoute::_('index.php?option=com_resource&view=machine&layout=edit&id='.(int) $item->id);?>"><?php echo $this->escape($item->num); ?></a>
					</td>
					<td class="center hidden-phone">
						<?php echo $this->escape($item->model); ?>
					</td>

					<td class="center">
						<?php echo $this->escape($item->position);?>
					</td>
					<td class="center">
						<?php echo $this->escape($item->response_person);?>
					</td>
					<td class="center">
						<?php echo $this->escape($item->use_time);?>
					</td>
					<td class="center">
						<?php echo $this->escape($item->weld_time);?>
					</td>
					<td class="center">
						<?php echo $this->escape($item->times);?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>


	<?php endif;?>

	<?php echo $this->pagination->getListFooter(); ?>
	<input type="hidden" name="return" value="<?php echo base64_encode( JRequest::getUri() );?>" />
	<input type="hidden" name="option" value="com_resource" />
	<input type="hidden" name="resource" value="machine" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="sub" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<div class="welder_wrap">
	<div class="span6">
		<fieldset >
			<legend>维修保养记录</legend>
			<textarea class="welder_record" rows="5" cols="30"></textarea>
			<p><span>实施人:</span></p>
			<input class="welder_person" type="text" value="" />
			<p><span>实施项目:</span></p>
			<textarea class="welder_project" rows="5" cols="30"></textarea>
		</fieldset>

	</div>
	<div class="span6">
		<form action="<?php echo JRoute::_('index.php?option=com_resource&task=machine.implement'); ?>" method="post" name="adminForm" id="item-form" class="form-horizontal">
			<fieldset class="form-vertical">
				<legend><?php echo JText::_('维修保养实施');?></legend>
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
			<button>批量实施</button>
		</form>
	</div>
</div>



