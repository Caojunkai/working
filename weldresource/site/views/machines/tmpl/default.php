<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_weldresource
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
	$saveOrderingUrl = 'index.php?option=com_weldresourcel&task=articles.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$assoc = JLanguageAssociations::isEnabled();
JFactory::getDocument()->addScriptDeclaration('

jQuery(document).ready(function($) {
	$(".action").click(function(){

		if (document.adminForm.boxchecked.value==0){alert("请从列表中先做选择");return false}
		$("input[name=\"task\"]").val("weldresource.manage");
		$("input[name=\"sub\"]").val(jQuery(this).val());

		if($(this).val() == "implement"){
				var check = [];
				$(":checkbox").each(function(index){
					if($(this).attr("checked")){
						check[index] = $(this).val();
					}
				});
				$("#maintain-check").attr("value",check);
				$("#maintainForm").submit();
		}else{
				$("#adminForm").submit();
		}
	});

	$(".maintain-search").bind("click",function(){
			var machine_id = parseInt($(this).val());
			$.ajax({
				url:"index.php?option=com_weldresource&task=machine.maintain&format=json",
            	type:"post",
            	dataType:"html",
            	data:{
                	id:machine_id
           		},
           		success: function(data){
					if(data){
						$(".welder_record").html(data);
					}else{
						$(".welder_record").html("没有记录");

					}
           		}
			})
	});

	$(".welder_record span").live("click",function(){
			$(".welder_person").val($(this).data("name"));
			$(".welder_project").html("<p>"+$(this).data("desc")+"</p>");
	});


});

');

JFactory::getDocument()->addStyleDeclaration('
		.maintain-record .welder_record{
			width:100%;
			min-height:200px;
			border:1px #CCCCCC solid;
			border-radius:5px;
			font-family:Microsoft Yahei;
			padding:5px;
		}
		.maintain-record .welder_record>span{
			display:block;
			color:red;
		}
		.maintain-record .welder_record>span:hover{
			border:1px solid rgba(0,0,0,.1);
			border-radius:5px;
			cursor:pointer;
		}
		.maintain-record .welder_project{
			width:100%;
			min-height:100px;
			border:1px #CCCCCC solid;
			border-radius:5px;
		}
		.form-vertical legend{
			margin-bottom:0;
		}
		.welder_project p{
			color: #626FF0;
			font-size:15px;
		}

');
?>

<form action="<?php echo JRoute::_('index.php?option=com_weldresource&view=machines'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="control-group">
		<div class="controls">
			<a href="<?php echo JRoute::_('index.php?option=com_weldresource&view=machine&layout=edit', false);?>"><button type="button" class=" btn btn-small btn-success"><span class="icon-new icon-white"></span>新建</button></a>
			<button type="button" value="edit" class="action btn btn-small btn-warning"><span class="icon-edit"></span>编辑</button>
			<button type="button" value="delete" class="action btn btn-small btn-danger"><span class="icon-unpublish"></span>删除</button>
			<button type="button" class="btn btn-small btn-danger disabled"><span class="icon-search"></span>故障列表-暂不可用</button></a>

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
					<?php echo JHtml::_('searchtools.sort', '责任人员', 'welder_name', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="center nowrap hidden-phone">
					<?php echo JHtml::_('searchtools.sort', '使用日期', 'a.use_time', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="center nowrap hidden-phone">
					<?php echo JHtml::_('searchtools.sort', '焊接时间', 'a.weld_time', $listDirn, $listOrder); ?>
				<th width="10%" class="center nowrap hidden-phone">
					<?php echo JHtml::_('searchtools.sort', '保养次数', 'times', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="center nowrap hidden-phone">
					<?php echo JText::_('获取维修记录'); ?>
			</tr>
			</thead>
			<tfoot>
			<tr>
				<td colspan="<?php echo $columns; ?>">
				</td>
			</tr>
			</tfoot>
			<tbody class="machine-table-body">
			<?php foreach ($this->items as $i => $item) :?>
					<tr class="row<?php echo $i % 2; ?>" >

					<td class="center">
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					</td>

					<td class="center hidden-phone">
						<?php echo $this->escape($item->id); ?>
					</td>

					<td class="center ">
						<a href="<?php echo JRoute::_('index.php?option=com_weldresource&view=machine&layout=edit&id='.(int) $item->id);?>"><?php echo $this->escape($item->num); ?></a>
					</td>
					<td class="center hidden-phone">
						<?php echo $this->escape($item->model); ?>
					</td>

					<td class="center">
						<?php echo $this->escape($item->position);?>
					</td>
					<td class="center">
						<?php echo $this->escape($item->welder_name);?>
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
					<td class="center">
						<button type="button" class="btn maintain-search" value="<?php echo $this->escape($item->id); ?>"><span class="icon-search"></span>查询</button>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>


	<?php endif;?>

	<?php echo $this->pagination->getListFooter(); ?>
	<input type="hidden" name="return" value="<?php echo base64_encode( JRequest::getUri() );?>" />
	<input type="hidden" name="option" value="com_weldresource" />
	<input type="hidden" name="weldresource" value="machine" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="sub" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
	<div class="span6">
		<fieldset class="maintain-record">
			<legend>维修保养记录</legend>
			<div class="welder_record"></div>
			<p><span>实施人:</span></p>
			<input class="welder_person" type="text" />
			<p><span>实施项目:</span></p>
			<div class="welder_project"></div>
		</fieldset>

	</div>
	<div class="span6">
		<form action="<?php echo JRoute::_('index.php?option=com_weldresource&view=machines'); ?>" method="post" name="maintainForm" id="maintainForm" class="form-horizontal">
			<fieldset class="form-vertical">
				<legend><?php echo JText::_('维修保养实施');?></legend>
				<?php foreach ($this->form->getFieldset() as $key => $field):?>
					<?php if(!$field->hidden) : ?>
					<div class="control-group">
						<div class="control-label">
							<?php echo $field->label;?>
						</div>
						<div class="controls" name="maintain-contents[]">
							<?php echo $field->input;?>
						</div>
					</div>
					<?php endif ?>
				<?php endforeach;?>

			</fieldset>
			<button type="button" class="action btn btn-primary" value="implement">批量实施</button>
			<?php echo $this->pagination->getListFooter(); ?>
			<input type="hidden" name="return" value="<?php echo base64_encode( JRequest::getUri() );?>" />
			<input type="hidden" name="option" value="com_weldresource" />
			<input type="hidden" name="weldresource" value="maintain" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="sub" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="jform[cid]" value="" id="maintain-check">
			<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>



