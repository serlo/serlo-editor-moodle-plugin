<?php
defined('MOODLE_INTERNAL') || die;

$functions = [
  'mod_serlo_get_serlo_state' => [
    'classname'     => 'mod_serlo\external\get_serlo_state',
    'classpath'     => '',
    'description'   => 'Return state of the serlo editor for a given serlo activity.',
    'type'          => 'read',
    'ajax'          => true,
    'services'      => [MOODLE_OFFICIAL_MOBILE_SERVICE],
  ],
  'mod_serlo_update_serlo_state' => [
    'classname'     => 'mod_serlo\external\update_serlo_state',
    'classpath'     => '',
    'description'   => 'Update state of the serlo editor for a given serlo activity.',
    'type'          => 'write',
    'ajax'          => true,
    'services'      => [MOODLE_OFFICIAL_MOBILE_SERVICE],
  ],
];