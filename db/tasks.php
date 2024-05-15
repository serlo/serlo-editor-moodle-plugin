<?php
/**
 * Definition of serlo cron tasks.
 *
 * @package   mod_serlo
 * @author    Faisal Kaleem <faisal@wizcoders.com>
 * @category  task
 */

defined('MOODLE_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => 'mod_serlo\task\cron_task',
        'blocking' => 0,
        'minute' => '*',
        'hour' => '*',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*'
    )
);