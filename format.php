<?php
// format_interactivo/format.php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/format/lib.php');

class format_interactivo extends format_base {

    public function uses_sections() {
        return true;
    }

    public function get_section_name($section) {
        if ($section == 0) {
            return get_string('section0name', 'format_interactivo');
        }

        return parent::get_section_name($section);
    }

    public function section_header($section, $course, $onsectionpage, $sectionreturn = null) {
        return parent::section_header($section, $course, $onsectionpage, $sectionreturn);
    }

    public function section_footer() {
        return parent::section_footer();
    }
}
