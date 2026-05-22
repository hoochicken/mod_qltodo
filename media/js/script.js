/**
 * mod_qltodo
 *
 * @copyright  Copyright (C) 2026. All rights reserved.
 * @license    GNU General Public License version 2 or later;
 */

((document) => {
    'use strict';

    const initialize = () => {
        const sidebar = document.getElementById('qltodosidebar');
        const overlay = document.getElementById('qltodooverlay');
        const openSidebarBtn = document.getElementById('qltodoopenSidebarBtn');
        const closeSidebarBtn = document.getElementById('qltodocloseSidebarBtn');

        if (!sidebar || !overlay || !openSidebarBtn || !closeSidebarBtn) {
            return;
        }

        const openSidebar = () => {
            sidebar.classList.add('open');
            overlay.classList.add('show');
            openSidebarBtn.classList.add('hide');
        };

        const closeSidebar = () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            openSidebarBtn.classList.remove('hide');
            closePanel();
        };

        openSidebarBtn.addEventListener('click', openSidebar);
        closeSidebarBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });
    };

    const closePanel = async () => {
        try {
            const response = await fetch(
              'index.php?option=com_ajax&module=qltodo&method=informPanelClosed&format=json',
              {
                  method: 'GET',
                  headers: {
                      'Accept': 'application/json'
                  },
                  credentials: 'same-origin'
              }
            );

            if (!response.ok) {
                throw new Error(`Request failed: ${response.status}`);
            }

            const data = await response.json();

            if (data.success) {
                // Success handling here if needed
                // console.log(data.data);
            } else {
                // Error handling here if needed
                // console.error(data.message);
            }
        } catch (error) {
            // Request error handling here if needed
            // console.error(error);
        }
    };

    if (document.readyState !== 'loading') {
        initialize();
    } else {
        document.addEventListener('DOMContentLoaded', initialize);
    }

})(document);