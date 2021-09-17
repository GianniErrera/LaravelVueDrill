<template>
    <div class="lg:flex lg:justify-around pt-4">

        <div class="text-center mb-4 mt-8">
            <select v-model="filters.selected" class="select select-bordered">
                <option v-for="option in options" v-bind:key="option.value" v-bind:value="option.value" >
                    {{ option.text }}
                </option>
            </select>
        </div>


        <div v-show="!single_date_query" class="md:mb-3 block text-center">
            <label for="search" class="block text-center mb-3 font-size-14px font-semibold">Search over dates range:</label>
            <input
                id="searchRange"
                name="searchRange"
                type="text"
                size="28"
                class="text-center ml-4 mb-4 p-2 input input-bordered border border-gray-800"
                readonly
            >
        </div>


        <div v-show="single_date_query" class="block md:mb-3 text-center">
            <label for="singleDate" class="block text-center mb-3 font-size-14px font-semibold">Pick a date:</label>

            <input
                id="singleDate"
                name="singleDate"
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
                    v-model="single_date_query"
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
            <div class="block text-center mb-">
                <span class="ml-2 text-center font-semibold">Reset filters</span>
                <div class="text-center m-4">
                    <button
                        @click="clearFilters"
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

</template>

<script>
    export default {
       data() {
            return {
                "options": [
                    { text: "Order by date", value: "date", id: 1 },
                    { text: "Order by creation date", value: "created_at", id: 2}
                ],
                selected: "date",
                single_date_query: false
            }
        },
        props: ['filters'],
        methods: {
                clearFilters() {
                    this.single_date_query = false;
                    this.filters.selected = "date";
                    this.filters.search = "";
                    this.filters.ignore_year_from_query = false;
                    this.filters.singleDate = "";
                    this.filters.start_date = "";
                    this.filters.end_date = "";
                    this.clearDatepickers();
                },
                clearDatepickers() {
                    this.singledatepicker.clearSelection();
                    this.rangepicker.clearSelection();
                }
        },
        mounted() {
            this.singledatepicker= new Litepicker({
                element: document.getElementById('singleDate'),
                format: 'DD MMM YYYY',
                resetButton: true,
                singleMode: true,
                allowRepick: true,
                autoRefresh: true,
                splitView: true,
                dropdowns: {"minYear":null,"maxYear":null,"months":true,"years":true},
                setup: (picker) => {
                    picker.on('selected', (date) => {
                        this.rangepicker.clearSelection();
                        this.filters.search = "";
                        this.filters.single_date = date.format('YYYY-MM-DD');
                        this.filters.start_date = ""; // each time the single date or range date picker is selected I nullify manually previously picked values
                        this.filters.end_date = "";
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
                numberOfMonths: 2,
                numberOfColumns: 2,
                dropdowns: {"minYear":null,"maxYear":null,"months":true,"years":true},
                setup: (picker) => {

                    picker.on('selected', (startDate, endDate) => {
                        this.singledatepicker.clearSelection();
                        this.filters.start_date = startDate.format('YYYY-MM-DD');
                        this.filters.end_date = endDate.format('YYYY-MM-DD');
                    })
                }

            })

        }


    }

</script>

