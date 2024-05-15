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
 * Plugin administration pages are defined here.
 *
 * @package   mod_serlo
 * @category  admin
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

$settings_modserlo = new admin_settingpage('modserlosettingspage', new lang_string('settings'));

if ($ADMIN->fulltree) {
    $settings_modserlo->add(new admin_setting_configselect('mod_serlo_option', 'Option', 'Select one from the options', 'opt1',
        array("opt1" => "Option 1", "opt2" => 'Options 2', "opt3" => 'Options 3')));
}

$ADMIN->add('modsettings', new admin_category('modsettingsserlocat', 
            get_string('pluginname', 'mod_serlo'), $module->is_enabled() === false));
    
$ADMIN->add('modsettingsserlocat', $settings_modserlo);

//$external_page = new admin_externalpage('modserloexternal', 'External page',
//        new moodle_url('/mod/serlo/external.php'),
//        'moodle/site:config');
//$ADMIN->add('modsettingsserlocat', $external_page);

$settings = null; // We do not want standard settings link.
