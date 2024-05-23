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
  if (!$serlo = $DB->get_record('serlo', array('id' => $id))) {
    return false;
  }
  $result = true;
  // Delete any dependent records here.
  if (!$DB->delete_records('serlo', array('id' => $serlo->id))) {
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

/**
 * Return the preconfigured tools which are configured for inclusion in the activity picker.
 *
 * @param \core_course\local\entity\content_item $defaultmodulecontentitem reference to the content item for the LTI module.
 * @param \stdClass $user the user object, to use for cap checks if desired.
 * @param stdClass $course the course to scope items to.
 * @return array the array of content items.
 */
function serlo_get_course_content_items(
  \core_course\local\entity\content_item $defaultmodulecontentitem,
  \stdClass $user,
  \stdClass $course
) {
  global $OUTPUT;

  $types = [
    'articleIntroduction' => array('image' => 'multimedia-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'text' => array('image' => 'text-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'image' => array('image' => 'image-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'spoiler' => array('image' => 'spoiler-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'box' => array('image' => 'box-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'serloTable' => array('image' => 'Table-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'injection' => array('image' => 'injection-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'equations' => array('image' => 'equation-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'geogebra' => array('image' => 'geogebra-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'highlight' => array('image' => 'code-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'video' => array('image' => 'video-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'scMcExercise' => array('image' => 'auswahlaufgaben-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'inputExercise' => array('image' => 'fallback-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'h5p' => array('image' => 'fallback-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
    'blanksExercise' => array('image' => 'auswahlaufgaben-icon', 'help' => $defaultmodulecontentitem->get_help() . ''),
  ];

  $items = [];

  foreach ($types as $key => $value) {
    $items[] = new \core_course\local\entity\content_item(
      $defaultmodulecontentitem->get_id() + 1,
      $key,
      new \core_course\local\entity\string_title('Serlo ' . get_string($key, 'mod_serlo')),
      new moodle_url('/course/modedit.php', array("course" => $course->id, "add" => "serlo", "return" => 0, "type" => $key)),
      $OUTPUT->pix_icon($value['image'], '', 'serlo', ['class' => "activityicon nofilter"]),
      $value['help'],
      $defaultmodulecontentitem->get_archetype(),
      $defaultmodulecontentitem->get_component_name(),
      $defaultmodulecontentitem->get_purpose(),
      $defaultmodulecontentitem->is_branded()
    );
  }
  return $items;
  // array(
  //   $defaultmodulecontentitem,
  //   new \core_course\local\entity\content_item(
  //     42,
  //     "Test Item",
  //     new \core_course\local\entity\string_title("Test Item Title"),
  //     new moodle_url('/course/modedit.php', array("course" => $course->id, "add" => "serlo", "return" => 0, "typeid" => 42)),
  //     $OUTPUT->pix_icon('audio-icon', '', 'serlo', ['class' => "activityicon nofilter"]),
  //     $defaultmodulecontentitem->get_help(),
  //     $defaultmodulecontentitem->get_archetype(),
  //     $defaultmodulecontentitem->get_component_name(),
  //     $defaultmodulecontentitem->get_purpose(),
  //     $defaultmodulecontentitem->is_branded()
  //   ),
  // );
}
