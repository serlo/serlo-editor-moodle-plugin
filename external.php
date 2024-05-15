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

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');

$context = context_system::instance();
require_capability('moodle/site:config', $context);

/* Required for external settings page for the plugin */
admin_externalpage_setup('modserloexternal');

// See if any action was requested.
$id = optional_param('id', 0, PARAM_INT);

echo $OUTPUT->header();
echo html_writer::tag('h2', 'External settings page for serlo ');
echo $OUTPUT->footer();
