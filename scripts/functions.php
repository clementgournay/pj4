<?php

require_once 'config.php';

function scriptlog($message, $task) {
	date_default_timezone_set('Europe/Paris');
	if (!is_dir(LOG_PATH)) mkdir(LOG_PATH);
	$year_path = LOG_PATH.'/'.date('Y');
	if (!is_dir($year_path)) mkdir($year_path);
	$month_path = $year_path.'/'.date('m');
	if (!is_dir($month_path)) mkdir($month_path);
	$log_path = $month_path.'/'.date('d').'.log';
    $str = ($task) ? date('d/m/Y H:i:s').' ['.$task->id.' '.$task->action.'] '.$message : date('d/m/Y H:i:s').' '.$message;
    echo  $str.'<br>';
    file_put_contents($log_path, $str.'\r\n', FILE_APPEND | LOCK_EX);
}

function get_task_index($tasks, $task_id) {
    $i = 0; $found = false;
    while(!$found && $i < count($tasks)) {
        if ($tasks[$i]->id == $task_id) $found = true;
        else $i++;
    }
    return ($found) ? $i : -1;
}
