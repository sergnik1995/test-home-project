<template>
    <form action="/create-test" method="post" name="test">
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
        components: { TestHead, TestBody }
    }
</script>