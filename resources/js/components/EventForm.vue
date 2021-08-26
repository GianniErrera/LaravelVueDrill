<template>
    <div class="border border-blue-400 rounded-lg px-8 py-6 lg:ml-6 mb-6 mr-2 md:mx-auto">
        <form  class="border border-gray-800 m-4" @submit.prevent="onSubmit">
            <div class="lg:flex justify-between p-4 text-center">
                <input type="hidden" name="_token" :value="csrf">
                <div class="lg:mr-4 lg:p-4 mb-2 text-center">
                    <label for="start" class="block mb-2 text-center font-semibold">Start date:</label>
                    <input
                                v-model="formattedDate"
                                id="date"
                                name="date"
                                class="ml-4 mb-4 input input-bordered border-gray-800"
                                readonly
                                >
                </div>
                <div class="lg:ml-6 mr-4 lg:p-4 mb-6 lg:flex-grow lg:h-8">
                    <label for="name" class="block mb-2 text-center font-semibold">Event name:</label>
                        <input name="name"
                            class="ml-4 mr-4 input input-bordered flex-grow w-full"
                            type="text"
                            v-model="name">
                </div>
            </div>

            <div class="lg:flex lg:justify-between mr-4 ml-5 mt-2 mb-6">
                <div class="w-4/5">
                    <label for="description" class="block mb-2 text-center font-semibold">Event description:</label>
                    <input name="description" class="ml-4 mr-4 mt-4 input input-bordered w-full" type="text" v-model="description">
                </div>

                <label class="text-center cursor-pointer lg:mr-4">
                    <span class="ml-2 font-semibold block mr-4 mt-4 text-center">Does this event recur every year?</span>
                    <div>
                        <input type="checkbox"
                            v-model="isItYearly"
                            class="items-center border border-rounded-xl toggle cursor-pointer mt-2 justify-center">
                    </div>
                </label>
            </div>

            <footer class="lg:flex lg:justify-between items-center lg:items-start p-4 mr-4">
                <button class="btn btn-primary rounded-xl hover:text-yellow-100 ml-4" type="submit">Submit event </button>
            </footer>

        </form>
    </div>
</template>

<script>
    export default {
       data() {
            return {
                name: "",
                description: "",
                date: "",
                formattedDate: "", // this is the date format to display on screen
                isItYearly: false
            }
        },
        computed: {
                csrf() {
                    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                },
        },
        mounted() {
              console.log("I should be working");
              const datepicker= new Litepicker({
                element: document.getElementById('date'),
                format: 'DD-MM-YYYY',
                resetButton: true,
                singleMode: true,
                allowRepick: true,
                autoRefresh: true,
                splitView: true,
                setup: (picker) => {
                    picker.on('selected', (date) => {
                        this.formattedDate = date.format('DD-MMM-YYYY');
                        this.date = date.format('YYYY-MM-DD')
                })
            },

            })
            },
        methods: {
            onSubmit() {
                axios.post('/events', {
                    date: this.date,
                    name: this.name,
                    description: this.description,
                    isItYearly: this.isItYearly
                })
                .then(
                    this.date = "",
                    this.formattedDate = "",
                    this.name = "",
                    this.description = "",
                    this.isItYearly = false
                )

            },
            test() {
                alert("OK");
            }
        }
    }

</script>
