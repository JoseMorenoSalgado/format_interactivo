// Espera a que el DOM esté completamente cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Busca el contenedor principal del formato para asegurar que el script solo se ejecute en la página correcta.
    const courseContainer = document.querySelector('.format-interactivo .course-container');
    if (!courseContainer) {
        return; // Si no encuentra el contenedor, no hace nada.
    }

    const sectionHeaders = courseContainer.querySelectorAll('.section-header');

    sectionHeaders.forEach(header => {
        header.addEventListener('click', function () {
            const content = this.nextElementSibling;
            const icon = this.querySelector('svg');

            // Verifica si el panel que se clickeó ya está abierto.
            const isAlreadyOpen = content.style.maxHeight;

            // Cierra todos los paneles.
            sectionHeaders.forEach(otherHeader => {
                otherHeader.nextElementSibling.style.maxHeight = null;
                otherHeader.querySelector('svg').style.transform = 'rotate(0deg)';
                otherHeader.classList.remove('active');
            });

            // Si el panel no estaba abierto, ábrelo.
            if (!isAlreadyOpen) {
                this.classList.add('active');
                content.style.maxHeight = content.scrollHeight + "px";
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
    
    // Simula la apertura del módulo activo (el que corresponde a la sección actual).
    const activeSectionHeader = courseContainer.querySelector('.section-header.active');
    if (activeSectionHeader) {
        const content = activeSectionHeader.nextElementSibling;
        const icon = activeSectionHeader.querySelector('svg');
        content.style.maxHeight = content.scrollHeight + "px";
        icon.style.transform = 'rotate(180deg)';
    }
});
