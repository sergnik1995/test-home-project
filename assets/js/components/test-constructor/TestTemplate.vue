<template>
    <form action="/create-test" method="post" name="test">
        <input type="hidden" name="token" v-bind:value="csrf">
        <div class="card">
            <test-head></test-head>
            <test-body></test-body>
        </div>
    </form>
</template>
<script>
    import TestHead from './TestHead';
    import TestBody from './TestBody';

    export default {
        components: { TestHead, TestBody },
        data () {
            return {
                csrf: ''
            }
        },
        mounted () {

            this.csrf = this.$el.getAttribute('data-csrf');
        }
    }
</script>