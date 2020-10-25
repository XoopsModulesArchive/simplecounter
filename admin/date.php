<?php
// $Id: date.php,v 1.1 2006/03/26 22:27:51 mikhail Exp $
require dirname(__DIR__, 3) . '/include/cp_header.php';

xoops_cp_header();

// $del = empty($_POST['del']) ? false : $_POST['del'];
// if($del){
//	$xoopsDB->query("delete from ".$xoopsDB->prefix("simplecounter")." where uri = ".$xoopsDB->quoteString($del));
//	echo '<font color="red"><b>Deleted row uri='.$del.'</b></font><br>';
//}
?>
<table width='100%' border='0' cellspacing='1' class='outer'>
<tr><td><h4><?php echo _AM_SIMPLECOUNTER_TITLE; ?>(<a href="index.php"><?php echo _AM_SIMPLECOUNTER_BY_URL; ?></a>)</h4></td></tr>
<?php
    $sql = 'select cur_date, today, total from ' . $xoopsDB->prefix('simplecounter_total') . ' order by cur_date desc';
    // $sql = "select DATE_FORMAT(cur_date,'%Y-%m') cur_date, sum(today) month, max(total) month_total from xoops_simplecounter_total group by DATE_FORMAT(cur_date,'%Y-%m');
    $sqlResult = $xoopsDB->query($sql);
    $i = 1;
    $results = [];
    while (list($cur_date, $today, $total) = $xoopsDB->fetchRow($sqlResult)) {
        $r = [];

        $r['cur_date'] = $cur_date;

        $r['today'] = $today;

        $r['total'] = $total;

        $results[] = $r;
    }
?>
<tr><td>
<center><embed src="date-svg.php" name="example" height="300" width="600" type="image/svg-xml" pluginspage="http://www.adobe.com/svg/viewer/install/main.html"></center><br>

<table width="100%" border="1">
<tr>
	<td class="head"><?php echo _AM_SIMPLECOUNTER_DATE; ?></td>
	<td class="head"><b><?php echo _AM_SIMPLECOUNTER_TODAY; ?></b></td>
	<td class="head"><b><?php echo _AM_SIMPLECOUNTER_TOTAL; ?></b></td>
</tr>
<?php foreach ($results as $r) { ?>
<tr class="<?php echo (0 == ($i % 2)) ? 'odd' : 'even'; ?>">
	<td align="right"><?php echo htmlspecialchars($r['cur_date'], ENT_QUOTES | ENT_HTML5); ?></td>
	<td align="right"><?php echo htmlspecialchars($r['today'], ENT_QUOTES | ENT_HTML5); ?></td>
	<td align="right"><?php echo htmlspecialchars($r['total'], ENT_QUOTES | ENT_HTML5); ?></td>
</tr>
<?php } ?>

</table>

</td></tr></table>


<br><center>
<a href="http://sourceforge.jp/">
	<img src="http://sourceforge.jp/sflogo.php?group_id=757" width="96" height="31" border="0" alt="SourceForge.jp" target="_blank">
</a> 
Created by <a href="http://xoops-modules.sourceforge.jp/" target="_blank">xoops-modules project</a>
</center>
<?php
xoops_cp_footer();
?>
