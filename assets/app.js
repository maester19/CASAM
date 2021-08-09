/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// you can specify whith plugins you need
import { Tooltip, Toast, Popover } from 'bootstrap';

import 'bootstrap/dist/js/bootstrap'
import 'popper.js/dist/popper'
import 'chart.js/dist/chart'
import './js/index-charts'
import './js/app'
import './plugins/fontawesome/js/all'
import 'wowjs/dist/wow'
import 'tiny-slider/dist/min/tiny-slider'
import 'glightbox/dist/js/glightbox'
import 'countup.js/dist/countUp'
import 'imagesloaded/imagesloaded'
import 'isotope-layout/js/isotope'


// start the Stimulus application
import './bootstrap';
