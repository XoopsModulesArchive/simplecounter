<?php
// $Id: index.php,v 1.1 2006/03/26 22:27:51 mikhail Exp $
require dirname(__DIR__, 3) . '/include/cp_header.php';

xoops_cp_header();

$del = empty($_POST['del']) ? false : $_POST['del'];
if ($del) {
    $xoopsDB->query('delete from ' . $xoopsDB->prefix('simplecounter') . ' where uri = ' . $xoopsDB->quoteString($del));

    echo '<font color="red"><b>Deleted row uri=' . $del . '</b></font><br>';
}
?>
<table width='100%' border='0' cellspacing='1' class='outer'>
<tr><td><h4><?php echo _AM_SIMPLECOUNTER_TITLE; ?>(<a href="date.php"><?php echo _AM_SIMPLECOUNTER_BY_DATE; ?></a>)</h4></td></tr>
<?php
    $order = empty($_GET['order']) ? 'total desc, today desc, yesterday desc, cur_date desc ' : trim($_GET['order']);
    $sql = 'select uri, cur_date, today, yesterday, total from ' . $xoopsDB->prefix('simplecounter') . ' order by ' . $order;
    $sqlResult = $xoopsDB->query($sql);
    $i = 1;
    $tToday = $tYesterday = $tTotal = 0;
?>
<tr><td>
<table width="100%" border="1">
<tr>
	<td class="head">No</td>
	<td class="head"><b><?php echo _AM_SIMPLECOUNTER_URI; ?>&nbsp;<a href="index.php?order=<?php echo urlencode('uri desc, total desc, today desc, yesterday desc, cur_date desc'); ?>">&lt;</a><a href="index.php?order=<?php echo urlencode('uri, total, today, yesterday, cur_date'); ?>">&gt;</a></b></td>
	<td class="head"><b><?php echo _AM_SIMPLECOUNTER_TOTAL; ?>&nbsp;<a href="index.php?order=<?php echo urlencode('total desc, today desc, yesterday desc, cur_date desc'); ?>">&lt;</a><a href="index.php?order=<?php echo urlencode('total, today, yesterday, cur_date'); ?>">&gt;</a></b></td>
	<td class="head"><b><?php echo _AM_SIMPLECOUNTER_TODAY; ?>&nbsp;<a href="index.php?order=<?php echo urlencode('today desc, yesterday desc, cur_date desc'); ?>">&lt;</a><a href="index.php?order=<?php echo urlencode('today, yesterday, cur_date'); ?>">&gt;</a></b></td>
	<td class="head"><b><?php echo _AM_SIMPLECOUNTER_YESTERDAY; ?>&nbsp;<a href="index.php?order=<?php echo urlencode('yesterday desc, cur_date desc'); ?>">&lt;</a><a href="index.php?order=<?php echo urlencode('yesterday, cur_date'); ?>">&gt;</a></b></td>
	
	<td class="head">edit</td>
</tr>
<?php while (list($uri, $cur_date, $today, $yesterday, $total) = $xoopsDB->fetchRow($sqlResult)) { ?>
<tr class="<?php echo (0 == ($i % 2)) ? 'odd' : 'even'; ?>">
	<td align="center"><?php echo $i; $i++ ?></td>
	<td ><?php echo htmlspecialchars($uri, ENT_QUOTES | ENT_HTML5); ?></td>
	<td align="right"><?php echo htmlspecialchars($total, ENT_QUOTES | ENT_HTML5); $tTotal += $total; ?></td>
	<td align="right"><?php echo htmlspecialchars($today, ENT_QUOTES | ENT_HTML5); $tToday += $today; ?></td>
	<td align="right"><?php echo htmlspecialchars($yesterday, ENT_QUOTES | ENT_HTML5); $tYesterday += $yesterday; ?></td>
	<form action="index.php" method="post"><td align="center"><input type="hidden" name="del" value="<?php echo htmlspecialchars($uri, ENT_QUOTES | ENT_HTML5); ?>"><input type="submit" name="delete" value="<?php echo _AM_SIMPLECOUNTER_DELETE; ?>"></td></form>
</tr>
<?php } ?>
<tr class="foot">
	<td align="center">-</td>
	<td align="center">-</td>
	<td align="right"><?php echo htmlspecialchars($tTotal, ENT_QUOTES | ENT_HTML5); ?></td>
	<td align="right"><?php echo htmlspecialchars($tToday, ENT_QUOTES | ENT_HTML5); ?></td>
	<td align="right"><?php echo htmlspecialchars($tYesterday, ENT_QUOTES | ENT_HTML5); ?></td>
	<td align="center">-</td>
</tr>
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
