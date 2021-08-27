<template>
    <div class="lg:flex lg:justify-around pt-4">

        <div class="text-center mb-4 mt-8">
            <select v-model="selected" class="select select-bordered">
                <option v-for="option in options" v-bind:key="option.value" v-bind:value="option.value">
                    {{ option.text }}
                </option>
            </select>
        </div>


        <div v-show="!singleDateQuery" class="md:mb-3 block text-center">
            <label for="search" class="block text-center mb-3 font-size-14px font-semibold">Search over dates range:</label>
            <input
                v-model="searchRange"
                id="searchRange"
                name="searchRange"
                type="text"
                size="28"
                class="text-center ml-4 mb-4 input input-bordered border border-gray-800"
                readonly
            >
        </div>


        <div v-show="singleDateQuery" class="block md:mb-3 text-center">
            <label for="searchDate" class="block text-center mb-3 font-semibold">Pick a date:</label>

            <input
                v-model="singleFormattedDate"
                id="searchDate"
                name="searchDate"
                type="text"
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
                    v-model="singleDateQuery"
                    class="flex-none checkbox"
                    @change="clearDatepickers"
                >
            </div>

        </div>


        <div class="mb-3 text-center ">
            <label for="search" class="block text-center mb-3 font-semibold">Search events:</label>

            <input
                type="text"
                v-model="search"
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
                v-model="ignoreYearFromQuery"
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

</template>

<script>
    export default {
       data() {
            return {
                selected: "date",
                options: [
                    { text: "Order by date", value: "date", id: 1 },
                    { text: "Order by creation date", value: "created_at", id: 2}
                ],
                singleDateQuery: false,
                search: "",
                singleDate: "",
                singleFormattedDate: "",
                searchRange: "",
                startDate: "",
                endDate: "",
                ignoreYearFromQuery: false

            }
        },
        props: ['events'],
        methods: {
                removeFilters() {
                    this.selected = "date";
                    this.singleDateQuery = false;
                    this.search = "";
                    this.singleDate = "";
                    this.singleFormattedDate = "";
                    this.searchRange = "";
                    this.startDate = "";
                    this.endDate = "";
                    this.ignoreYearFromQuery = false;
                },
                clearDatepickers() {
                    this.singleDate = "";
                    this.singleFormattedDate = "";
                    this.searchRange = "";
                    this.startDate = "";
                    this.endDate = "";
                    this.datepicker.clearSelection();
                    this.rangepicker.clearSelection();
                }
        },
        mounted() {
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
                        this.search = "";
                        this.singleFormattedDate = date.format('DD-MMM-YYYY');
                        this.singleDate = date.format('YYYY-MM-DD');
                        this.startDate = ""; // each time the single date or range date picker is selected I nullify manually previously picked values
                        this.endDate = "";
                        this.searchRange = "";
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
                        this.searchRange = startDate.format('DD-MMM-YYYY') + " - " + endDate.format('DD-MMM-YYYY');
                        this.startDate = startDate.format('YYYY-MM-DD');
                        this.endDate = endDate.format('YYYY-MM-DD');
                        this.singleDate = ""; // each time the single date or range date picker is selected I nullify manually previously picked values
                        this.singleFormattedDate = "";

                    })
                }

            })

        }


    }

</script>

