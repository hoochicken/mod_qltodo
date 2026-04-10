/**
 * mod_qltodo
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

((document, Joomla) => {
    'use strict';

    /**
     * Module initialization
     */
    const initialize = () => {
        const sidebar = document.getElementById('qltodosidebar');
        const overlay = document.getElementById('qltodooverlay');
        const openSidebarBtn = document.getElementById('qltodoopenSidebarBtn');
        const closeSidebarBtn = document.getElementById('qltodocloseSidebarBtn');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('show');
            openSidebarBtn.classList.add('hide');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            openSidebarBtn.classList.remove('hide');
        }

        openSidebarBtn.addEventListener('click', openSidebar);
        closeSidebarBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });
    };

    // Initialize when the document is ready
    if (document.readyState !== 'loading') {
        initialize();
    } else {
        document.addEventListener('DOMContentLoaded', initialize);
    }

    // Add to Joomla API if needed
    // Joomla.Modules = Joomla.Modules || {};
    // Joomla.Modules.mod_qltodo = {
    //     // Your public API methods here
    // };

})(document, Joomla);
