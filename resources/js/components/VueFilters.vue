<template>
    <div>

        <div class="lg:flex lg:justify-around">
            <div>
                <select v-model="columnOrderCriteria"
                    class="select select-bordered">
                    <option value="created_at">Ordered by creation date</option>
                    <option value="date">Ordered by date</option>
                </select>
            </div>


            <div class="md:mb-3 block text-center @if($singleDateQuery) hidden @endif">
                <label for="search" class="block text-center mb-3 font-size-14px font-semibold">Search over dates range:</label>
                <input
                    v-model="searchRange"
                    id="searchRange"
                    name="searchRange"
                    type="text"
                    class="ml-4 mb-4 p-2 input input-bordered border border-gray-800"
                    readonly
                >
            </div>


            <div class="block md:mb-3 text-center @unless ($singleDateQuery)hidden @endunless">
                <label for="date" class="block text-center mb-3 font-semibold">Pick a date:</label>

                <input
                    v-model="searchDate"
                    id="searchDate"
                    name="searchDate"
                    type="text"
                    class="ml-4 mb-4 p-2 input input-bordered border border-gray-800"
                    readonly
                >

            </div>

            <div class="mb-3 text-center">
                <div>
                    <span class="text-center font-semibold">Sigle date query</span>
                </div>
                <div>
                    <input
                        type="checkbox"
                        v-model="singleDateQuery"
                        class="flex-none checkbox"
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
    </div>

</template>

<script>
    export default {
       data() {
            return {
                columnOrderCriteria: "date",
                singleDateQuery: false,
                search: "",
                ignoreYearFromQuery: false
            }
        },
        mounted() {
             axios.get('/events').then(response=>this.events = response.data);
        }

    }

</script>

