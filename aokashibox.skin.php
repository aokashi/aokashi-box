<?php
$_IMAGE['skin']['favion'] = 'image/favicon.ico';

if(!defined('AOKASHIBOX_SHOW_TOOL'))
	define('AOKASHIBOX_SHOW_TOOL', 1);

if(!defined('UI_LANG')) die('UI_LANGが設定されていません。');
if(!isset($_LANG)) die('$_LANGが設定されていません。');
if(!defined('PKWK_READONLY')) die('PKWK_READONLYが設定されていません。');

$lang = &$_LANG['skin'];
$link = &$_LINK;
$image = &$_IMAGE['skin'];
$rw = !PKWK_READONLY;

// ここから出力
pkwk_common_headers();
header('Cache-control: no-cache');
header('Pragma: no-cache');
header('Content-Type: text/html; charset=' . CONTENT_CHARSET);
?>
<!DOCTYPE HTML>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
<?php if($nofollow || !$is_read) : ?>
		<meta name="robots" content="NOINDEX,NOFOLLOW"><?php endif; ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" href="skin/aokashibox.css">
<?php if(!empty($image['favicon'])) : ?>
		<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $image['favicon'] ?>"><?php endif; ?>
		<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo $link['rss'] ?>">
		<title><?php echo $title ?> - <?php echo $page_title ?></title>
<?php if(PKWK_ALLOW_JAVASCRIPT && $trackback_javascript) : ?>
		<script type="text/javascript" src="skin/trackback.js"></script><?php endif; ?>
<?php echo $header_tag ?>
	</head>
	<body>
		<header id="header">
			<h1 id="header_title"><a href="<?php echo $link['top'] ?>"><?php echo $page_title ?></a></h1>
			<nav id="header_tool">
<?php if(AOKASHIBOX_SHOW_TOOL){
	// pukiwiki.skin.phpのツールバー部分を加工
	$_IMAGE['skin']['reload']   = 'reload.png';
	$_IMAGE['skin']['new']      = 'new.png';
	$_IMAGE['skin']['edit']     = 'edit.png';
	$_IMAGE['skin']['freeze']   = 'freeze.png';
	$_IMAGE['skin']['unfreeze'] = 'unfreeze.png';
	$_IMAGE['skin']['diff']     = 'diff.png';
	$_IMAGE['skin']['upload']   = 'file.png';
	$_IMAGE['skin']['copy']     = 'copy.png';
	$_IMAGE['skin']['rename']   = 'rename.png';
	$_IMAGE['skin']['top']      = 'top.png';
	$_IMAGE['skin']['list']     = 'list.png';
	$_IMAGE['skin']['search']   = 'search.png';
	$_IMAGE['skin']['recent']   = 'recentchanges.png';
	$_IMAGE['skin']['backup']   = 'backup.png';
	$_IMAGE['skin']['help']     = 'help.png';
	$_IMAGE['skin']['rss']      = 'rss.png';
	$_IMAGE['skin']['rss10']    = & $_IMAGE['skin']['rss'];
	$_IMAGE['skin']['rss20']    = 'rss20.png';
	$_IMAGE['skin']['rdf']      = 'rdf.png';

	function _toolbar($key, $x = 20, $y = 20){
		$lang  = & $GLOBALS['_LANG']['skin'];
		$link  = & $GLOBALS['_LINK'];
		$image = & $GLOBALS['_IMAGE']['skin'];
		if (! isset($lang[$key]) ) { echo 'LANG NOT FOUND';  return FALSE; }
		if (! isset($link[$key]) ) { echo 'LINK NOT FOUND';  return FALSE; }
		if (! isset($image[$key])) { echo 'IMAGE NOT FOUND'; return FALSE; }

		echo '<a href="' . $link[$key] . '">' .
			'<img src="' . IMAGE_DIR . $image[$key] . '" width="' . $x . '" height="' . $y . '" ' .
				'alt="' . $lang[$key] . '" title="' . $lang[$key] . '" />' .
			'</a>' . "\n";
		return TRUE;
	}
	_toolbar('top');

	if($is_page){
		if($rw){
			_toolbar('edit');
			if($is_read && $function_freeze){
				if(!$is_freeze){
					_toolbar('freeze');
				}else{
					_toolbar('unfreeze');
				}
			}
		}
		_toolbar('diff');
		if($do_backup){
			_toolbar('backup');
		}
		if($rw){
			if((bool)ini_get('file_uploads')){
				_toolbar('upload');
			}
			_toolbar('copy');
			_toolbar('rename');
		}
	 _toolbar('reload');
	}
	if ($rw) {
		_toolbar('new');
	}
	_toolbar('list');
	_toolbar('search');
	_toolbar('recent');
	_toolbar('help');
	_toolbar('rss10', 36, 14);
} ?>
			</nav>
		</header>
		<main id="main">
			<div id="main_content">
				<header id="main_content_header">
<?php if($is_page){
						echo '<nav id="main_content_header_topicpath">';
						require_once(PLUGIN_DIR . 'topicpath.inc.php');
						echo plugin_topicpath_inline();
						echo '</nav>';
					}?>
					<h2><?php echo $page ?></h2>
				</header>
				<article>
<?php echo $body ?>
				</article>
<?php if($notes != ''){
					echo '<aside id="main_content_note">' . "\n" . $notes . "\n" . '</aside>' . "\n";
				}?>
<?php if($attaches != ''){
					echo '<aside id="main_content_attach">' . "\n" . $attaches . "\n" . '</aside>' . "\n";
				}?>
			</div>
<?php if(arg_check('read') && exist_plugin_convert('menu')){
				echo '<aside id="main_sidebar">' . "\n" . '<h2>サイドバー</h2>' . "\n" . do_plugin_convert('menu') . "\n" . '</aside>' . "\n";
			}?>
		</main>
		<footer id="footer">
			<div id="footer_copyright">
				<p>Site admin: <a href="<?php echo $modifierlink ?>"><?php echo $modifier?></a></p>
				<p><?php echo S_COPYRIGHT ?>.</p>
				<p>Powered by PHP <?php PHP_VERSION ?>. HTML convert time: <?php echo $taketime ?> sec.</p>
			</div>
		</footer>
	</body>
</html>