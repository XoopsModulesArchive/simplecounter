<?php
// $Id: date-svg.php,v 1.1 2006/03/26 22:27:51 mikhail Exp $
require dirname(__DIR__, 3) . '/mainfile.php';

if (!$xoopsUser || !$xoopsUser->isAdmin()) {
    exit();
}
header('Content-Type: image/svg-xml');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 20010904//EN" 
	"http://www.w3.org/TR/2000/CR-SVG-20001102/DTD/svg-20001102.dtd">
<svg xml:space="default" width="600" height="300">
<?php
    function simpleblog_get_max_graph($n)
    {
        $num = $n;

        $per = 10;

        if ($num < 100) {
            $per = 20;
        } elseif ($num < 500) {
            $per = 40;
        } elseif ($num < 1000) {
            $per = 100;
        } elseif ($num < 10000) {
            $per = 1000;
        } else {
            $per = 10000;
        }

        while (0 != ($num % $per)) {
            $num++;
        }

        return $num;
    }

$sql = 'select cur_date, today, total from ' . $xoopsDB->prefix('simplecounter_total') . ' order by cur_date desc limit 30';
$sqlResult = $xoopsDB->query($sql);
$i = 1;
$results = [];
$todayMax = $totalMax = 0;
$firstDate = $lastDate = null;
while (list($cur_date, $today, $total) = $xoopsDB->fetchRow($sqlResult)) {
    $r = [];

    $r['cur_date'] = $cur_date;

    $r['today'] = $today;

    $r['total'] = $total;

    $results[] = $r;

    if (empty($lastDate)) {
        $lastDate = $cur_date;
    }

    $firstDate = $cur_date;

    if ($today > $todayMax) {
        $todayMax = $today;
    }

    if ($total > $totalMax) {
        $totalMax = $total;
    }
}
$todayMax = simpleblog_get_max_graph($todayMax);
$totalMax = simpleblog_get_max_graph($totalMax);

$graphWidth = 540;
$graphHeight = 247;
$graph_x = 30;
$graph_y = 250;
$graph_count = count($results) - 1;
$graph_x_between = ($graphWidth / $graph_count);
?>
	<rect x="0" y="0" width="600" height="300" fill="none" stroke="#333333" stroke-width="1">
	<text x="1" y="16" stroke="lime" font-size="9px"><?php echo $todayMax; ?></text>
	<text x="1" y="130" stroke="lime" font-size="9px"><?php echo $todayMax / 2; ?></text>
	<text x="575" y="16" stroke="blue" font-size="9px"><?php echo $totalMax; ?></text>
	<text x="575" y="130" stroke="blue" font-size="9px"><?php echo $totalMax / 2; ?></text>
	<line x1="30" y1="124" x2="579" y2="124" stroke="#999999" stroke-width="1">
	
<?php

    if ($graph_count >= 0) {
        $i = 0;

        $todayLine = '';

        $totalLine = '';

        foreach ($results as $r) {
            $x = ($graphWidth + $graph_x) - ($graph_x_between * $i);

            // today

            if (0 == $r['today']) {
                $today_y = $graph_y;
            } else {
                $today_y = (int)($graph_y - ($graphHeight * ($r['today'] / $todayMax)));
            }

            $todayLine .= " $x,$today_y";

            echo '<circle cx="' . $x . '" cy="' . $today_y . '" r="2" fill="lime" stroke="lime" stroke-width="1">' . "\n";

            // total

            if (0 == $r['total']) {
                $total_y = $graph_y;
            } else {
                $total_y = (int)($graph_y - ($graphHeight * ($r['total'] / $totalMax)));
            }

            $totalLine .= " $x,$total_y";

            echo '<circle cx="' . $x . '" cy="' . $total_y . '" r="2" fill="blue" stroke="blue" stroke-width="1">' . "\n";

            $i++;
        } ?>

	<polyline 
		fill="none" 
		stroke="lime" 
		stroke-width="2" 
		points="<?php echo $todayLine; ?>">
	<polyline 
		fill="none" 
		stroke="blue" 
		stroke-width="2" 
		points="<?php echo $totalLine; ?>">
	<text x="20" y="262" stroke="black" font-size="12px"><?php echo $firstDate; ?></text>
	<text x="530" y="262" stroke="black" font-size="12px"><?php echo $lastDate; ?></text>
<?php
    } ?>
        

	<line x1="30" y1="250" x2="570" y2="250" stroke="black" stroke-width="1">
	<line x1="30" y1="250" x2="30" y2="2" stroke="black" stroke-width="1">
		<line x1="25" y1="3" x2="35" y2="3" stroke="black" stroke-width="1">
		<line x1="25" y1="124" x2="35" y2="124" stroke="black" stroke-width="1">
	<line x1="570" y1="250" x2="570" y2="2" stroke="black" stroke-width="1">
		<line x1="565" y1="3" x2="575" y2="3" stroke="black" stroke-width="1">
		<line x1="565" y1="124" x2="575" y2="124" stroke="black" stroke-width="1">
			
	<line x1="10" y1="284" x2="20" y2="284" stroke="lime" stroke-width="1">
	<text x="25" y="290" stroke="black" font-size="12px">Today</text>
	
	<line x1="110" y1="284" x2="120" y2="284" stroke="blue" stroke-width="1">
	<text x="125" y="290" stroke="black" font-size="12px">Total</text>
</svg>

