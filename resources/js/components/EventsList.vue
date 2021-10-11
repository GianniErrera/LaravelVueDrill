<template>
    <div class="border border-red-800">
         <flash-message />
        <!--This displays flash messages after a new event is inserted into database -->
        <div class="border border-red-800">
            <!--Event reminders -->
            <events-reminders />
            <!--Event creation form -->
            <event-form event-published="applyFilters" /> <!-- when a new event is published this event listener trigger a method that refreshes the page -->
        </div>

        <!--Events filters div -->
        <div class="border border-red-800">
            <events-filters
            :filters.sync="filters"
            />
        </div>

        <!-- Events list div -->
        <div class="p-4 border-b border-b-gray-400 rounded-xl">

            <div v-for="event in paginator.data" :key="event.id">

                <!-- Events history for screens larger than medium-->
                <div class="less-than-lg:hidden">
                    <event-high-res :event="event" :filters.sync="filters" />
                </div>
                <!-- End events history for screens larger than medium-->

                <!-- Events history for mobile devices-->
                <div class="lg:hidden border border-2 border-base-900 mb-2">
                    <event-low-res :event="event" />
                </div>
                <!--End events list for mobile devices-->
            </div>
            <!-- Events paginator buttons -->
            <events-pagination
                :page_number.sync="page_number"
                :paginator="paginator"
                @change-page="changePageNumber"
            />

            <!-- End events paginator buttons -->

        </div>
        <!-- End events list div -->
    </div>
</template>

<script>
import Clipboard from 'v-clipboard'

Vue.use(Clipboard)

import Input from '../../../vendor/laravel/breeze/stubs/inertia-vue/resources/js/Components/Input.vue';
import EventsPagination from './EventsPagination.vue';
import EventsReminders from './EventsReminders.vue';
import FlashMessage from './FlashMessage.vue';
import EventHighRes from './EventHighRes.vue';
import EventLowRes from './EventLowRes.vue';
import eventBus from './eventBus';


    export default {
       components: { Input, EventsPagination, EventsReminders, FlashMessage, EventHighRes, EventLowRes },
       data() {
            return {
                filters: {
                    "selected": "date",
                    "search": "",
                    "single_date": "",
                    "start_date": "",
                    "end_date": "",
                    "ignore_year_from_query": false
                },
                filters_string: "",
                number_of_events_per_page: 15,
                paginator: [],
                page_number: 1,
                pagination: {
                    "number": 1
                }
            }
        },
        watch: {
            "filters": {
                handler: 'applyFilters',
                deep: true
            },
            page_number: 'changePageNumber'
        },
        methods: {
            paginateEvents() {
                axios.get(`/events/${this.filters_string}/${this.number_of_events_per_page}/${this.page_number}`).then(response=>this.paginator = response.data);
            },
            applyFilters() {
                this.page_number = 1;
                this.paginateEvents();
            },
            changePageNumber($pageTarget) {
                this.page_number = $pageTarget;
                this.paginateEvents();
            },
        },
        mounted() {
            this.filters_string = JSON.stringify(this.filters);
            this.paginateEvents();

             // adding eventBus listener
            eventBus.$on('change-page', () => {
                console.log('Custom event triggered!')
                })
            },
            beforeDestroy() {
                // removing eventBus listener
                eventBus.$off('change-page')
            }

    }

</script>
