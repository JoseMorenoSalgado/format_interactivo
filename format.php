<?php

defined('MOODLE_INTERNAL') || die();

// En Moodle 4.5, la clase 'format_base' se carga automáticamente.
// No se necesita 'require_once'.

class format_interactivo extends format_base {

    /**
     * Returns the title of the format.
     *
     * @return string The title of the format.
     */
    public function get_format_title() {
        return get_string('formattitle', 'format_interactivo');
    }

    /**
     * Returns the name of the format.
     *
     * @return string The name of the format.
     */
    public function get_format_name() {
        return 'interactivo';
    }

    /**
     * This function is called by the course view page, to print the course content.
     */
    public function print_course_content() {
        global $COURSE;
        $renderer = $this->page->get_renderer('format_interactivo');
        echo $renderer->render_course_content();
    }
}
