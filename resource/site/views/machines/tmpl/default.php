<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('behavior.modal');
JHtml::_('formbehavior.chosen', 'select');

$data = $this->items;
//var_dump($data);die;
?>
<style>
.welder_wrap div{
	float:left;
}
.welder_right{
	margin-left: 50px;
}

</style>
<div>
	<h3>设备保养维护</h3>
</div>
<div>
<form action="<?php echo JRoute::_('index.php?option=com_resource');?>" method="post" name="adminForm" id="adminForm">
<a href="<?php echo JRoute::_('index.php?option=com_resource&view=machines&from=error');?>"><button type="button">故障列表</button></a>
<a href="<?php echo JRoute::_('index.php?option=com_resource&view=machines');?>"><button type="button">刷新</button></a>
<input type="submit" value="删除" name="jform[delete]" />

<a href="<?php echo JRoute::_('index.php?option=com_resource&view=machine');?>"><button type="button">添加焊机</button></a>
</div>
	<div>
			<table class="table table-striped" id="menuList">
				<thead>
					<tr>
						<th width="3%">
						<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th width="8%">
							焊机序号
						</th>
						<th width="8%" class="">
							焊机编码
						</th>
						<th width="8%" class="">
							焊机型号
						</th>
						<th width="9%" class="">
							焊机台位
						</th>
						<th width="8%">
							责任人员
						</th>
						<th width="9%">
							使用日期
						</th>
						<th width="9%">
							焊接时间
						</th>
						<th width="10%">
							保养时间(H)
						</th>
						<th width="10%">
							维修记录
						</th>
						<th width="9%">
							保养次数
						</th>
						<th width="9%">
							修改
						</th>
					</tr>
				</thead>
			
				<tbody>
				<?php foreach ($this->items as $i => $value) :?>
					<tr value="<?php echo $value->id;?>">
						<td>
							<?php echo JHtml::_('grid.id', $i, $value->id); ?>
						</td>
						<td >
							<?php echo $value->sequence;?>
						</td>
						<td>
							<?php echo $value->coding;?>
						</td>
						<td>
							<?php echo $value->model;?>
						</td>
						<td>
							<?php echo $value->position;?>
						</td>
						<td>
							<?php echo $value->pic;?>
						</td>
						<td >
							<?php echo $value->usetime;?>
						</td>
						<td>
							<?php echo $value->hanjietime;?>
						</td>
						<td>
							<?php echo $value->baoyantime;?>
						</td>
						<td>
							<?php echo $value->records;?>
						</td>
						<td>
							<?php echo $value->times;?>
						</td>
						<td>
							<a href="<?php echo JRoute::_('index.php?option=com_resource&view=machine&id='.$value->id);?>"><button type='button'>修改</button></a>
						<td>
					</tr>
				<?php endforeach;?>
				</tbody>
				<tfoot>
					<tr colspan="4"></tr>
				</tfoot>
			</table>	
			<input type="hidden" name="task" value="machine.delete" />
	</div>
</form>
	<div class="welder_wrap">
		<div class="span5">			
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
				<button>批量实施</button>
			</form>
		</div>
	</div>
<script>
jQuery(document).ready(function($) 
{

	$("tr").live("click" , function(){
		var welder_id = $(this).attr('value');
		
		$(".welder_record").empty();
		$(".welder_person").empty();
		$(".welder_project").empty();

		var xuhao = $(this).children("td").eq(1).html();

		 $.post(
		 	"<?php echo JUri::base();?>index.php?option=com_resource&task=machine.maintain&format=json",
		 	{id:welder_id},
		 	function(result){
		    	if(result)
		    	{		    		
		    		//alert(xuhao);
		    		for(var i=1;i<=result.length;i++)
		    		{
		    			var str= xuhao+'号机器第'+i+'次保养:'+result[i-1]['oper_time'];
		    			$(".welder_record").append(str);
		    		}
		    		$(".welder_person").attr('value',result[0]['name']);
		    		$(".welder_project").html(result[0]['oper_name'])
		    	}
		  });

	})

	
})
</script>
	
	
	
