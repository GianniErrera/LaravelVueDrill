<template>

    <button
        @click="$emit('callGlobalCustomEvent', page_target)"
        class="btn btn-sm cursor"
    >
        {{button_label}}

    </button>

</template>

<script>
    import eventBus from './eventBus';

    export default {
        props: ['page_target', 'button_label'],
        methods: {
            callGlobalCustomEvent(page_target) {
            eventBus.$emit('custom-event') // if ChildComponent is mounted, we will have a message in the console
            }
        }
    }
</script>
