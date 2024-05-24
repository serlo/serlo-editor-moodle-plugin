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

if (!defined('MOODLE_INTERNAL')) {
  die('Direct access to this script is forbidden.'); //  It must be included from a Moodle page.
}

require_once $CFG->dirroot . '/course/moodleform_mod.php';

class mod_serlo_mod_form extends moodleform_mod {

  /** @var string|null type */
  protected ?string $type;

  /**
   * Constructor.
   *
   * @param \stdClass $current the current form data.
   * @param string $section the section number.
   * @param \stdClass $cm the course module object.
   * @param \stdClass $course the course object.
   */
  public function __construct($current, $section, $cm, $course) {

    // Setup some of the pieces used to control display in the form definition() method.
    // Type parameter being passed when adding an preconfigured tool from activity chooser.
    $this->type = optional_param('type', null, PARAM_ALPHA);

    parent::__construct($current, $section, $cm, $course);
  }

  /**
   * Define the serlo activity settings form
   */
  public function definition() {
    global $CFG;

    $mform = $this->_form;

    $mform->addElement('header', 'general', get_string('general', 'form'));

    $mform->addElement('text', 'name', get_string('name'), array('size' => '64', 'style' => 'flex: 1;'));
    if (!empty($CFG->formatstringstriptags)) {
      $mform->setType('name', PARAM_TEXT);
    } else {
      $mform->setType('name', PARAM_CLEANHTML);
    }
    $mform->addRule('name', null, 'required', null, 'client');
    $mform->addRule('name', get_string('maximumchars', '', 64), 'maxlength', 64, 'client');

    // Only display the initial content picker if we are creating a new instance
    if (empty($this->current->id)) {
      $selectionItems = [];

      foreach (serlo_get_content_types() as $key => $value) {
        $selectionItems[$key] = $value['title'];
      }

      // TODO: add dropdown to select from a list of template states. This can later be prefilled by query params set by the activity picker
      $mform->addElement(
        'select',
        'type',
        get_string('initialstate', 'mod_serlo'),
        $selectionItems,
        array(
          'data-initial-value' => $this->type ?? array_key_first($selectionItems),
          'style' => 'flex: 1;',
        )
      );
    }

    $this->standard_intro_elements(get_string('intro', 'serlo'));

    $this->standard_coursemodule_elements();

    $this->add_action_buttons();
  }
}
