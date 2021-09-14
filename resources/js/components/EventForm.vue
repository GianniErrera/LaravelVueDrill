<template>
    <div class="border border-blue-400 rounded-lg px-8 py-6 lg:ml-6 mb-6 lg:mr-6 md:mx-auto">
        <p v-if="errors.length" class="text-error m-4">
                    <b>Please correct the following error(s):</b>
                    <ul class="list-disc">
                    <li v-for="error in errors" :key="error.id">{{ error }}</li>
                    </ul>
                </p>
        <form  class="border border-gray-800 lg:m-4" @submit.prevent="formValidation">
            <div class="lg:flex justify-between p-4 text-center">
                <input type="hidden" name="_token" :value="csrf">

                <div class="mx-2 lg:p-4 mb-6 text-center">
                    <label for="start" class="block mb-2 text-center font-semibold">Event date:</label>
                    <input
                            v-model="formattedDate"
                            id="date"
                            name="date"
                            class="px-4 mb-4 input input-bordered border-gray-800 flex-grow w-full text-center"
                            required
                            readonly
                            >
                </div>
                <div class="lg:ml-6 lg:p-4 text-center px-4 mb-6 lg:flex-grow lg:h-8">
                    <label for="name" class="block mb-2 text-center font-semibold">Event name:</label>
                        <input name="name"
                            class="px-4 input input-bordered flex-grow w-full"
                            type="text"
                            required
                            v-model="name">
                </div>
            </div>

            <div class="lg:flex lg:justify-between mt-2 mb-6">
                <div class="lg:w-4/5 px-4 text-center">
                    <label for="description" class="block mb-2 text-center font-semibold">Event description:</label>
                    <input name="description" class="mt-4 input input-bordered w-full" type="text" v-model="description">
                </div>

                <label class="text-center cursor-pointer lg:mr-4">
                    <span class="ml-2 font-semibold block mr-4 mt-4 text-center">Does this event occur every year?</span>
                    <div>
                        <input type="checkbox"
                            v-model="isItYearly"
                            class="items-center border border-rounded-xl toggle cursor-pointer mt-2 justify-center">
                    </div>
                </label>
            </div>

            <footer class="lg:flex lg:justify-between text-center items-center lg:items-start lg:ml-4 my-2">
                <button class="btn btn-primary rounded-xl hover:text-yellow-100 mx-4" type="submit">Submit event </button>
            </footer>

        </form>
    </div>
</template>

<script>
    export default {
       props: ['events'],
       data() {
            return {
                name: "",
                description: "",
                date: "",
                formattedDate: "", // this is the date format to display on screen
                isItYearly: false,
                errors: [],
                message: {
                    text: null,
                    type: 'success'
                }
            }
        },
        computed: {
                csrf() {
                    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                },
        },
        mounted() {
                console.log(sourceOfTruth);
                this.datepicker= new Litepicker({
                element: document.getElementById('date'),
                format: 'YYYY-MM-DD',
                resetButton: true,
                singleMode: true,
                allowRepick: true,
                autoRefresh: true,
                splitView: true,
                dropdowns: {"minYear":null,"maxYear":null,"months":true,"years":true},
                setup: (picker) => {
                    picker.on('selected', (date) => {
                        this.formattedDate = date.format('DD MMMM YYYY');
                        this.date = date.format('YYYY-MM-DD')
                    })
                }

            })
        },
        methods: {
            formValidation(e) {
                this.errors = [];
                if (!this.name) {
                    this.errors.push("Event name required.");
                }

                if (!this.date) {
                    // alert('hey');
                    this.errors.push("A valid date must be picked");
                }


                if (!this.errors.length) {
                    this.onSubmit();
                }

                e.preventDefault();

            },
            onSubmit() {



                axios.post('/events', {
                    date: this.date,
                    name: this.name,
                    description: this.description,
                    isItYearly: this.isItYearly
                    })
                    .then(
                        this.datepicker.clearSelection(),
                        this.date = "",
                        this.formattedDate = "",
                        this.name = "",
                        this.description = "",
                        this.isItYearly = false,
                        this.message.type = "success",
                        this.message.text = "Event published successfully!"
                    )
                    .catch(error => {
                        console.log(error.response),
                        this.message.type = "error",
                        this.message.text = "Something has gone wrong, sorry."
                    })

                this.$emit('event-published'); // this is going to trigger a listener on parent component to refresh the paginator to include new event.
                Bus.$emit('flash-message', this.message); // this sends a broadcast message so that a flash message may be displayed
                this.message = { // sets message back to default values
                    text: null,
                    type: 'success'
                }

            }


        }
    }

</script>
