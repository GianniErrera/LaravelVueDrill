<template>
    <div>
        <div class="w-full grid grid-cols-1">

            <div class="text-center mb-2">
                {{ event.date }}
            </div>
            <div class="text-center mb-2 lg:ml-8">
                {{ event.name }}
            </div>
            <div class="text-center mb-2 lg:col-span-3">
                {{ event.eventDescription }}
            </div>

        </div>

        <div class="lg:ml-2 lg:mr-4 lg:flex lg:flex-row text-center items-center">
            <div class="mb-2">
                {{ event.isItRecurringYearly ? "&#10004;" : "not yearly event" }}
            </div>
            <div>
                    <button
                        class="btn btn-primary cursor-pointer  mb-2 ml-2  "
                            v-clipboard="() => eventToString(event)">
                            <span class="text-sm">Copy to clipboard</span>
                    </button>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['event']
    }
</script>
