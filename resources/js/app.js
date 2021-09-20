require('./bootstrap');

require('alpinejs');

import Litepicker from 'litepicker';
import ClipboardJS from 'clipboard';



window.Vue = require('vue').default;

window.Bus = new Vue();

window.sourceOfTruth = {"date": "test"};


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('event-form', require('./components/EventForm.vue').default);
Vue.component('events-filters', require('./components/EventsFilters.vue').default);
Vue.component('events-list', require('./components/EventsList.vue').default);
Vue.component('events-pagination', require('./components/EventsPagination.vue').default);
Vue.component('events-reminders', require('./components/EventsReminders.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('flash-message', require('./components/FlashMessage.vue').default);
Vue.component('main-component', require('./components/MainComponent.vue').default);
Vue.component('pagination-button', require('./components/PaginationButton.vue').default);





/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/* Vue.component('task-list', {
    template: <div><task v-for="task in tasks">{{task.task}}</task></div>,

    data() {
        return {
            tasks: [
                { description: "Go to the store", completed: true },
                { description: "Demonstrate", completed: true },
                { description: "Jogging session", completed: true },
                { description: "Go to the pub", completed: false },
                { description: "Lunch break", completed: true },
                { description: "Phone to Giovanni", completed: false },
            ]
        }
    }

}); */

 Vue.component('task', {
    template: `<li><slot></slot></li>`
});

new Vue({
    el: '#app',

    mounted() {
        console.log("I'm working");
    }
})
