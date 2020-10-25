<?php
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
// define('SIMPLEBLOG_SYS_LOCALE', 'CURDATE()');
// define('SIMPLEBLOG_SYS_LOCALE', 'DATE_SUB(CURDATE(), INTERVAL 9 HOUR)');

function b_simplecounter_get($uri)
{
    global $xoopsDB;

    $table_name = $xoopsDB->prefix('simplecounter');

    $sql_select = 'SELECT CURDATE(), DATE_SUB(CURDATE(), INTERVAL 1 DAY), cur_date, today, yesterday, total FROM ' . $table_name . ' WHERE uri = \'' . $uri . '\'';

    $result = $xoopsDB->query($sql_select);

    $res = [];

    $res['uri'] = $uri;

    if (list(
            $cur_date,
            $yesterday_date,
            $simplecounter_date,
            $simplecounter_today,
            $simplecounter_yesterday,
            $simplecounter_total
        ) = $xoopsDB->fetchRow($result)) {
        if ($cur_date == $simplecounter_date) { // general pattern
            $res['today'] = $simplecounter_today;

            $res['yesterday'] = $simplecounter_yesterday;

            $res['total'] = $simplecounter_total;
        } else { // today's first access
            b_simplecounter_doUpdate($uri, $cur_date);

            $res['today'] = 1;

            if ($simplecounter_date == $yesterday_date) {
                $res['yesterday'] = $simplecounter_today;
            } else {
                $res['yesterday'] = 0;
            }

            $res['total'] = $simplecounter_total + 1;
        }

        b_simplecounter_increment($uri);
    } else { // first url access
        $sql = 'INSERT INTO ' . $table_name . "(uri, cur_date, today, yesterday, total) VALUES('" . $uri . "', CURDATE(), 1, 0, 1 )";

        $xoopsDB->queryF($sql);

        $res['today'] = 1;

        $res['yesterday'] = 0;

        $res['total'] = 1;
    }

    $res['all'] = b_simplecounter_get_total_count();

    return $res;
}

function b_simplecounter_increment($uri)
{
    global $xoopsDB;

    $xoopsDB->queryF('UPDATE ' . $xoopsDB->prefix('simplecounter') . ' SET  today= today+1, total=total+1 WHERE uri = \'' . $uri . '\'');
}

function b_simplecounter_get_total_count()
{
    global $xoopsDB;

    $result = 0;

    if ($res = $xoopsDB->query('select total from ' . $xoopsDB->prefix('simplecounter_total') . ' where cur_date = DATE_SUB(CURDATE(), INTERVAL 1 DAY)')) {
        if (list($total) = $xoopsDB->fetchRow($res)) {
            $result = $total;
        }
    }

    return $result;
}

function b_simplecounter_doUpdate($uri, $date)
{
    global $xoopsDB;

    $table_name = $xoopsDB->prefix('simplecounter');

    // use lock?

    // $xoopsDB->queryF("Lock tables ".$table_name." WRITE");

    $sql_select = 'SELECT *  FROM ' . $table_name . " WHERE uri = '" . $uri . "' and cur_date = '" . $date . "'";

    if (($selResult = $xoopsDB->query($sql_select)) && 0 == ($xoopsDB->getRowsNum($selResult))) {
        $yesterday = 'DATE_SUB(CURDATE(), INTERVAL 1 DAY)';

        // update yesterday access

        $xoopsDB->queryF('update ' . $table_name . ' set yesterday = today, today = 0, cur_date = CURDATE() where cur_date = ' . $yesterday);

        // update before the day before yesterday

        $xoopsDB->queryF('update ' . $table_name . ' set yesterday = 0, today = 0, cur_date = CURDATE() where cur_date != CURDATE() and cur_date != ' . $yesterday);

        // create log by date

        $xoopsDB->queryF('insert into ' . $xoopsDB->prefix('simplecounter_total') . ' select DATE_SUB(CURDATE(), INTERVAL 1 DAY), sum(yesterday), sum(total) from ' . $table_name);
    }

    // $xoopsDB->queryF("Unlock tables");
}

function b_simplecounter_sprit_per_char($num)
{
    $len = mb_strlen($num);

    $result = [];

    for ($i = 0; $i < $len; $i++) {
        $result[$i] = mb_substr($num, $i, 1);
    }

    return $result;
}

function b_simplecounter_show($options)
{
    $block = [];

    $uri = $_SERVER['SCRIPT_NAME'];

    if (!preg_match("/(\/.*)?\.php/", $uri)) {
        $uri .= '.php';
    }

    $res = b_simplecounter_get($uri);

    $result = [];

    $result['uri'] = $res['uri'];

    $result['total'] = $res['total'];

    $result['today'] = $res['today'];

    $result['yesterday'] = $res['yesterday'];

    $result['total_chars'] = b_simplecounter_sprit_per_char($res['total']);

    $result['today_chars'] = b_simplecounter_sprit_per_char($res['today']);

    $result['yesterday_chars'] = b_simplecounter_sprit_per_char($res['yesterday']);

    $result['all'] = $res['all'];

    $result['lang_total'] = _MB_SIMPLECOUNTER_TOTAL;

    $result['lang_today'] = _MB_SIMPLECOUNTER_TODAY;

    $result['lang_yesterday'] = _MB_SIMPLECOUNTER_YESTERDAY;

    $result['lang_all'] = _MB_SIMPLECOUNTER_ALL;

    $result['image_prefix'] = (empty($options[0])) ? XOOPS_URL . '/modules/simplecounter/images/' : $options[0];

    $result['image_suffix'] = (empty($options[1])) ? '' : $options[1];

    $block['simplecounter'][] = $result;

    return $block;
}

function b_simplecounter_edit($options)
{
    $form = "<table width=100% border=0 cellspacing='1'>";

    $form .= "<tr>\n";

    $form .= '<td>' . _MB_SIMPLECOUNTER_IMG_URL . "</td>\n";

    if (empty($options[0])) {
        $options[0] = XOOPS_URL . '/modules/simplecounter/images/';
    }

    $form .= "<td><input type='text' name='options[0]' value='" . $options[0] . "' size='60'>" . _MB_SIMPLECOUNTER_IMG_NUM . "<input type='text' name='options[1]' value='" . $options[1] . "' size='10'></td>\n";

    $form .= "</tr>\n";

    $form .= "</table>\n";

    return $form;
}
