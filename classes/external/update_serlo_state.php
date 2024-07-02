<?php
namespace mod_serlo\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_value;
use context_module;

class update_serlo_state extends external_api {

  /**
   * Returns description of method parameters
   * @return external_function_parameters
   */
  public static function execute_parameters() {
    return new external_function_parameters([
      'serloid' => new external_value(PARAM_INT, 'id of serlo coursemodule'),
      'state' => new external_value(PARAM_TEXT, 'state of serlo editor'),
    ]);
  }

  public static function execute_returns() {
    return new external_value(PARAM_BOOL, 'whether the update was successful or not');
  }

  public static function execute($serloid, $state) {
    global $DB;
    $params = external_api::validate_parameters(self::execute_parameters(), [
      'serloid' => $serloid,
      'state' => $state,
    ]);
    $serloid = $params['serloid'];
    $state = $params['state'];

    // Request and permission validation.
    list ($course, $cm) = get_course_and_cm_from_instance($serloid, 'serlo');

    $context = context_module::instance($cm->id);
    self::validate_context($context);
    require_capability('moodle/category:manage', $context);

    if (!$serlo = $DB->get_record('serlo', array('id' => $cm->instance))) {
      throw new \moodle_exception('invalidid');
    }

    $serlo->state = $state;

    $DB->update_record('serlo', $serlo);

    return true;
  }
}