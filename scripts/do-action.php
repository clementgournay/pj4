<?php

require_once 'config.php';
require_once 'functions.php';

$tasks = json_decode(file_get_contents(DATA_PATH.'/tasks.json'));
$task_id = $argv[1];
$task_id = str_replace("'", "", $task_id);

$x = get_task_index($tasks, $task_id);

$task = $tasks[$x];
$tasks[$x]->in_progress = true;
file_put_contents(DATA_PATH.'/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));

scriptlog('Start task '.$task_id.' ('.$task->action.')', $task);
scriptlog($tasks[$x]->total.' parts for this task', $task);

for ($i = 1; $i <= $tasks[$x]->total; $i++) {
    scriptlog('-------TASK PART '.$i.'-------', $task);
    $ch = curl_init();
    $action_parts = explode('-', $task->action);
    $api_url =  SITE_URL.'/wp-json/wp/v2/'.$task->action.'?task_id='.$task_id.'&part='.$i;
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT    5.0'); 
    switch($action_parts[0]) {
        case 'import':
            scriptlog('[POST] '.$api_url, $task);
            curl_setopt($ch, CURLOPT_POST, 1);
            break;
        case 'update':
            scriptlog('[PUT] '.$api_url, $task);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            break;
    }
    $result = curl_exec($ch);
    $err = curl_errno($ch);
    $errmsg = curl_error($ch);
    curl_close($ch);
    scriptlog('Response: '.$result, $task);
    scriptlog('Error: '.$err.' '.$errmsg, $task);
    $tasks[$x]->progress = $tasks[$x]->progress+1;
    $tasks[$x]->per = ($tasks[$x]->progress * 100) / $tasks[$x]->total;
    $tasks[$x]->per = round($tasks[$x]->per, 2);
    scriptlog('Taskprogress: '.$tasks[$x]->per.'%', $task);
    file_put_contents(DATA_PATH.'/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
}




