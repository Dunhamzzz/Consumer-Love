<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo $title_for_layout; ?></title>
	<meta property="og:title" content="Consumer Love" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://consumerlove.org" />
	<meta property="og:image" content="" />
	<meta property="og:site_name" content="Consumer Love" />
	<meta property="fb:admins" content="505549054" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<?php
	echo $this->Html->meta('icon');
	echo $this->Html->script(array(
		'https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js',
		'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js',
		'http://apis.google.com/js/plusone.js',
		'global'
	));
	echo $this->Html->css(array(
		'http://fonts.googleapis.com/css?family=Copse|Corben:700&v2',
		'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css',
		'style'
	));

	echo $scripts_for_layout;
	//echo $this->element('external/google_analytics');
?>
</head>
<body>
<div id="user-bar">
<div class="container">
	<a href="/" class="site-title">Consumer Love <span class="heart"> &hearts;</span></a>
	<div id="user">
		<?php if(isset($userData)): ?>
		<span class="logged-in">Welcome <?php echo $this->Love->userLink($userData); ?></span>,	<span class="logout">
			<?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?>
		</span>
		<?php else: ?>
		<span class="guest">
			<?php echo $this->Html->link('Register', array('plugin' => null, 'controller' => 'users', 'action' => 'signup')); ?> or
			<?php echo $this->Html->link('Login', array('plugin' => null, 'controller' => 'users', 'action' => 'login')); ?> to participate!
		</span>
		<?php endif; ?>
	</div>
</div></div>
<header<?php echo isset($hideHeader) ? ' class="hidden"' : ''; ?>>
	<div class="container">
		<h1 id="page-title" class="site-title"><a href="<?php echo $this->here;?>">
		<?php if(0): ?>
			<span id="rot8-1" class="rot8">We <strong class="hearts">&hearts;</strong> Products</span>
			<span id="rot8-2" class="rot8">at Consumer Love</span>
		<?php else: ?>
			<?php echo str_replace('&hearts;', '<span class="heart">&hearts;</span>', $title_for_layout);?>
		<?php endif; ?>
		</a></h1>
		<ul id="menu">
			<li><?php echo $this->Html->link('Todays Activity', '/');?></li>
			<li><?php echo $this->Html->link('Browse Categories', array('controller' => 'categories', 'action' => 'index', 'admin' => false, 'plugin' => false, 'escape' => false)); ?></li>
		</ul>
	</div>
</header>
<div id="main">
<div class="container<?php echo isset($pageClass) ? ' '.$pageClass: '';?>">
	<div id="content" class="<?php echo isset($disableSidebar) ? 'no-sidebar' : ''; ?>">
		<?php if(!empty($this->Html->_crumbs)): ?>
		<div id="breadcrumbs">
			<?php echo $this->Html->getCrumbs(' > ','Consumer Love');?>
		</div>
		<?php endif;?>
	<?php echo $content_for_layout; ?>
	</div>
	<?php if(!isset($disableSidebar)): ?>
	<div id="side">
		<?php
		// Setup Widgets
		if(isset($userData)) {
			if($userData['User']['is_admin'] == true) {
				$pageWidgets['admin'] =  false;
			}
		} else {
			array_unshift($pageWidgets, 'guest_welcome');
		}
		foreach($pageWidgets as $widget => $vars):
			if(is_int($widget)) $widget = $vars;?>
		<div class="widget <?php echo $widget;?>">
		<?php echo $this->element('widgets/'.$widget, (array) $vars);?>
		</div>
	<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div></div>
<footer>
	<div id="footer-links-wrapper">
		<ul id="footer-links">
			<li class="first">Popular Categories
				<ul class="sub">
					<li>nothing</li>
				</ul>
			</li>
			<li>Trending Today
				<ul class="sub">
					<li>nada</li>
				</ul>
			</li></li>
			<li>Hot Forum Topics
				<ul class="sub">
					<li>diddly-squat</li>
				</ul>
			</li></li>
			<li class="last">Latest Posts
				<ul class="sub">
					<li>not a lot</li>
				</ul>
			</li></li>
		</ul>
	</div>
	<p>Copyright &copy; 2011 consumerlove.org</p>
</footer>
<?php if(!isset($userData)): ?>
<div id="register-login" title="You must Login or Register to participate">
	<div>
		<h3>Create a new account</h3>
		<p class="footnote">Sign up in 1 minute flat!</p>
		<?php echo $this->element('forms/signup');?>
	</div>
	<div>
		<h3>Login</h3>
		<p class="footnote">Login to your existing account.</p>
		<?php echo $this->element('forms/login'); ?>
	</div>
</div>
<?php endif; ?>
<div id="flashses" style="display: none;">
<?php echo $this->Session->flash(); ?>
<?php echo $this->Session->flash('auth');?>
</div>
<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>