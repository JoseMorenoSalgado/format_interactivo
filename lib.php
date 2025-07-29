<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Loads CSS and JS resources needed for the format.
 *
 * @param stdClass $course The course object.
 */
function format_interactivo_before_course_content($course) {
    global $PAGE;

    // Cargar Tailwind CSS desde CDN.
    $PAGE->requires->css('https://cdn.tailwindcss.com');

    // Cargar la fuente Inter desde Google Fonts.
    $PAGE->requires->css('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    // Cargar nuestro archivo CSS personalizado.
    $PAGE->requires->css(new moodle_url('/course/format/interactivo/styles/main.css'));

    // Cargar nuestro archivo JavaScript.
    $PAGE->requires->js(new moodle_url('/course/format/interactivo/javascript/main.js'));

    // Añade una clase al body para que nuestros estilos CSS no afecten a otras partes de Moodle.
    $PAGE->add_body_class('format-interactivo');
}
