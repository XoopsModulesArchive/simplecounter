<?php
// $Id: update_before_1_1_3_to_1_2.php,v 1.1 2006/03/26 22:27:51 mikhail Exp $
require dirname(__DIR__, 3) . '/include/cp_header.php';

xoops_cp_header();

// create new table

$table_name = $xoopsDB->prefix('simplecounter_total');
$xoopsDB->queryF('
CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
  cur_date DATE not null primary key,
  today bigint not null default 0,
  total bigint not null default 0
) ENGINE = ISAM;');

?>
<center><h2>UPDATE OK. Please delete this script.</h2></center>
<br><center>
<a href="http://sourceforge.jp/">
	<img src="http://sourceforge.jp/sflogo.php?group_id=757" width="96" height="31" border="0" alt="SourceForge.jp" target="_blank">
</a> 
Created by <a href="http://xoops-modules.sourceforge.jp/" target="_blank">xoops-modules project</a>
</center>
<?php
xoops_cp_footer();
?>
