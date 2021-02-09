/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueResource from 'vue-resource'
import Vodal from 'vodal';
import "vodal/common.css";
import "vodal/door.css";

// chartjs package
import "chart.js/dist/Chart.bundle.js"

// vue-charts package
require('hchs-vue-charts');
require('vue2-dropzone');
Vue.use(VueCharts);

Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import {Tabs, Tab} from 'vue-tabs-component';

Vue.component('tabs', Tabs);
Vue.component('tab', Tab);
Vue.component(Vodal.name, Vodal);
Vue.component('grid', require('./components/Grid.vue'));
Vue.component('location_grid', require('./components/ProductLocation.vue'));
Vue.component('date', require('./components/datepicker.vue'));
Vue.component('prod', require('./components/Select2Prod.vue'));
Vue.component('locs_list', require('./components/Select2Locs.vue'));
Vue.component('select2', require('./components/Select2.vue'));
Vue.component('item', require('./components/TRComponent.vue'));
Vue.component('item-location', require('./components/TRLocationComponent.vue'));
Vue.component('vtable', require('./components/Table.vue'));
Vue.component('upload', require('./components/ProductUpload.vue'));
Vue.component('avatarupload', require('./components/AvatarUpload.vue'));


