<?php

require_once('../../config.php');
require_once('lib.php');


// Make sure this is a legitimate posting

if (!$formdata = data_submitted() or !confirm_sesskey()) {
    throw new \moodle_exception('cannotcallscript');
}

$id = required_param('id', PARAM_INT);    // Course Module ID

if (! $cm = get_coursemodule_from_id('serlo', $id)) {
    throw new \moodle_exception('invalidcoursemodule');
}

if (! $course = $DB->get_record("course", array("id"=>$cm->course))) {
    throw new \moodle_exception('coursemisconf');
}

$PAGE->set_url('/mod/serlo/save.php', array('id'=>$id));
require_login($course, false, $cm);

$context = context_module::instance($cm->id);

if (! $serlo = $DB->get_record("serlo", array("id"=>$cm->instance))) {
    throw new \moodle_exception('invalidid');
}

$PAGE->set_title(get_string("serlosaved"));
$PAGE->set_heading($serlo->name);
echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($serlo->name));

serlo_save_state($serlo, $formdata, $course, $context);

// Print the page and finish up.

notice(get_string("serlo", "serlosaved"), "$CFG->wwwroot/mod/serlo/view.php?id=$course->id");

exit;



