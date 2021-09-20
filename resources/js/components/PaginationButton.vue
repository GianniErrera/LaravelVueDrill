<template>
    <div>
    <button
                @click="firstPage"
                class="btn btn-sm cursor rounded-lg"
                :disabled="isPreviousButtonDisabled"
            >


            </button>
    </div>
</template>

<script>
    export default {
        props: ['page_number']
    }
</script>
