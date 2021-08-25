<template>
    <div>
         <p class="redtext">
         <ul>
            <li v-for="event in events" :key="event.id">
                {{event.name}} - {{event.eventDescription}} {{event.isItRecurringYearly ? "&#10004;" : "no"}}
            </li>
         </ul>
        </p>
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
