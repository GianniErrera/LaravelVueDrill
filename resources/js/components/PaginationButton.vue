<template>

    <button
        @click="$emit('change-page', this.page_target)"
        class="btn btn-sm cursor"
    >
        {{this.button_label}}

    </button>

</template>

<script>
    export default {
        props: ['page_target', 'button_label']
    }
</script>
