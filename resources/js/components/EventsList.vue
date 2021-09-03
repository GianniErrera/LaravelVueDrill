<template>
    <div>
        <!--Events filters div -->
        <div class="border border-red-800">
            <div class="lg:flex lg:justify-around pt-4">

            <div class="text-center mb-4 mt-8">
                <select v-model="filters.selected" v-on:change="applyFilters" class="select select-bordered">
                    <option v-for="option in options" v-bind:key="option.value" v-bind:value="option.value" >
                        {{ option.text }}
                    </option>
                </select>
            </div>


            <div v-show="!filters.singleDateQuery" class="md:mb-3 block text-center">
                <label for="searchRange" class="block text-center mb-3 font-size-14px font-semibold">Search over dates range:</label>
                <input
                    v-model="filters.searchRange"
                    id="searchRange"
                    name="searchRange"
                    type="text"
                    size="28"
                    class="text-center ml-4 mb-4 p-2 input input-bordered border border-gray-800"
                    readonly
                >
            </div>


            <div v-show="filters.singleDateQuery" class="block md:mb-3 text-center">
                <label for="searchDate" class="block text-center mb-3 font-size-14px font-semibold">Pick a date:</label>

                <input
                    v-model="filters.singleFormattedDate"
                    id="searchDate"
                    name="searchDate"
                    type="text"
                    size="28"
                    class="text-center ml-4 mb-4 p-2 input input-bordered border border-gray-800"
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
                        v-model="filters.singleDateQuery"
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
                    v-model="filters.ignoreYearFromQuery"
                    class="flex-none checkbox">
                </div>

            </div>

            <div>
                <div class="block text-center mb-">
                    <span class="ml-2 text-center font-semibold">Reset filters</span>
                    <div class="text-center m-4">
                        <button
                            v-on:click="removeFilters"
                            class="cursor-pointer align-center">

                                <img
                                    src ="images/filter-remove.png"
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
        <div class="p-4 border-b border-b-gray-400 rounded-xl ml-2 mr-2'">
            <div class="flex flex-row justify-between p-2" v-for="event in paginator.data" :key="event.id">
                <div class="lg:flex lg:w-5/6 lg:grid lg:grid-cols-6">

                    <div>
                        {{ event.date }}
                    </div>
                    <div class="lg:ml-8 lg:col-span-2">
                        {{ event.name }}
                    </div>
                    <div class="col-span-3">
                        {{ event.eventDescription }}
                    </div>

                </div>
                <div class="flex items-center text-center lg:mr-4">
                    <div class="mr-4 text-center">
                        {{ event.isItRecurringYearly ? "&#10004;" : "no" }}
                    </div>

                </div>
            </div>
            <!-- Events paginator buttons -->
            <div class="flex mt-4 justify-center hover:text-">
                <div class="btn-group">
                <button
                    @click="jumpToPage(1)"
                    class="btn btn-sm cursor rounded-lg"
                    :disabled="isPreviousButtonDisabled"
                >
                    {{this.$options.static.firstButton}}

                </button>
                <button
                    @click="previousPage"
                    class="btn btn-sm cursor rounded-lg"
                    :disabled="isPreviousButtonDisabled"
                >
                    {{this.$options.static.prevButton}}
                </button>
                <!--This is shown only when on last page -->
                <button
                    class="btn btn-sm cursor"
                    v-show="paginator.last_page > 3 && pageNumber === paginator.last_page"
                    @click="jumpToPage(pageNumber - 2)">
                {{ pageNumber - 2 }}
                </button>
                <!--This is shown only when on last two pages -->
                <button
                    class="btn btn-sm cursor"
                    v-show="paginator.last_page >= 3 && pageNumber >= 2"
                    @click="jumpToPage(pageNumber - 1)">
                {{ pageNumber - 1 }}
                </button>
                <button
                class="btn btn-sm"
                disabled
                >
                {{ pageNumber }}
                </button>
                <button
                    class="btn btn-sm cursor"
                    v-show="pageNumber + 1 <= paginator.last_page"
                    @click="jumpToPage(pageNumber + 1)">
                {{ pageNumber + 1 }}
                </button>
                <button
                    class="btn btn-sm cursor"
                    v-show="pageNumber === 1 && pageNumber + 2 <= paginator.last_page"
                    @click="jumpToPage(pageNumber + 2)">
                {{ pageNumber + 2 }}
                </button>
                <button
                    @click="nextPage"
                    class="btn btn-sm cursor"
                    :disabled="isNextButtonDisabled"
                    >
                    >
                </button>
                <button
                    @click="jumpToPage(paginator.last_page)"
                    class="btn btn-sm cursor"
                    :disabled="isNextButtonDisabled"
                    >
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
    const buttonLabels = {
        first: "<<",
        prev: "<",
        next: ">",
        last: ">>"
    };

    export default {
       data() {
            return {
                filters: {
                    "selected": "date",
                    "search": "",
                    "singleDateQuery": false,
                    "singleDate": "",
                    "singleFormattedDate": "",
                    "searchRange": "",
                    "startDate": "",
                    "endDate": "",
                    "ignoreYearFromQuery": false,

                },
                "options": [
                    { text: "Order by date", value: "date", id: 1 },
                    { text: "Order by creation date", value: "created_at", id: 2}
                ],
                paginator: [],
                selected: "date",
                paginator: [],
                pageNumber: 1,
                numberOfEventsPerPage: 15,
                paginatorPathURL: ""
                }
            },
        static: {
            firstButton: "<<", // these two strings are used as "<" symbol may be interpreted as first character of tag
            prevButton: "<"
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
                if(this.filters.singleDate != "") {
                    axios.get(`/events/single/${this.numberOfEventsPerPage}/${this.pageNumber}/${this.filters.selected}/${this.filters.singleDate}/${this.filters.search}`)
                    .then(response=>this.paginator = response.data);
                }
                else if(this.filters.searchRange != "") {
                    axios.get(`/events/range/${this.numberOfEventsPerPage}/${this.pageNumber}/${this.filters.selected}/${this.startDate}/${this.filters.endDate}/${this.filters.ignoreYearFromQuery}/${this.search}`)
                    .then(response=>this.paginator = response.data);
                } else if(this.filters.search != "") {
                    this.pageNumber = 1;
                    axios.get(`/events/search/${this.numberOfEventsPerPage}/${this.filters.selected}/${this.filters.search}/${this.pageNumber}`)
                .then(response=>this.paginator = response.data);
                } else {
                    axios.get(`/events/${this.numberOfEventsPerPage}/${this.filters.selected}/${this.pageNumber}`)
                .then(response=>this.paginator = response.data);
                }
            },
            removeFilters() {
                this.filters.selected = "date";
                this.filters.singleDateQuery = false;
                this.filters.search = "";
                this.filters.singleDate = "";
                this.filters.singleFormattedDate = "";
                this.filters.searchRange = "";
                this.filters.startDate = "";
                this.filters.endDate = "";
                this.filters.ignoreYearFromQuery = false;
            },
            clearDatepickers() {
                this.filters.singleDate = "";
                this.filters.singleFormattedDate = "";
                this.filters.searchRange = "";
                this.filters.startDate = "";
                this.filters.endDate = "";
                this.datepicker.clearSelection();
                this.rangepicker.clearSelection();
            },
            paginatorURL() {
                var indexOfLastSlash = 0;
                for(var i = 0; i < this.paginator.path.length; i++) {
                    console.log(this.paginator.path.[i]);
                    if(this.paginator.path.[i] == "/") {
                        indexOfLastSlash = i;
                    };
                }
                this.paginatorPathURL = this.paginator.path.substring(0, indexOfLastSlash);
            },
            nextPage() {
                this.pageNumber += 1;
                axios.get(`${this.paginatorPathURL}/${this.pageNumber}`)
                .then(response=>this.paginator = response.data);
            },
            previousPage() {
                this.pageNumber -= 1;
                axios.get(`${this.paginatorPathURL}/${this.pageNumber}`).then(response=>this.paginator = response.data);
            },
            firstPage() {
                this.pageNumber = 1;
                axios.get(`${this.paginatorPathURL}/1}`).then(response=>this.paginator = response.data);
            },
            lastPage() {
                this.pageNumber = this.paginator.last_page;
                axios.get(`${this.paginatorPathURL}/${this.pageNumber}`).then(response=>this.paginator = response.data);
            },
            jumpToPage($pageTarget) {
                this.pageNumber = $pageTarget;
                axios.get(`${this.paginatorPathURL}/${this.pageNumber}`).then(response=>this.paginator = response.data);
            }
        },
        computed: {
            isPreviousButtonDisabled() {
                return this.pageNumber === 1
            },
            isNextButtonDisabled() {
                return this.pageNumber === this.paginator.last_page;
            }
        },
        mounted() {

            axios.get(`/events/${this.numberOfEventsPerPage}/${this.filters.selected}/${this.pageNumber}`).then(response=>this.paginator = response.data);

            this.datepicker= new Litepicker({
                element: document.getElementById('searchDate'),
                format: 'DD-MM-YYYY',
                resetButton: true,
                singleMode: true,
                allowRepick: true,
                autoRefresh: true,
                splitView: true,
                setup: (picker) => {
                    picker.on('selected', (date) => {
                        console.log(this);
                        this.filters.search = "";
                        this.filters.singleFormattedDate = date.format('DD-MMM-YYYY');
                        this.filters.singleDate = date.format('YYYY-MM-DD');
                        this.filters.startDate = ""; // each time the single date or range date picker is selected I nullify manually previously picked values
                        this.filters.endDate = "";
                        this.filters.searchRange = "";
                        })
                    }

            })



            this.rangepicker= new Litepicker({
                element: document.getElementById('searchRange'),
                format: 'DD-MM-YYYY',
                resetButton: true,
                singleMode: false,
                allowRepick: true,
                autoRefresh: true,
                splitView: true,
                setup: (picker) => {

                    picker.on('selected', (startDate, endDate) => {
                        this.filters.searchRange = startDate.format('DD-MMM-YYYY') + " - " + endDate.format('DD-MMM-YYYY');
                        this.filters.startDate = startDate.format('YYYY-MM-DD');
                        this.filters.endDate = endDate.format('YYYY-MM-DD');
                        this.filters.singleDate = ""; // each time the single date or range date picker is selected I nullify manually previously picked values
                        this.filters.singleFormattedDate = "";

                    })
                }

            })



        }

    }
</script>
