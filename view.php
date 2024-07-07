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
 * Version information
 *
 * @package   mod_serlo
 * @author    Name <name@example.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require __DIR__ . '/../../config.php';

$id = optional_param('id', 0, PARAM_INT);

if (!$id) {
  throw new moodle_exception('invalidcoursemodule');
}

$cm = get_coursemodule_from_id('serlo', $id);

if (!$cm) {
  throw new moodle_exception('invalidcoursemodule');
}
if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
  throw new moodle_exception('coursemisconf');
}
if (!$serlo = $DB->get_record('serlo', array('id' => $cm->instance))) {
  throw new moodle_exception('invalidserloid', 'serlo');
}

require_course_login($course, true, $cm);

$context = context_module::instance($cm->id);
$PAGE->set_context($context);

$title = $serlo->name;

// Initialize $PAGE.
$PAGE->set_url('/mod/serlo/view.php', array('id' => $cm->id));
$PAGE->set_title($title);
$PAGE->set_heading($course->fullname);

$modes = array(
  true => "write",
  false => "read",
);

if (isset($_SERVER['HTTP_USER_AGENT']) && strlen(strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox')) > 0) {
  \core\notification::warning(get_string('firefox_warning', 'mod_serlo'));
}

$editor_attrs = [];
if ($PAGE->user_is_editing()) {
  $editor_attrs['mode'] = "write";
  $editor_attrs['testing-secret'] = get_config('serlo', 'editor_secret');
} else {
  $editor_attrs['mode'] = "read";
}

$str_attrs = "";
array_walk($editor_attrs, function ($value, $key) use (&$str_attrs) {
  $str_attrs .= $key . '="' . $value . '" ';
});

// Print the page header.
echo $OUTPUT->header();

if ($serlo->intro) {
  echo $OUTPUT->box(format_module_intro('serlo', $serlo, $cm->id), 'generalbox', 'intro');
}

echo $OUTPUT->box_start('generalbox', 'notallowenter');

if (has_capability('moodle/category:manage', $context) && $PAGE->user_is_editing()) {
  echo '<div class="serlo save-wrapper">';
  echo '<a href="#" id="mod_serlo_save" class="btn btn-primary disabled">' . get_string("save") . '</a>';
  echo '</div>';
}

echo '<div id="serlo-root">
    <div class="serlo loader-wrapper"></div>
    <serlo-editor class="hidden" ' . $str_attrs . '></serlo-editor>
  </div>';

$PAGE->requires->js_call_amd('mod_serlo/serlo-lazy', 'init', array($serlo->id));

echo $OUTPUT->box_end();
echo $OUTPUT->footer();
