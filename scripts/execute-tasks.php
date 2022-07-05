<?php

require_once 'config.php';
require_once 'functions.php';

ini_set('max_execution_time', 0);

$tasks = json_decode(file_get_contents(DATA_PATH.'/tasks.json'));
$done_tasks = json_decode(file_get_contents(DATA_PATH.'/done.json'));

scriptlog('Check for tasks...', null);

$task_in_progress = false; 
$i = 0;
while (!$task_in_progress && $i < count($tasks)) {
    if ($tasks[$i]->in_progress) $task_in_progress = true;
    else $i++;
}

if (!$task_in_progress && count($tasks) > 0) {
    scriptlog('==========TASKSTART==========', null);
    scriptlog('Task found.', null);
    $task = $tasks[0];
    scriptlog('Start action...', $task);
    $taskID = escapeshellarg($task->id);
    $action = escapeshellarg($task->action);
    $return = shell_exec('php '.SCRIPT_PATH.'/do-action.php "'.$taskID.'" "'.$action.'"');
    scriptlog('Action result: '.$return, $task);
    array_push($done_tasks, $task);
    array_shift($tasks);
    file_put_contents(DATA_PATH.'/done.json', json_encode($done_tasks, JSON_PRETTY_PRINT));
    file_put_contents(DATA_PATH.'/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
    scriptlog('Remove json parts...', $task);
    for ($x = 1; $x <= $task->total; $x++) {
        unlink(DATA_PATH.'/'.$task->id.'/part-'.$x.'.json');
    }
    scriptlog('Json parts removed.', $task);
    scriptlog('Remove task folder...', $task);
    rmdir('../data/'.$task->id);
    scriptlog('Task folder removed.', $task);
    scriptlog('===========TASKEND===========', null);
} else {
    if ($task_in_progress) scriptlog('Task in progress, wait for finish.', null);
    else if (count($tasks) === 0) scriptlog('No tasks to process.', null);
}