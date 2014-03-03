<?php if($the_action=='report'): ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=I18n::$lang?>" lang="<?=I18n::$lang?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<?=$content?>
</body>
</html>

<?php else: ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=I18n::$lang?>" lang="<?=I18n::$lang?>">
<head>
	<title><?php if($title){ echo $title.' - '; } ?> <?=$site_title?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="x-ua-compatible" content="IE=8" />
	<base href="<?=URL::base(TRUE)?>admin/" />
	<link rel="stylesheet" type="text/css" media="screen, projection" href="../assets/uploadify/uploadify.css" />
	<link rel="stylesheet" type="text/css" media="screen, projection" href="../assets/styles/backend.css" />
	<link rel="stylesheet" type="text/css" media="screen, projection" href="../assets/styles/jquery-ui-1.10.0.custom.min.css" />
	<script type="text/javascript" src="../assets/scripts/jquery-1.9.0.min.js"></script>
	<script type="text/javascript" src="../assets/scripts/jquery-ui-1.10.0.custom.min.js"></script>
	<script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="../assets/ckfinder/ckfinder.js"></script>
	<script type="text/javascript" src="../assets/uploadify/jquery.uploadify-3.1.min.js"></script>
	<script type="text/javascript" src="../assets/scripts/backend.js"></script>
</head>
<body>

<?php /*if(Kohana::$environment>1): ?>
<div id="development-badge">
	<div class="wrapper"><?=__('You are viewing the development site.')?> <a href="<?=$site_url?>admin/" style="color:#fff; text-decoration: underline;"><?=__('Click here')?></a> <?=__('to go to the production site.')?></div>
</div>
<?php endif; */ ?>
<div id="header">
	<div class="wrapper">
		<h1><img src="../assets/images/backend/logoback.png" alt="" width="300" height="43" />
		<?php //$site_title ?>
		<a href="<?=$site_url?>" target="_blank"><?=__('View site')?></a></h1>
		<?php if ($identity): ?>
		<p><?=__('Hi, :user', array(':user' => $identity['name']))?> | <a href="start/session/logout" title="<?=__('Are you sure you want to logout?')?>" class="logout"><?=__('Logout')?></a></p>
		<?php endif; ?>
	</div>
</div>
<?php if ($identity): ?>
<div class="wrapper menu">
	<ul id="menu">
		<li>&nbsp;</li>
		<?php foreach ($menu as $m): ?>
		<li class="<?=$m['selected']?>"><a href="<?=$m['link']?>" class="<?=$m['path']?>"><?=$m['name']?></a></li>
		<?php endforeach; ?>
	</ul>
	<ul id="submenu">
		<?php foreach ($submenu as $s): ?>
		<li class="<?=$s['group']?> <?=$s['selected']?> <?=$s['visible']?>"><a href="<?=$s['link']?>"><?=$s['name']?></a></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php else: ?>
<div class="loginbadge"></div>
<?php endif; ?>
<div class="wrapper content">
	<h2><?=$title?></h2>
	<?php if ($success): ?>
	<div class="success"><?=$success?></div>
	<?php elseif ($errors): ?>
	<div class="error">
		<p><strong><?=__('The following errors were found:')?></strong></p>
		<ul>
			<?php foreach ($errors as $error): ?>
			<li><?=$error?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
	<?=$content?>
</div>
</body>
</html>
<?php endif; ?>