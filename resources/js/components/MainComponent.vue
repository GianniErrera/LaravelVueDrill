<template>
    <div class="border border-blue-400 rounded-lg px-8 py-6 lg:ml-6 mb-6 mr-2 md:mx-auto">

        <div class="border border-red-800">
            <event-form array="events"></event-form>
        </div>

        <div class="border border-red-800">
            <vue-filters></vue-filters>
        </div>

        <div class="p-4 border-b border-b-gray-400 rounded-xl ml-2 mr-2' }}">
            <events-list></events-list>
        </div>

    </div>
</template>

<script>
    export default {
       data() {
            return {
                events: [
                ]
            }
        },
        mounted() {
             axios.get('/events').then(response=>this.events = response.data);

        }
    }
</script>
