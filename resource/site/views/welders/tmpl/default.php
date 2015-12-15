<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_resource
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


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

<form action="<?php echo JRoute::_('index.php?option=com_resource&view=welders'); ?>" method="post" name="adminForm" id="adminForm">
<div class="control-group">
			<div class="controls">
				<a href="<?php echo JRoute::_('index.php?option=com_resource&view=welder&layout=edit', false);?>"><button type="button" class=" btn btn-small btn-success"><span class="icon-new icon-white"></span>新建</button></a>
				<button type="button" value="edit" class="action btn btn-small"><span class="icon-edit"></span>编辑</button>
				<button type="button" value="delete" class="action btn btn-small"><span class="icon-unpublish"></span>删除</button>
								
			</div>
		</div>


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
							<?php echo JText::_("序列号"); ?>
						</th>

						<th width="10%" style="min-width:55px" class="nowrap center">
							<?php echo JHtml::_('searchtools.sort', '焊工姓名', 'a.name', $listDirn, $listOrder); ?>
						</th>
			
						<th width="12%" class="nowrap hidden-phone">
							<?php  echo JHtml::_('searchtools.sort',  '班组', 'a.groups', $listDirn, $listOrder); ?>
						</th>
					
						<th width="12%" class="nowrap hidden-phone">
							<?php echo JHtml::_('searchtools.sort', '上岗时间', 'a.work_start', $listDirn, $listOrder); ?>
						</th>
						<th width="12%" class="nowrap hidden-phone">
							<?php echo JHtml::_('searchtools.sort', '岗位', 'a.site', $listDirn, $listOrder); ?>
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
							<a href="<?php echo JRoute::_('index.php?option=com_resource&view=welder&layout=edit&id='.(int) $item->id);?>"><?php echo $this->escape($item->name); ?></a>
						</td>
				
						<td>
							<?php echo $this->escape($item->groups); ?>
						</td>
					
						<td class="hidden-phone">
							<?php echo JHtml::_('date', $item->work_start, JText::_('DATE_FORMAT_LC4')); ?>
						</td>
						
						<td>
							<?php echo $this->escape($item->site);?>
						</td>
					

						
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
	
		
		<?php endif;?>

		<input type="hidden" name="return" value="<?php echo base64_encode( JRequest::getUri() );?>" />
		<input type="hidden" name="option" value="com_resource" />
		<input type="hidden" name="resource" value="welder" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="sub" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
