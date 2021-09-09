<template>
    <div>
        <div
            v-for="(reminder, index) in reminders" :key="index">
                <div
                    :id="index"
                    class="flex m-4 p-4 justify-between bg-blue-800 text-white">
                    <div class="flex reminder">
                        <div>
                        {{ formatDate(reminder.date)}} - {{reminder.name }}
                        </div>

                    </div>
                    <button onclick="this.parentElement.style.display = 'none';" >
                        <div class="ml-2 flex font-xl font-bold text-grey-900 text-center">
                            X
                        </div>
                    </button>


                </div>
                <modal :reminder="reminder">
                </modal>
        </div>
    </div>
</template>

<script>
import Modal from './Modal.vue';
    export default {
  components: { Modal },
        data() {
            return {
                reminders: []

            }
        },
        methods: {
            formatDate($event_date) {
                let $date = new Date($event_date);
                var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

                return($date.toLocaleString('en-GB', options));
            }
        },
        mounted() {
            axios.get(`/reminders`).then(response=>this.reminders = response.data);
        }

    }

</script>

<style>

</style>
