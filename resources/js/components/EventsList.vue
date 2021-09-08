<template>
    <div class="border border-red-800">
        <!--Event creation form -->
        <div class="border border-red-800">
            <event-form v-bind:fonte="fontediVerità" v-bind:paginator="paginator" v-on:event-published="applyFilters"></event-form>
        </div>
        <!--End event creation form -->
        <!--Events filters div -->
        <div class="border border-red-800">
            <div class="lg:flex lg:justify-around pt-4">

                <div class="text-center mb-4 mt-8">
                    <select v-model="filters.selected" class="select select-bordered">
                        <option v-for="option in options" v-bind:key="option.value" v-bind:value="option.value" >
                            {{ option.text }}
                        </option>
                    </select>
                </div>


                <div v-show="!filters.single_date_query" class="md:mb-3 block text-center">
                    <label for="search_range" class="block text-center mb-3 font-size-14px font-semibold">Search over dates range:</label>
                    <input
                        v-model="filters.search_range"
                        id="search_range"
                        name="search_range"
                        type="text"
                        size="24"
                        class="text-center mx-4 mb-4 p-2 input input-bordered border border-gray-800"
                        readonly
                    >
                </div>


                <div v-show="filters.single_date_query" class="block md:mb-3 text-center">
                    <label for="searchDate" class="block text-center mb-3 font-size-14px font-semibold">Pick a date:</label>

                    <input
                        v-model="single_formatted_date"
                        id="searchDate"
                        name="searchDate"
                        type="text"
                        size="24"
                        class="text-center mx-4 mb-4 p-2 input input-bordered border border-gray-800"
                        readonly
                    >

                </div>

                <div class="mb-3 text-center">
                    <div class="block mb-5">
                        <span class="text-center font-semibold">Sigle date query</span>
                    </div>
                    <div>
                        <input
                            type="checkbox"
                            v-model="filters.single_date_query"
                            v-on:change="clearDatepickers"
                            class="flex-none checkbox"
                        >
                    </div>

                </div>


                <div class="mb-3 text-center ">
                    <label for="search" class="block text-center mb-3 font-semibold">Search events:</label>

                    <input
                        type="text"
                        v-model="filters.search"
                        id="search"
                        name="search"
                        placeholder=""
                        class="input input-bordered border border-gray-800 mb-4 p-2"
                    />
                </div>


                <div class="mb-3 text-center">
                    <div class="block mb-5">
                        <span class="text-center font-semibold">Search interval over all years</span>
                    </div>
                    <div class="block text-center">
                        <input
                            type="checkbox"
                            v-model="filters.ignore_year_from_query"
                            class="flex-none checkbox">
                    </div>

                </div>

                <div>
                    <div class="block text-center">
                        <span class="ml-2 text-center font-semibold">Reset filters</span>
                        <div class="text-center m-4">
                            <button
                                v-on:click="removeFilters"
                                class="cursor-pointer align-center">
                                <img
                                    src ="images/funnel.svg"
                                    width="30"
                                    class="transform hover:scale-110"
                                    >
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--End events filters div -->

        <!-- Events list div -->
        <div class="p-4 border-b border-b-gray-400 rounded-xl">
            <div class="lg:flex lg:flex-row justify-between p-2" v-for="event in paginator.data" :key="event.id">
                <div class="lg:flex w-4/6 lg:grid lg:grid-cols-6 lg:grid-cols-6">

                    <div class="ml-4 mb-2 lg:col-span-1">
                        {{ event.date }}
                    </div>
                    <div class="ml-4 mb-2 lg:ml-8 col-span-2">
                        {{ event.name }}
                    </div>
                    <div class="ml-4 mb-2 lg:col-span-3">
                        {{ event.eventDescription }}
                    </div>

                </div>
                <div class="items-center text-center lg:ml-2 lg:mr-4">
                    <div class="ml-4 mr-4  mb-2 text-center">
                        {{ event.isItRecurringYearly ? "&#10004;" : "not yearly event" }}

                        <button
                            class="btn btn-primary cursor-pointer  mb-2 ml-2  "
                                v-clipboard="() => eventToString(event)">
                                <span class="text-sm">Copy to clipboard</span>
                        </button>
                    </div>
                </div>
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
    const buttonLabels = {
        first: "<<",
        prev: "<",
        next: ">",
        last: ">>"
    };

    export default {
       components: { Input },
       data() {
            return {
                filters: {
                    "selected": "date",
                    "search": "",
                    "single_date": "",
                    "search_range": "",
                    "start_date": "",
                    "end_date": "",
                    "ignore_year_from_query": false,

                },
                "options": [
                    { text: "Order by date", value: "date", id: 1 },
                    { text: "Order by creation date", value: "created_at", id: 2}
                ],
                events_array: {},
                filters_string: "",
                number_of_events_per_page: 15,
                paginator: [],
                page_number: 1,
                paginator_path_url: "",
                selected: "date",
                single_date_query: false,
                single_formatted_date: ""
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
            },
            "paginator.data": {
                handler: 'paginatorURL',
                deep: true
            }
        },
        methods: {
            applyFilters() {
                this.page_number = 1;
                this.filters_string = JSON.stringify(this.filters);
                axios.get(`/events/${this.filters_string}/${this.number_of_events_per_page}/${this.page_number}`).then(response=>this.paginator = response.data);
            },
            removeFilters() {
                this.filters.selected = "date";
                this.filters.single_date_query = false;
                this.filters.search = "";
                this.filters.single_date = "";
                this.single_formatted_date = "";
                this.filters.search_range = "";
                this.filters.start_date = "";
                this.filters.end_date = "";
                this.filters.ignore_year_from_query = false;
                this.page_number = 1;
            },
            clearDatepickers() {
                this.filters.single_date = "";
                this.single_formatted_date = "";
                this.filters.search_range = "";
                this.filters.start_date = "";
                this.filters.end_date = "";
                this.page_number = 1;
                this.datepicker.clearSelection();
                this.rangepicker.clearSelection();
            },
            paginatorURL() {
                var indexOfLastSlash = 0;
                for(var i = 0; i < this.paginator.path.length; i++) {
                    if(this.paginator.path.[i] == "/") {
                        indexOfLastSlash = i;
                    };
                }
                this.paginator_path_url = this.paginator.path.substring(0, indexOfLastSlash);
            },
            nextPage() {
                this.page_number += 1;
                axios.get(`${this.paginator_path_url}/${this.page_number}`)
                .then(response=>this.paginator = response.data);
            },
            previousPage() {
                this.page_number -= 1;
                axios.get(`${this.paginator_path_url}/${this.page_number}`).then(response=>this.paginator = response.data);
            },
            firstPage() {
                this.page_number = 1;
                axios.get(`${this.paginator_path_url}/1}`).then(response=>this.paginator = response.data);
            },
            lastPage() {
                this.page_number = this.paginator.last_page;
                axios.get(`${this.paginator_path_url}/${this.page_number}`).then(response=>this.paginator = response.data);
            },
            jumpToPage($pageTarget) {
                this.page_number = $pageTarget;
                axios.get(`${this.paginator_path_url}/${this.page_number}`).then(response=>this.paginator = response.data);
            },
            eventToString($event) {
                let $date = new Date($event.date);
                var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                let $recurringOrNot = "";
                if($event.isItRecurringYearly) {
                    $recurringOrNot = "Event recurring each year";
                } else {
                     $recurringOrNot = "Not recurring event";
                }

                let $event_to_string = $date.toLocaleString('en-GB', options) + " - " + $event.name + " - " + $event.eventDescription + " - " + $recurringOrNot;
                return($event_to_string);

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

            this.datepicker= new Litepicker({
                element: document.getElementById('searchDate'),
                format: 'DD-MM-YYYY',
                resetButton: true,
                singleMode: true,
                allowRepick: true,
                autoRefresh: true,
                splitView: true,
                dropdowns: {"minYear":null,"maxYear":null,"months":true,"years":true},
                setup: (picker) => {
                    picker.on('selected', (date) => {
                        console.log(this);
                        this.filters.search = "";
                        this.single_formatted_date = date.format('DD-MMM-YYYY');
                        this.filters.single_date = date.format('YYYY-MM-DD');
                        this.filters.start_date = ""; // each time the single date or range date picker is selected I nullify manually previously picked values
                        this.filters.end_date = "";
                        this.filters.search_range = "";
                        })
                    }

            })



            this.rangepicker= new Litepicker({
                element: document.getElementById('search_range'),
                format: 'DD-MM-YYYY',
                resetButton: true,
                singleMode: false,
                allowRepick: true,
                autoRefresh: true,
                splitView: true,
                dropdowns: {"minYear":null,"maxYear":null,"months":true,"years":true},
                setup: (picker) => {

                    picker.on('selected', (start_date, end_date) => {
                        this.filters.search_range = start_date.format('DD-MMM-YYYY') + " - " + end_date.format('DD-MMM-YYYY');
                        this.filters.start_date = start_date.format('YYYY-MM-DD');
                        this.filters.end_date = end_date.format('YYYY-MM-DD');
                        this.filters.single_date = ""; // each time the single date or range date picker is selected I nullify manually previously picked values
                        this.single_formatted_date = "";

                    })
                }

            })



        }

    }
</script>
