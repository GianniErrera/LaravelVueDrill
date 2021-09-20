<template>
    <div class="flex mt-4 justify-center">
        <div class="btn-group flex-nowrap mx-auto">

            <button
                @click="jumpToPage(1)"
                class="btn btn-sm cursor rounded-lg"
                :disabled="isPreviousButtonDisabled"
            >
                {{this.$options.static.first_button}}

            </button>
            <button
                @click="jumpToPage(page_number - 1)"
                class="btn btn-sm cursor rounded-lg"
                :disabled="isPreviousButtonDisabled"
            >
                {{this.$options.static.prev_button}}
            </button>
            <!--This is shown only when on last page -->
            <button
                class="btn btn-sm cursor"
                v-if="paginator.last_page === 3 && page_number === 3 || paginator.last_page > 3 && page_number === paginator.last_page"
                @click="jumpToPage(page_number - 2)"
            >

                {{ page_number - 2 }}

            </button>
            <!--This is shown only when on last two pages -->
            <button
                class="btn btn-sm cursor"
                v-if="paginator.last_page < 3 && page_number === 2 || (paginator.last_page >= 3 && page_number >= 2)"
                @click="jumpToPage(page_number - 1)"
            >

                {{ page_number - 1 }}

            </button>
            <button
            class="btn btn-sm"
            disabled
            >

                {{ page_number }}

            </button>
            <button
                class="btn btn-sm cursor"
                v-if="page_number + 1 <= paginator.last_page"
                @click="jumpToPage(page_number + 1)"
            >

                {{ page_number + 1 }}

            </button>
            <button
                class="btn btn-sm cursor"
                v-if="page_number === 1 && page_number + 2 <= paginator.last_page"
                @click="jumpToPage(page_number + 2)"
            >

                {{ page_number + 2 }}

            </button>
            <button
                @click="jumpToPage(page_number + 1)"
                class="btn btn-sm cursor"
                :disabled="isNextButtonDisabled"
            >
                    {{this.$options.static.next_button}}
            </button>
            <button
                @click="jumpToPage(paginator.last_page)"
                class="btn btn-sm cursor"
                :disabled="isNextButtonDisabled"
            >
                    {{this.$options.static.last_button}}
            </button>
        </div>
    </div>
</template>

<script>
import PaginationButton from './PaginationButton.vue';

    export default {
  components: { PaginationButton },
        props: ['paginator', 'page_number'],
        static: {
            first_button: "<<", // strings starting with "<" symbol may be interpreted as first character of HTML tag
            prev_button: "<",
            next_button: ">",
            last_button: ">>"
        },
        methods: {
            jumpToPage($pageTarget) {
                this.page_number = $pageTarget;
            }
        },
        computed: {
            isPreviousButtonDisabled() {
                return this.page_number === 1
            },
            isNextButtonDisabled() {
                return this.page_number === this.paginator.last_page;
            }
        }
    }
</script>
