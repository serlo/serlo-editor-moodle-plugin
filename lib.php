<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Library of functions and constants for module serlo
 *
 * @package   mod_serlo
 * @author    Faisal Kaleem <faisal@wizcoders.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will create a new instance and return the id number
 * of the new instance.
 *
 * @global object
 * @param object $serlo
 * @return int
 */
function serlo_add_instance($serlo) {
    global $DB;
    $serlo->timemodified = time();
    $returnid = $DB->insert_record("serlo", $serlo);

    return $returnid;
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @global object
 * @param object $serlo
 * @return bool
 */
function serlo_update_instance($serlo) {
    global $DB;

    $serlo->timemodified = time();
    $serlo->id = $serlo->instance;

    $DB->update_record("serlo", $serlo);
    
    return true;
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @global object
 * @param int $id
 * @return bool
 */
function serlo_delete_instance($id) {
    global $DB;
    if (! $serlo = $DB->get_record('serlo', array('id' => $id))) {
        return false;
    }
    $result = true;
    // Delete any dependent records here.
    if (! $DB->delete_records('serlo', array('id' => $serlo->id))) {
        $result = false;
    }
    
    return $result;
}

/**
 * Serlo cron function that is called from cron_task.php
 * 
 * @global object $CFG
 * @global moodle_database $DB
 */
function serlo_cron() {
    global $CFG, $DB;
    mtrace("This is serlo activity module and doesn't have any logic implemented");
}
