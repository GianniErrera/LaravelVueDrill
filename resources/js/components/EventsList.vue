<template>
    <div >

        <div class="flex flex-row justify-between p-2" v-for="event in events" :key="event.id">
            <div class="flex">
                <div>
                    {{ event.date }}
                </div>
                <div class="ml-8 text-left">
                    {{event.name}} - {{event.eventDescription}}
                </div>
            </div>
            <div>
                {{event.isItRecurringYearly ? "&#10004;" : "no"}}
            </div>
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
