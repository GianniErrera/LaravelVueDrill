<template>
    <div class="border border-red-800">
         <flash-message />
        <!--This displays flash messages after a new event is inserted into database -->
        <div class="border border-red-800">
            <!--Event reminders -->
            <events-reminders />
            <!--Event creation form -->
            <event-form v-on:event-published="applyFilters" /> <!-- when a new event is published this event listener trigger a method that refreshes the page -->
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
            <div class="flex mt-4 justify-center">
                <div class="btn-group flex-nowrap mx-auto">
                    <button
                        @click="jumpToPage(1)"
                        class="btn btn-sm cursor rounded-lg"
                        :disabled="isPreviousButtonDisabled"
                    >
                        {{this.$options.static.first_button}}

                    </button>
                    <button
                        @click="previousPage"
                        class="btn btn-sm cursor rounded-lg"
                        :disabled="isPreviousButtonDisabled"
                    >
                        {{this.$options.static.prev_button}}
                    </button>
                    <!--This is shown only when on last page -->
                    <button
                        class="btn btn-sm cursor"
                        v-show="paginator.last_page === 3 && page_number === 3 || paginator.last_page > 3 && page_number === paginator.last_page"
                        @click="jumpToPage(page_number - 2)">
                    {{ page_number - 2 }}
                    </button>
                    <!--This is shown only when on last two pages -->
                    <button
                        class="btn btn-sm cursor"
                        v-show="paginator.last_page < 3 && page_number === 2 || (paginator.last_page >= 3 && page_number >= 2)"
                        @click="jumpToPage(page_number - 1)">
                    {{ page_number - 1 }}
                    </button>
                    <button
                    class="btn btn-sm"
                    disabled
                    >
                    {{ page_number }}
                    </button>
                    <button
                        class="btn btn-sm cursor"
                        v-show="page_number + 1 <= paginator.last_page"
                        @click="jumpToPage(page_number + 1)">
                    {{ page_number + 1 }}
                    </button>
                    <button
                        class="btn btn-sm cursor"
                        v-show="page_number === 1 && page_number + 2 <= paginator.last_page"
                        @click="jumpToPage(page_number + 2)">
                    {{ page_number + 2 }}
                    </button>
                    <button
                        @click="nextPage"
                        class="btn btn-sm cursor"
                        :disabled="isNextButtonDisabled"
                        >
                        <!--This is just the "<" character -->
                        >
                    </button>
                    <button
                        @click="jumpToPage(paginator.last_page)"
                        class="btn btn-sm cursor"
                        :disabled="isNextButtonDisabled"
                        >
                        <!--This is just the "<<" character -->
                        >>
                    </button>
                </div>
            </div>
            <!-- End events paginator buttons -->
        </div>
        <!-- End events list div -->
    </div>
</template>

<script>
import Clipboard from 'v-clipboard'

Vue.use(Clipboard)

import Input from '../../../vendor/laravel/breeze/stubs/inertia-vue/resources/js/Components/Input.vue';
import EventsReminders from './EventsReminders.vue';
import FlashMessage from './FlashMessage.vue';
import EventHighRes from './EventHighRes.vue';
import EventLowRes from './EventLowRes.vue';
    const buttonLabels = {
        first: "<<",
        prev: "<",
        next: ">",
        last: ">>"
    };

    export default {
       components: { Input, EventsReminders, FlashMessage, EventHighRes, EventLowRes },
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
                page_number: 1
            }
        },
        static: {
            first_button: "<<", // these two strings are used as "<" symbol may be interpreted as first character of tag
            prev_button: "<"
        },
        watch: {
            "filters": {
                handler: 'applyFilters',
                deep: true
            }
        },
        methods: {
            applyFilters() {
                this.page_number = 1;
                this.filters_string = JSON.stringify(this.filters);
                axios.get(`/events/${this.filters_string}/${this.number_of_events_per_page}/${this.page_number}`).then(response=>this.paginator = response.data);
            },
            changePageNumber() {
                axios.get(`/events/${this.filters_string}/${this.number_of_events_per_page}/${this.page_number}`).then(response=>this.paginator = response.data);
            },
            nextPage() {
                this.page_number += 1;
                this.changePageNumber();
            },
            previousPage() {
                this.page_number -= 1;
                this.changePageNumber();
            },
            firstPage() {
                this.page_number = 1;
                this.changePageNumber();
            },
            lastPage() {
                this.page_number = this.paginator.last_page;
                this.changePageNumber();
            },
            jumpToPage($pageTarget) {
                this.page_number = $pageTarget;
                this.changePageNumber();
            }
        },
        computed: {
            isPreviousButtonDisabled() {
                return this.page_number === 1
            },
            isNextButtonDisabled() {
                return this.page_number === this.paginator.last_page;
            }
        },
        mounted() {
            this.filters_string = JSON.stringify(this.filters);
            axios.get(`/events/${this.filters_string}/${this.number_of_events_per_page}/${this.page_number}`).then(response=>this.paginator = response.data);
        }

    }

</script>
