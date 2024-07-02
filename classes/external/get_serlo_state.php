<?php
namespace mod_serlo\external;

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_value;
use context_module;

class get_serlo_state extends external_api {

  /**
   * Returns description of method parameters
   * @return external_function_parameters
   */
  public static function execute_parameters() {
    return new external_function_parameters([
      'serloid' => new external_value(PARAM_INT, 'id of serlo coursemodule'),
    ]);
  }

  public static function execute_returns() {
    return new external_value(PARAM_TEXT, 'stringified JSON representation of serlo state');
  }

  public static function execute($serloid) {
    global $DB;
    $params = external_api::validate_parameters(self::execute_parameters(), [
      'serloid' => $serloid,
    ]);
    $serloid = $params['serloid'];

    // Request and permission validation.
    list ($course, $cm) = get_course_and_cm_from_instance($serloid, 'serlo');

    $context = context_module::instance($cm->id);
    self::validate_context($context);

    if (!$serlo = $DB->get_record('serlo', array('id' => $cm->instance))) {
      throw new \moodle_exception('invalidid');
    }

    return $serlo->state;
  }
}