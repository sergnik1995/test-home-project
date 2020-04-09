<template>
    <div class="few-from-list">
        <label>Варианты ответа</label>
        <div class="mb-3" v-for="(option, index) in options" v-bind:key="option.position">
            <constructor-checkbox
                    v-bind:position="index"
                    v-bind:value="option.value"
                    v-bind:question-position="questionPosition"
                    @remove="removeOption(index)"
            ></constructor-checkbox>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control few-from-list__input" placeholder="Текст ответа" aria-label="Текст ответа" v-model="value" v-on:keyup.enter="addOption">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" v-on:click="addOption">Добавить</button>
            </div>
        </div>
    </div>
</template>
<script>
    import ConstructorCheckbox from "./questions-components/ConstructorCheckbox";

    export default {
        components: { ConstructorCheckbox },
        props: {
            questionPosition: Number,
        },
        data () {
            return {
                options: [],
                nextOptionId: 0,
                value: ''
            }
        },
        methods: {
            addOption () {
                this.options.push({
                   position: this.nextOptionId++,
                   value: this.value
                });
                this.value = '';
            },
            removeOption (index) {
                this.options.splice(index, 1);
            },
        }
    }
</script>