/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//js jquery.scrollbar
require('jquery.scrollbar');
require('select2');

// jQuery(document).ready(function(){
//     jQuery('.scrollbar-macosx').scrollbar();
// });


window.Vue = require('vue');

import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

//bootstrap vue
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

import { LayoutPlugin } from 'bootstrap-vue'
Vue.use(LayoutPlugin)

import { ModalPlugin } from 'bootstrap-vue'
Vue.use(ModalPlugin)

import { FormFilePlugin } from 'bootstrap-vue'
Vue.use(FormFilePlugin)

import { BFormFile } from 'bootstrap-vue'
Vue.component('b-form-file', BFormFile)

import { CardPlugin } from 'bootstrap-vue'
Vue.use(CardPlugin)

import { VBScrollspyPlugin } from 'bootstrap-vue'
Vue.use(VBScrollspyPlugin)

import { DropdownPlugin, TablePlugin } from 'bootstrap-vue'
Vue.use(DropdownPlugin)
Vue.use(TablePlugin)

import 'popper.js';
import 'tooltip.js';

//vue shortkey
Vue.use(require('vue-shortkey'));
//vue print
// import VueHtmlToPaper from 'vue-html-to-paper';
// const options = {
//     name: '_blank',
//     specs: [
//         'fullscreen=yes',
//         'titlebar=yes',
//         'scrollbars=yes'
//     ],
//     styles: [
//         // 'http://sikujang.rsudcibinong.com/public/css/app.css'
//         // '../public/css/app.css'
//         'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css',
//         // 'https://unpkg.com/kidlat-css/css/kidlat.css'
//     ]
//   }
// Vue.use(VueHtmlToPaper);

//export excel
import JsonExcel from "vue-json-excel";
Vue.component("downloadExcel", JsonExcel);


import moment from "moment";
import 'moment/locale/id';
import {Form, HasError, AlertError} from 'vform';

import Vue from 'vue';
//vuetify
import Vuetify from 'vuetify';
Vue.use(Vuetify);

// import DaySpanVuetify from 'dayspan-vuetify'
// Vue.use(DaySpanVuetify, {
    // methods: {
    //   getDefaultEventColor: () => '#1976d2'
    // }
// });

import colors from 'vuetify/lib/util/colors';

import SmartTable from 'vuejs-smart-table'
Vue.use(SmartTable);

// import VCalendar from 'v-calendar'
// Vue.use(VCalendar);

//Select mantull
import { SelectPage } from 'v-selectpage'
Vue.component('v-selectpage', SelectPage);

// import modelSelect from 'vue-search-select'
import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect);

import Treeselect from '@riophae/vue-treeselect'
Vue.component('treeselect', Treeselect);

//portal vue
import PortalVue from 'portal-vue'
Vue.use(PortalVue)

//jsnice scroll
import niceScroll from 'jquery.nicescroll';
Vue.use(niceScroll);

// js custom file input
import bsCustomFileInput from "./bs-custom-file-input";
$(document).ready(function () {
    bsCustomFileInput.init();
  });

var $th = $('.tableFixHead').find('thead th')
    $('.tableFixHead').on('scroll', function() {
    $th.css('transform', 'translateY('+ this.scrollTop +'px)');
    });

//Gate Auth
import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

Vue.mixin(require('./path'));
import Asset from "./Asset";
Vue.prototype.$asset = new Asset(window.asset);

//filter text and date
Vue.filter('uptext', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});
Vue.filter('myDate', function(created){
    return moment(created).format('dddd, Do MMMM YYYY, HH:mm');
});

Vue.filter('bulanTahun', function(created){
    return moment(created).format('MMMM YYYY');
});
Vue.filter('tanggal', function(created){
    return moment(created).format('dddd, Do MMMM YYYY');
});
Vue.filter('dmy', function(created){
    return moment(created).format('Do MMMM YYYY');
});
Vue.filter('jamMenit', function(text){
    return moment(text).format('HH:mm');
});
Vue.filter('masabakti', function(tmt){
    return moment(tmt).fromNow(true);
});
// Vue.filter('sejak', function(tmt){
//     var start = moment(tmt);
//     var end = moment().startOf('day');
//     var m = Math.round(moment.duration(end - start).asMonths());
//     // var d = Math.round(moment.duration(end - m).asDays());
//     return m ;
// });

window.Fire = new Vue();

//sweetalert2 setting
import Swal from 'sweetalert2'
window.Swal = Swal;

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.toast = toast;
window.action = new Vue();

//vform validation
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

//progressbar
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(15, 85, 0)',
  failedColor: 'red',
  thickness: '8px',
})

//VueRouter
import VueRouter from 'vue-router'
import asset from './Asset';
Vue.use(VueRouter)

//routing Vue
let routes = [
    // { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default, meta: {title: 'Profile | SiKujang'} },
    { path: '/detail', component: require('./components/ProfileDetail.vue').default, meta: {title: 'Detail | SiKujang'} },
    // { path: '/users', component: require('./components/Users.vue').default },
    { path: '/pegawai', component: require('./components/Pegawai.vue').default, meta: {title: 'Pegawai | SiKujang'}},
    { path: '/cek', component: require('./components/ExampleComponent.vue').default },
    { path: '/home', component: require('./components/Dashboard.vue').default, meta: {title: 'Home | SiKujang'} },

    { path: '/table', component: require('./components/Table.vue').default },
    { path: '/passport', component: require('./components/Passport.vue').default, meta: {title: 'Passport | SiKujang'} },
    { path: '/settings', component: require('./components/Setting.vue').default, meta: {title: 'Setting | SiKujang'} },
    { path: '/position', component: require('./components/masterdata/Jabatan.vue').default, meta: {title: 'Jabatan | SiKujang'} },
    { path: '/unit', component: require('./components/masterdata/Unit.vue').default, meta: {title: 'Unit | SiKujang'} },
    { path: '/tupoksi-jft', component: require('./components/masterdata/TupoksiJFT.vue').default, meta: {title: 'Tupoksi JFT | SiKujang'} },
    { path: '/tupoksi-jfu', component: require('./components/masterdata/TupoksiJFU.vue').default, meta: {title: 'Tupoksi JFU | SiKujang'} },
    { path: '/shift', component: require('./components/masterdata/Shift.vue').default, meta: {title: 'Shift | SiKujang'} },
    { path: '/jadwalshift', component: require('./components/userstuff/JadwalShift.vue').default, meta: {title: 'Jadwal Shift | SiKujang'} },
    { path: '/activities', component: require('./components/userstuff/Activities.vue').default, meta: {title: 'Activities | SiKujang'} },
    { path: '/user-activities', component: require('./components/UserActivities.vue').default, meta: {title: 'Kegiatan Pegawai | SiKujang'} },
    // { path: '/skp-tahunan', component: require('./components/userstuff/SkpTahunan.vue').default, meta: {title: 'SKP Tahunan | SiKujang'} },
    { path: '/laporan-bulanan', component: require('./components/userstuff/Report.vue').default, meta: {title: 'Laporan Bulanan | SiKujang'} },
    { path: '/laporan-pegawai', component: require('./components/executive/CheckReport.vue').default, meta: {title: 'Laporan Pegawai | SiKujang'} },
    { path: '/laporan-pegawai-keuangan', component: require('./components/executive/CheckReportKeuangan.vue').default, meta: {title: 'Laporan Pegawai | SiKujang'} },
    // { path: '/checkinout', component: require('./components/Finger.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default, meta: {title: '404 Not Found' } },
    // { path: '*', redirect: '/404' },
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('sidebar-menu', require('./components/template/Sidebar.vue').default);
Vue.component('user-avatar', require('./components/template/userAvatar.vue').default);
Vue.component('greeting-comp', require('./components/template/Greeting.vue').default);

Vue.component('passport-clients', require('./components/passport/Clients.vue').default);

Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue').default);

Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue').default);

Vue.component('search-comp', require('./components/Search').default);
// 404 Not found page
Vue.component('not-found', require('./components/NotFound.vue').default);
Vue.component('not-found-page', require('./components/NotFoundPage.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const vuetifyy = new Vuetify({
    theme: {
      themes: {
        light: {
          primary: '#39af21',
        //   secondary: '#b0bec5',
          accent: '#39af21',
        //   error: '#b71c1c',
        },
      },
    },
  })

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    router,
    data:{
        meta : { title : 'test'},
        search: '',
        userLogin: [],
        pns: '',

    },
    methods:{
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        }, 500),
        loadUserLogin(){
            axios.get("api/userlogin").then((data) => (this.userLogin = data.data[0], this.pns = data.data[1]));
        },
    },
    created(){
        this.loadUserLogin();
        Fire.$on('refreshUser', () => {
            Fire.$emit('refreshAvatar');
            this.loadUserLogin();
        });
    },
    updated(){
        if (this.$vuetify.breakpoint.width >= 600) {
            $(function() {
                $("body").getNiceScroll().resize();
                $("body").niceScroll({
                    cursorcolor:"#004E1E",
                    background:"rgba(20,20,20,0.3)",
                    cursorborder:"0px",
                    cursorborderradius:0,
                    cursorwidth:"7px"});
                $('.scrollbar-macosx').scrollbar();
            });
        }else{
            $(function() {
                $("body").getNiceScroll().resize();
                $("body").niceScroll({
                    cursorborder:"0px",
                    cursorcolor:"rgba(20,20,20,0)"});
                $('.scrollbar-macosx').scrollbar();
            });
        }
    },
    watch: {
        '$route' (to, from) {
            document.title = to.meta.title ;
        }
      },
});
