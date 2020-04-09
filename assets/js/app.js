/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

//const $ = require('jquery');
const bootstrap = require('bootstrap');
import Vue from 'vue';
import Navigation from './components/Navigation';
import Sidebar from './components/Sidebar';

export { bootstrap, Vue, Navigation, Sidebar };