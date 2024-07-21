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
 * DB Services code for the serlo activity
 *
 * @package   mod_serlo
 * @author    Faisal Kaleem <faisal@wizcoders.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2024 Faisal Kaleem (http://wizcoders.com)
 */

defined('MOODLE_INTERNAL') || die;

$functions = [
    'mod_serlo_get_serlo_state' => [
        'classname' => 'mod_serlo\external\get_serlo_state',
        'classpath' => '',
        'description' => 'Return state of the serlo editor for a given serlo activity.',
        'type' => 'read',
        'ajax' => true,
        'services' => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    'mod_serlo_update_serlo_state' => [
        'classname' => 'mod_serlo\external\update_serlo_state',
        'classpath' => '',
        'description' => 'Update state of the serlo editor for a given serlo activity.',
        'type' => 'write',
        'ajax' => true,
        'services' => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
];
