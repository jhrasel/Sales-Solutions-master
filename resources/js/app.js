import SupportTicketDetails from "./components/SupportTicketDetails";

window.axios = require('axios');
import   { createApp } from 'vue'


// Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


import Merchants from "./components/Merchants.vue";
import SupportTicket from "./components/SupportTicket.vue";
import SupportTicketList from "./components/SupportTicketList.vue";
import Themes from "./components/Themes.vue";
import Modal from "./components/Modal.vue";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = createApp({})
app.component('merchants', Merchants)
app.component('support-ticket', SupportTicket)
app.component('support-ticket-list', SupportTicketList)
app.component('support-ticket-details', SupportTicketDetails)
app.component('themes', Themes)
app.component('modal', Modal)
app.mount('#app')
