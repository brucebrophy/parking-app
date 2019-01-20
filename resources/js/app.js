
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router'
import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);
Vue.use(VueRouter);

import App from './components/App.vue';

import TicketPage from './components/pages/TicketPage.vue';
import PaymentPage from './components/pages/PaymentPage.vue';
import TicketDetailsPage from './components/pages/TicketDetailsPage.vue';
import ThankYouPage from './components/pages/ThankYouPage.vue';
import GoodbyePage from './components/pages/GoodByePage.vue';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'ticket-page',
            component: TicketPage,
        },
        {
            path: '/payment',
            name: 'payment-page',
            component: PaymentPage
        },
        {
            path: '/ticket',
            name: 'ticket-details-page',
            component: TicketDetailsPage
        },
        {
            path: '/thank-you',
            name: 'thank-you-page',
            component: ThankYouPage
        },
        {
            path: '/good-bye',
            name: 'good-bye-page',
            component: GoodbyePage
        },
    ]
});

const app = new Vue({
    el: '#app',
    components: {
        App,
    },
    router
});
