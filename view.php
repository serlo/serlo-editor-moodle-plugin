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
// This page prints a particular instance of serlo.

require(__DIR__ . '/../../config.php');

$id = optional_param('id', 0, PARAM_INT);

if ($id) {
  if (!$cm = get_coursemodule_from_id('serlo', $id)) {
    print_error('invalidcoursemodule');
  }
  if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
    print_error('coursemisconf');
  }
  if (!$serlo = $DB->get_record('serlo', array('id' => $cm->instance))) {
    print_error('invalidid');
  }
}

require_course_login($course, true, $cm);

$context = context_module::instance($cm->id);
$PAGE->set_context($context);

$title = $serlo->name;

// Initialize $PAGE.
$PAGE->set_url('/mod/serlo/view.php', array('id' => $cm->id));
$PAGE->set_title($title);
$PAGE->set_heading($course->fullname);

// Print the page header.
echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($serlo->name), 2);

if ($serlo->intro) {
  echo $OUTPUT->box(format_module_intro('serlo', $serlo, $cm->id), 'generalbox', 'intro');
}

echo $OUTPUT->box_start('generalbox', 'notallowenter');
/* @var moodle_page $PAGE */
if(has_capability('moodle/category:manage', $context) && $PAGE->user_is_editing()) {
    echo '<a href="javascript:;" class="btn btn-primary">Save</a>';
}

echo '<div id="serlo-root">
    <serlo-editor></serlo-editor>
  </div>';

/* @var $PAGE moodle_page */
//$PAGE->requires->js_call_amd('mod_serlo/serlo', 'init', ['serlo-root']);
//$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/serlo/amd/build/serlo.min.js'), true);
echo '<script type="module" src="'.$CFG->wwwroot . '/mod/serlo/amd/build/serlo.min.js"></script>';

echo $OUTPUT->box_end();
echo $OUTPUT->footer();