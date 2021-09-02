<template>
    <div >

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
        <div class="flex mt-4 justify-center">
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
                v-show="pageNumber + 2 <= paginator.last_page"
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
                paginator: [],
                pageNumber: 1,
                numberOfEventsPerPage: 15,
                name: "Events"
            }
        },
        static: {
            firstButton: "<<", // these two strings are used as "<" symbol may be interpreted as first character of tag
            prevButton: "<"
        },
        methods: {
            nextPage() {
                this.pageNumber = this.pageNumber + 1;
                axios.get(`/events/${this.numberOfEventsPerPage}/${this.name}/${this.pageNumber}`).then(response=>this.paginator = response.data);

            },
            previousPage() {
                this.pageNumber = this.pageNumber - 1;
                axios.get(`/events/${this.numberOfEventsPerPage}/${this.name}/${this.pageNumber}`).then(response=>this.paginator = response.data);
            },
            jumpToPage($pageTarget) {
                this.pageNumber = $pageTarget;
                axios.get(`/events/${this.numberOfEventsPerPage}/${this.name}/${this.pageNumber}`).then(response=>this.paginator = response.data);
            },
            isItFirstPage() {
                if (this.pageNumber == 0) {
                    return true;
                }
                else {
                    return false;
                }
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

            axios.get(`/events/${this.numberOfEventsPerPage}/${this.name}/${this.pageNumber}`).then(response=>this.paginator = response.data);



        }

    }
</script>
