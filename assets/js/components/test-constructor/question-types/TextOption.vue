<template>
    <div class="text-option">
        <label>Варианты ответа</label>
        <div class="mb-3" v-for="(option, index) in options" v-bind:key="option.position">
            <div class="input-group">
                <input type="text" class="form-control text-option__option" v-bind:name="'questions['+questionPosition+'][options]['+index+'][answer]'" v-bind:value="option.value" pattern="\S+.*" required>
                <div class="input-group-append">
                    <button class="btn btn-outline-danger" type="button" v-on:click="removeOption(index)">Удалить</button>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control text-option__input" placeholder="Текст ответа" aria-label="Текст ответа" v-model="value" v-on:keyup.enter="addOption">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" v-on:click="addOption">Добавить</button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                options: [],
                nextOptionId: 0,
                value: ''
            }
        },
        props: {
            questionPosition: Number,
        },
        methods: {
            addOption: function () {
                this.options.push({
                    position: this.nextOptionId++,
                    value: this.value
                });
                this.value = ''
            },
            removeOption: function (index) {
                this.options.splice(index, 1);
            }
        }
    }
</script>