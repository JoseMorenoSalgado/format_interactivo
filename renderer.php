<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/renderer.php');

class format_interactivo_renderer extends format_renderer_base {

    /**
     * The main function to render the course page.
     *
     * @return string HTML output.
     */
    public function render_course_content() {
        global $COURSE;

        $sections = $this->format->get_sections();
        $modinfo = get_fast_modinfo($COURSE)->get_cms();

        ob_start();
        ?>
        <div class="course-container format-interactivo">
            <!-- Columna Izquierda: Contenido Principal -->
            <main class="main-content">
                <div>
                    <?php
                    // Muestra el resumen de la sección 0 (sección general del curso).
                    $section_summary = $this->format->get_section_summary(0);
                    echo $this->render_main_content_placeholder($section_summary);
                    ?>
                </div>
                <nav class="bottom-nav">
                    <a href="#" class="text-gray-600 hover:text-blue-600">&lt; Anterior</a>
                    <a href="#" class="nav-button">Siguiente Actividad &gt;</a>
                </nav>
            </main>

            <!-- Columna Derecha: Navegación del Curso -->
            <aside class="sidebar">
                <div class="sidebar-header">
                    <h2 class="text-xl font-bold text-gray-800"><?php echo $this->page->course->fullname; ?></h2>
                    <div class="sidebar-tabs">
                        <button class="active">Contenido</button>
                        <button>Programa</button>
                        <button>En Línea</button>
                    </div>
                </div>
                
                <?php echo $this->render_progress_bar(); ?>

                <div class="course-navigation">
                    <?php
                    foreach ($sections as $section) {
                        if (!$section->uservisible || !$this->format->section_has_content($section)) {
                            continue;
                        }
                        echo $this->render_section($section, $modinfo);
                    }
                    ?>
                </div>
            </aside>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Renders a single section in the sidebar.
     *
     * @param stdClass $section The section object.
     * @param array $modinfo The course module info.
     * @return string HTML for one section.
     */
    protected function render_section($section, $modinfo) {
        $iscurrent = $this->format->is_current_section($section);
        $sectionmods = $modinfo[$section->section];

        ob_start();
        ?>
        <div class="section-item">
            <div class="section-header <?php echo $iscurrent ? 'active' : ''; ?>">
                <span class="font-semibold"><?php echo $this->format->get_section_name($section); ?></span>
                <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
            <div class="section-content">
                <?php
                foreach ($sectionmods as $mod) {
                    if (!$mod->uservisible) {
                        continue;
                    }
                    $completiondata = new \core_completion\cm_completion_details($mod, null, $this->page->user->id);
                    $is_completed = $completiondata->is_complete();
                    ?>
                    <a href="<?php echo $mod->url; ?>" class="activity-item <?php echo $is_completed ? 'completed' : ''; ?>">
                        <input type="checkbox" <?php echo $is_completed ? 'checked' : ''; ?> class="mr-3" onclick="return false;">
                        <span class="activity-title text-sm"><?php echo $mod->name; ?></span>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Renders the main content area.
     *
     * @param string $summary The summary of the section to display.
     * @return string HTML for the main content.
     */
    protected function render_main_content_placeholder($summary) {
        ob_start();
        ?>
        <img src="https://placehold.co/800x450/e0f2fe/3b82f6?text=Contenido+Interactivo" alt="Imagen de contenido" class="content-image">
        <div class="content-pagination">
            <button class="text-gray-500 hover:text-gray-800">&lt;</button>
            <span class="font-medium text-gray-700">1 / 4</span>
            <button class="text-gray-500 hover:text-gray-800">&gt;</button>
        </div>
        <div class="text-center">
            <?php
            // Muestra el resumen de la sección general del curso.
            // Puedes cambiar esto para mostrar el contenido de la actividad actual.
            echo format_text($summary->summary, $summary->summaryformat, ['context' => context_course::instance($this->page->course->id)]);
            ?>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Renders the course progress bar.
     *
     * @return string HTML for the progress bar.
     */
    protected function render_progress_bar() {
        $completion = new \core_completion\progress($this->page->course, $this->page->user->id);
        $percentage = $completion->get_progress_percentage();

        ob_start();
        ?>
        <div class="progress-bar mb-4">
            <div class="flex justify-between mb-1">
                <span class="text-sm font-medium text-gray-700">Progreso del curso</span>
                <span class="text-sm font-medium text-blue-700"><?php echo round($percentage); ?>%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo $percentage; ?>%"></div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
