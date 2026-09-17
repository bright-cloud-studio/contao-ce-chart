/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Chart
 * @license    MIT
 * @see        https://github.com/bright-cloud-studio/contao-ce-chart
 */

(function () {
    'use strict';

    // Build every chart whose configuration was rendered next to its canvas
    function init() {
        var configs = document.querySelectorAll('script[data-bcs-chart]');

        for (var i = 0; i < configs.length; i++) {
            var canvas = document.getElementById(configs[i].getAttribute('data-bcs-chart'));

            if (canvas) {
                new Chart(canvas, JSON.parse(configs[i].textContent));
            }
        }
    }

    // This file loads in the <head>, so wait for the canvases to exist
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
