<template>
    <div>
        <div
            v-for="(reminder, index) in reminders" :key="index">
                <div
                    id="`${index}`"
                    class="flex m-4 p-4 justify-between bg-blue-800 text-white">
                    <div class="flex reminder">
                        {{reminder.eventDescription}}
                    </div>
                    <button onclick="this.parentElement.style.display = 'none';" >
                        <div class="flex font-xl font-bold text-grey-900 text-center">
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
        mounted() {
            axios.get(`/reminders`).then(response=>this.reminders = response.data);
        }

    }

</script>

<style>

</style>
