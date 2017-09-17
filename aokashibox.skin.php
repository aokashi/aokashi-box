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

$is_home = ($_page === $defaultpage) ? true : false;

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
    <?php if($nofollow || !$is_read) : ?><meta name="robots" content="NOINDEX,NOFOLLOW"><?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="skin/normalize.css">
    <link rel="stylesheet" href="skin/aokashibox.css">
    <?php if(!empty($image['favicon'])) : ?><link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $image['favicon'] ?>"><?php endif; ?>
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo $link['rss'] ?>">
    <title><?php if(!$is_home) : echo $title . ' - '; endif; ?><?php echo $page_title; ?></title>
    <?php if(PKWK_ALLOW_JAVASCRIPT && $trackback_javascript) : ?><script type="text/javascript" src="skin/trackback.js"></script><?php endif; ?>
<?php echo $header_tag ?>
  </head>
  <body>
    <header class="l-header">
      <div class="l-wrap">
        <h1 class="l-header-title"><a href="<?php echo $link['top'] ?>"><?php echo $page_title ?></a></h1>
        <nav class="l-header-tool menu is-inline">
          <ul>
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

    echo '<li class="menus"><a href="' . $link[$key] . '">' .
      '<img src="' . IMAGE_DIR . $image[$key] . '" width="' . $x . '" height="' . $y . '" ' .
        'alt="' . $lang[$key] . '" title="' . $lang[$key] . '" />' .
      '</a></li>' . "\n";
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
          </ul>
        </nav>
      </div>
    </header>
    <main class="l-main">
      <div class="l-wrap">
        <section class="l-main-content">
<?php if($is_page && !$is_home) : // パンくずリストの表示 ?>
          <header class="l-main-content-header">
            <nav class="topicpath">
<?php   require_once(PLUGIN_DIR . 'topicpath.inc.php'); echo plugin_topicpath_convert(); ?>
            </nav>
          </header>
<?php endif; ?>
          <article class="l-doc">
<?php echo $body ?>
          </article>
<?php if($lastmodified != '' || $notes != '' || $attaches != '') : ?>
          <footer class="l-main-content-footer">
<?php   if($lastmodified != '') : ?>
            <ul>
              <li>Last Modified: <?php echo $lastmodified; ?></li>
            </ul>
<?php   endif; if($notes != '') : ?>
            <aside class="aside is-note">
<?php     echo $notes; ?>
            </aside>
<?php   endif; if($attaches != '') : ?>
            <aside class="aside is-attach">
<?php     echo $attaches; ?>
            </aside>
<?php   endif; ?>
          </footer>
<?php endif; ?>
        </section>
<?php if(arg_check('read') && exist_plugin_convert('menu')): ?>
        <aside class="l-main-sidebar l-doc">
          <h2 class="l-main-sidebar-title">サイドバー</h2>
<?php   echo do_plugin_convert('menu'); ?>
        </aside>
<?php endif; ?>
      </div>
    </main>
    <footer class="l-footer">
      <div class="l-wrap">
        <div class="l-footer-copyright">
          <p>Site admin: <a href="<?php echo $modifierlink ?>"><?php echo $modifier?></a></p>
          <p><?php echo S_COPYRIGHT ?>.</p>
          <p>Powered by PHP <?php PHP_VERSION ?>. HTML convert time: <?php echo $taketime ?> sec.</p>
        </div>
      </div>
    </footer>
  </body>
</html>