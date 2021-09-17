<template>
    <div class="lg:flex lg:flex-row justify-between p-2">

        <div class="w-4/6 lg:grid lg:grid-cols-6">

            <div class="ml-4 mb-2 lg:col-span-1">
                {{ event.date }}
            </div>
            <div class="ml-4 mb-2 lg:ml-8 lg:col-span-2">
                {{ event.name }}
            </div>
            <div class="ml-4 mb-2 lg:col-span-3">
                {{ event.eventDescription ? event.eventDescription : "no description" }}
            </div>

        </div>

        <div class="lg:ml-2 lg:mr-4 lg:flex lg:flex-row text-center items-center lg:ml-2 lg:mr-4">
            <div class="mb-2">
                {{ event.isItRecurringYearly ? "&#10004;" : "not yearly event" }}
            </div>
            <div>
                    <button
                        class="btn btn-primary cursor-pointer mb-2 ml-2  "
                            v-clipboard="() => eventToString(event)">
                            <span class="text-sm">Copy to clipboard</span>
                    </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            hasDescription($event) {
                return $event.eventDescription != "";
            }
        },
        props: ['event']
    }
</script>
