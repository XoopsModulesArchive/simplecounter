<?php

$modversion['name'] = _MI_SIMPLECOUNTER_NAME;
$modversion['version'] = '1.22';
$modversion['description'] = _MI_SIMPLECOUNTER_DESC;
$modversion['credits'] = '';
$modversion['author'] = '<a href="http://xoops-modules.sourceforge.jp/" target="_blank">xoops-modules project</a>';
$modversion['help'] = 'htlp.html';
$modversion['license'] = 'GPL see LICENSE';
$modversion['official'] = 0;
$modversion['image'] = 'logo.png';
$modversion['dirname'] = 'simplecounter';

$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'simplecounter';
$modversion['tables'][1] = 'simplecounter_total';

//Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminmenu'] = '';
$modversion['adminindex'] = 'admin/index.php';

// Menu
$modversion['hasMain'] = 0;

// Blocks
$modversion['blocks'][1]['file'] = 'simplecounter_top.php';
$modversion['blocks'][1]['name'] = _MI_SIMPLECOUNTER_NAME;
$modversion['blocks'][1]['description'] = _MI_SIMPLECOUNTER_DESC;
$modversion['blocks'][1]['show_func'] = 'b_simplecounter_show';
$modversion['blocks'][1]['template'] = 'simplecounter_block.html';

$modversion['blocks'][2]['file'] = 'simplecounter_top.php';
$modversion['blocks'][2]['name'] = _MI_SIMPLECOUNTER_NAME;
$modversion['blocks'][2]['description'] = _MI_SIMPLECOUNTER_IMG_DESC;
$modversion['blocks'][2]['show_func'] = 'b_simplecounter_show';
$modversion['blocks'][2]['template'] = 'simplecounter_img_block.html';
$modversion['blocks'][2]['edit_func'] = 'b_simplecounter_edit';
$modversion['blocks'][2]['options'] = '|.gif';
