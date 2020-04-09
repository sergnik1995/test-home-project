<template>
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <input type="checkbox" v-bind:name="'questions['+questionPosition+'][options]['+position+'][true]'">
            </div>
        </div>
        <input type="text" class="form-control" v-bind:name="'questions['+questionPosition+'][options]['+position+'][answer]'" v-bind:value="value" pattern="\S+.*" required>
        <div class="input-group-append">
            <button class="btn btn-outline-danger" type="button" v-on:click="$emit('remove')">Удалить</button>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            position: Number,
            value: String,
            questionPosition: Number,
        }
    }
</script>