<template>
    <div >

        <div class="flex flex-row justify-between p-2" v-for="event in paginator.data" :key="event.id">
            <div class="flex w-5/6 grid grid-cols-6">

                <div>
                    {{ event.date }}
                </div>
                <div class="ml-8 text-left col-span-2">
                    {{ event.name }}
                </div>
                <div class="col-span-3">
                    {{ event.eventDescription }}
                </div>

            </div>
            <div class="flex items-center ml-2">
                <div class="lg:mr-4">
                    <button class="btn btn-primary hover:text-yellow-100 copy-to-clipboard"
                        data-clipboard-text="test">
                        Copy to clipboard
                    </button>
                </div>
                <div class="items-center">
                    {{ event.isItRecurringYearly ? "&#10004;" : "no" }}
                </div>
            </div>
         </div>
        <div class="flex mt-4 justify-center">
            <div class="btn-group">
            <button
                @click="previousPage"
                class="btn btn-sm cursor"
                v-show="pageNumber > 1"
            >
                Previous
            </button>
            <button
                @click="previousPage"
                class="btn btn-sm cursor rounded-lg"
                v-show="pageNumber == 1"
                disabled
            >
                Previous
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
                class="btn btn-sm cursor">
            Next
            </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
       data() {
            return {
                paginator: [],
                pageNumber: 1,
                numberOfEventsPerPage: 15,
                name: "Events"
            }
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
            }
        },
        mounted() {

            axios.get(`/events/${this.numberOfEventsPerPage}/${this.name}/${this.pageNumber}`).then(response=>this.paginator = response.data);

            new ClipboardJS('.copy-to-clipboard');


        }

    }
</script>
