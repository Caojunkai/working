<?php
defined('_JEXEC') or die;
$loading = 'media/com_production/img/loading.gif';
JHtml::_('behavior.formvalidator');
$doc = JFactory::getDocument();
$doc->addStyleSheet('media/com_production/css/main.css');
$doc->addScript('media/com_production/js/main.js');
?>
<div class="pro-component">
	<div class="pro-left">
		<div class="pro-toolbar-box">
			<button class="pro-but pro-but-1">实时曲线</button>
			<button class="pro-but pro-but-2">历史曲线</button>
			<button class="pro-but pro-but-3">自动翻页</button>
			<button class="pro-but pro-but-4">全部焊机</button>
		</div>
		<div class="pro-workshop">
			<?php foreach ($this->workshop as $row) : ?>
				<button class="pro-but pro-but-work" value="<?php echo $row->id; ?>"><?php echo $row->name;  ?></button>
			<? endforeach; ?>
		</div>
		<div class="pro-detail">

		</div>
		<div class="pro-pageturn">
			<button class="pro-but-page-pre" value="0">上一页</button>
			<button class="pro-but-page-next" value="1">下一页</button>
		</div>
	</div>
	<div class="pro-maincontent">
		<iframe id="pro-iframepage" src="http://arcticfox.sinaapp.com/admin" frameborder="0"  scrolling="auto"></iframe>
	</div>
	<div id="loading" ><img src="media/com_production/img/loading2.gif"  align="absmiddle"/>
		<p>加载中...</p>
	</div>
</div>

<script>

</script>


