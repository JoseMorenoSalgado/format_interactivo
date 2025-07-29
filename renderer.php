<?php
namespace format_interactivo\output;

defined('MOODLE_INTERNAL') || die();

use core_courseformat\output\section_renderer as base_renderer;

class renderer extends base_renderer {

    public function render_course_content($course, $sections, $modinfo) {
        global $PAGE;

        $PAGE->requires->js('/course/format/format_interactivo/libs/swiper.min.js');
        $PAGE->requires->css('/course/format/format_interactivo/libs/swiper.min.css');
        $PAGE->requires->css('/course/format/format_interactivo/styles/format.css');

        $context = [
            'sections' => []
        ];

        foreach ($sections as $sectionnum => $section) {
            if (!$section->uservisible) {
                continue;
            }

            $sectionname = get_section_name($course, $section);
            $context['sections'][] = [
                'name' => $sectionname,
                'summary' => format_text($section->summary, $section->summaryformat),
                'sectionid' => $section->id
            ];
        }

        return $this->render_from_template('format_interactivo/format', $context);
    }
}
