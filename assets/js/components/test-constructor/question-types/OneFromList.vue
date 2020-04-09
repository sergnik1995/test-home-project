<template>
    <div class="one-from-list">
        <label>Варианты ответа</label>
        <div class="mb-3" v-for="(option, index) in options" v-bind:key="option.position">
            <constructor-radiobutton
                    v-bind:position="index"
                    v-bind:value="option.value"
                    v-bind:question-position="questionPosition"
                    @remove="deleteOption(index)"
            >
            </constructor-radiobutton>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control one-from-list__input" placeholder="Текст ответа" aria-label="Текст ответа" v-model="value" v-on:keyup.enter="addOption">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" v-on:click="addOption">Добавить</button>
            </div>
        </div>
    </div>
</template>
<script>
    import ConstructorRadiobutton from './questions-components/ConstructorRadiobutton';

    export default {
        components: { ConstructorRadiobutton },
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
            deleteOption (index) {
                this.options.splice(index, 1);
            }
        }
    }
</script>