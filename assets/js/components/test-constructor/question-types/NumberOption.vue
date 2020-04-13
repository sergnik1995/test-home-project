<template>
    <div>
        <label>Ответ</label>
        <div class="mb-3 row">
            <div class="col">
                <input type="number" class="form-control" placeholder="Число" v-bind:name="'questions['+questionPosition+'][options][0][answer]'" required>
            </div>
            <div class="col">
                <input type="number" class="form-control" min="0" max="9007199254740991" step="0.0001" placeholder="Погрешность" v-bind:name="'questions['+questionPosition+'][options][0][accuracy]'">
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            questionPosition: Number,
        },
    }
</script>