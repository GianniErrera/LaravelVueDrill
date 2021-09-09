<template>
    <div>
        <div id="my-modal" class="modal">
            <div class="modal-box">
                <p>some stuff</p>
                <div class="modal-action">
                <a href="/components/modal#" class="btn btn-primary">Accept</a>
                <a href="/components/modal#" class="btn">Close</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        props: ['reminder']

    }
</script>
