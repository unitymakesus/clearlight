/** import external dependencies */
import 'jquery';

/** import local dependencies */
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';

/**
 * Web Font Loader
 */
var WebFont = require('webfontloader');

WebFont.load({
 google: {
   families: ['Lato:300,400,700'],
 },
});

/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({
  /** All pages */
  common,
  /** Home page */
  home,
  /** About Us page, note the change from about-us to aboutUs. */
  aboutUs,
});

/** Load Events */
jQuery(document).ready(() => routes.loadEvents());
