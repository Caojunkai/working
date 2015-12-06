<?php
defined('_JEXEC') or die;
$app 		= JFactory::getApplication();
$doc 		= JFactory::getDocument();
$user 		= JFactory::getUser();
$this->language = $doc->language;
$this->direation = $doc->direction;

// 从模板获取配置参数
$params 	= 	$app->getTemplate(TRUE)->params;

// 检测动态变量
$option 	= 	$app->input->getCmd('option', '');
$view 		= 	$app->input->getCmd('view', '');
$layout 	= 	$app->input->getCmd('layout', '');
$task 		= 	$app->input->getCmd('task', '');
$itemid 	= 	$app->input->getCmd('Itemid', '');
$sitename 	= 	$app->get('sitename');
$menuSite	=	$params->get('nav-menu');//菜单类型
$navbarColor= 	$params->get('nav-menu-color');//导航栏颜色
$isShowPictureGrid = $params->get('is-picturegrid-show')? $params->get('is-picturegrid-show') : 0;//是否展示栅格图
$pictureGridRow    = $params->get('row-picturegrid-num')? $params->get('row-picturegrid-num') : 0;//展示行数
$pictureGridCol    = $params->get('col-picturegrid-num')? $params->get('col-picturegrid-num') : 0;//每行的列数
$j = 0;
for($i = 1; $i <= $pictureGridRow*$pictureGridCol; $i++){
	$pictureUrl[] = $params->get('picturefrid-'.$i);
}
$navbarTextColor = $params->get('nav-menu-text-color');
$menuResult	=	array();//菜单列表
$mainMenu	=	array();
$result		=	array();
$menu		=	$app->getMenu()->getItems('menutype',$menuSite);
//生成菜单列表数组
foreach ($menu as  $key => $value){
	if($value->level == 1){
		$mainMenu[$value->title] = array(
				'title' => $value->title,
				'level' => $value->level,
				'route' => $value->alias,
				'link' 	=> $value->link,
		);
	}else{
		$menuResult[$value->title] = array(
				'title' => $value->title,
				'level' => $value->level,
				'route' => getRoot($value),
				'link' 	=> $value->link,
		);
	}

}

foreach ($mainMenu as $keys => $values){
	foreach ($menuResult as $key => $value){
		if ($values['route'] == $value['route']){
			$arr[$keys]= $values['link'];
			$arr[$key] = $value['link'];
		}
	}
	if (isset($arr)){
		$result[$keys] = $arr;
		unset($arr);
	}
	if(!array_key_exists($keys,$result)){
		$result[$keys] = $values['link'];
	}
}

//获取子菜单的一级菜单
function getRoot($value){
		$route = explode('/',$value->route,2);
		return $route[0];
}


if ($task == "edit" || $layout == "form") {
	$fullWidth = 1;
} else {
	$fullWidth = 0;
}

// 加载bootstrap 框架
JHtml::_('bootstrap.framework');
//加载模板JS
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/template.js');

// 加载模板css bootstrap css
$doc->addStyleSheet('http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css');
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.css');


JHtml::_('bootstrap.loadCss', FALSE, $this->direction);


// 加载网站标题,LOGO文件
if ($this->params->get('logoFile')) {
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
} elseif ($this->params->get('sitetitle')) {
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
} else {
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:jdoc="http://www.w3.org/1999/XSL/Transform"
	  xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>"
	  dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<jdoc:include type="head"/>
	<?php // 如果有GoogleFont参数 则调用 ?>
	<?php if ($this->params->get('googleFont')) : ?>
		<link href='//fonts.googleapis.com/css?family=<?php echo $this->params->get('googleFontName'); ?>'
			  rel='stylesheet' type='text/css'/>
		<style type="text/css">
			h1, h2, h3, h4, h5, h6, .site-title {
				font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontName')); ?>', sans-serif;
			}
		</style>
	<?php endif ?>
	<?php // 模板颜色 ?>
	<?php if ($this->params->get('templateColor')) : ?>
		<style type="text/css">
			.site {
/*				border-top: 1px solid */<?php //echo $this->params->get('templateColor'); ?>/*;*/
				background-color: <?php echo $this->params->get('siteBgColor');?>
			}

			a {
				color: <?php echo $this->params->get('templateColor'); ?>;
			}

			.navbar-inner, .nav-list > .active > a, .nav-list > .active > a:hover, .dropdown-menu li > a:hover, .dropdown-menu .active > a, .dropdown-menu .active > a:hover, .nav-pills > .active > a, .nav-pills > .active > a:hover, .btn-primary {
				background: <?php echo $this->params->get('templateColor'); ?>;
			}

			.navbar-inner {
				-moz-box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
				-webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
				box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
			}
		</style>
	<?php endif ?>
	<style type="text/css">
		.navbar-inverse{
			background: <?php echo $navbarColor ?>;
		}
		.navbar-inverse .navbar-nav>li>a{
			color: <?php echo $navbarTextColor ?>;
		}
	</style>
	<!--    浏览器兼容-->
	<!--[if lt IE 9]>
	<script src="<?php echo JUri::root(TRUE); ?>/media/jui/js/html5.js"></script>
	<![endif]-->
</head>
<!--body布局-->
<body class="site">
<div class="body">
	<div class="container<?php echo($params->get('fluidContainer') ? '' : '-fluid'); ?>">
<!--		顶层-->
		<div class="row top-floor">
			<jdoc:include type="modules" name="top" style="none" />
		</div>
<!--		搜索框-->
		<div class="row search-floor">
			<jdoc:include type="modules" name="search" style="none" />
		</div>

<!--导航栏-->
		<div class="row navigation-wrap">
			<!--开始 navbar-->
			<div class="navbar " role="navigation" id="menu-nav">
				<nav class="navbar navbar-default navbar-inverse" role="navigation" >
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse"
									data-target=".navbar-ex1-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<a class="navbar-brand" href="<?php echo $this->baseurl; ?>/">
							<?php echo $logo; ?>
							<?php if ($this->params->get('sitedescription')) : ?>
								<?php echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription')) . '</div>'; ?>
							<?php endif; ?>
						</a>
						<div class="navigation-bar">
							<jdoc:include type="modules" name="navigation" style=""/>
						</div>
						<div class="collapse navbar-collapse navbar-ex1-collapse navbar-right" id="navbar-select" >
						<?php foreach($result as $keys => $values) : ?>

							<?php if(is_array($values)) : ?>

								<ul class="nav navbar-nav navbar-left">
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" ><?php echo $keys ?><span class="caret"></span>
										</a>
										<ul class="dropdown-menu" role="menu">
										<?php foreach ($values as $key => $value) : ?>

												<li><a href="<?php echo $value ?>" data-tab="tab-chrome"><?php echo $key ?></a></li>

										<?php endforeach ?>
										</ul>
									</li>
								</ul>
								<?php endif ?>

								<?php if(!is_array($values)) : ?>

									<ul class="nav navbar-nav">
										<li><a href="<?php echo $values ?>" ><?php echo $keys ?></a></li>
									</ul>

								<?php endif ?>

						<?php endforeach ?>




						</div>
						<!-- /.navbar-collapse -->
					</div>
				</nav>
			</div>
			<!--结束navbar-->
		</div>

		<div class="row sec-floor">
			<div class="sec-floor-content">
				<jdoc:include type="modules" name="position-2" style="none"/>

			</div>
		</div>

		<!--    第二层栅格图展示-->
		<div class="pictureGrid">
			<?php if($isShowPictureGrid) : ?>
				<?php for($i=0;$i<$pictureGridRow;$i++) : ?>
					<div class="row ">
						<?php for($k=0;$k<$pictureGridCol;$k++) : ?>
							<?php if(!empty($pictureUrl[$j])) : ?>
								<div class="col-md-<?php echo 12/$pictureGridCol; ?>">
									<img src="<?php echo $pictureUrl[$j]; ?>" class="img-responsive img-rounded" alt="">
								</div>
							<?php endif ?>
							<?php $j++; ?>
						<?php endfor ?>
					</div>

				<?php endfor ?>




			<?php endif?>
		</div>

		<!--    第三层-->
		<div class="row component-floor">
			<jdoc:include type="component" style="none"/>
		</div>
		<!--    第四层-->
		<div class="row">
			<div class="col-md-4">
				<jdoc:include type="modules" name="position-4" style="none"/>
			</div>
			<div class="col-md-4">
				<jdoc:include type="modules" name="position-5" style="none"/>
			</div>
			<div class="col-md-4">
				<jdoc:include type="modules" name="position-6" style="none"/>
			</div>
		</div>
		<!--    第五层-->
		<div class="row">
			<div class="col-md-3">
				<jdoc:include type="modules" name="position-7" style="none"/>
			</div>
			<div class="col-md-3">
				<jdoc:include type="modules" name="position-8" style="none"/>
			</div>
			<div class="col-md-3">
				<jdoc:include type="modules" name="position-9" style="none"/>
			</div>
			<div class="col-md-3">
				<jdoc:include type="modules" name="position-10" style="none"/>
			</div>
		</div>
		<!--    第六层-->
		<div class="row">
			<div class="col-md-6">
				<jdoc:include type="modules" name="position-11" style="none"/>
			</div>
			<div class="col-md-6">
				<jdoc:include type="modules" name="position-12" style="none"/>
			</div>
		</div>
		<!--    第七层-->
		<div class="row">
			<jdoc:include type="modules" name="position-13" style="none"/>
		</div>
		<div class="row">
			<jdoc:include type="modules" name="footer" style="none"/>
		</div>
	</div>
</body>
</html>