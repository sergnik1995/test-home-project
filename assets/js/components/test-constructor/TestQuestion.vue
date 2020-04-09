<template>
    <div>
        <div class="form-group">
            <h5>Вопрос №{{ position }}</h5>
            <div>
                <button type="button" class="btn btn-secondary" v-on:click="upQuestion(position - 1)">&#11014;</button>
                <button type="button" class="btn btn-secondary" v-on:click="downQuestion(position - 1)">&#11015;</button>
            </div>
            <label>Число баллов</label>
            <input class="form-control" type="number" min="0" max="1000000" v-bind:name="'questions['+position+'][points]'" value="1">
            <label>Текст вопроса</label>
            <textarea class="form-control" minlength="1" maxlength="1000" v-bind:name="'questions['+position+'][question]'" rows="3" pattern="\S+.*" required></textarea>
            <label>Тип ответа</label>
            <select class="form-control" v-model="selected" v-bind:name="'questions['+position+'][type]'" required>
                <option v-for="option in options" v-bind:value="option.value">
                    {{ option.text }}
                </option>
            </select>
        </div>
        <div class="form-group" v-if="selected === 'one-from-list'">
            <one-from-list v-bind:question-position="position"></one-from-list>
        </div>
        <div class="form-group" v-else-if="selected === 'few-from-list'">
            <few-from-list v-bind:question-position="position"></few-from-list>
        </div>
        <div class="form-group" v-else-if="selected === 'number'">
            <number-option v-bind:question-position="position"></number-option>
        </div>
        <div class="form-group" v-else-if="selected === 'text'">
            <text-option v-bind:question-position="position"></text-option>
        </div>
    </div>
</template>
<script>
    import OneFromList from './question-types/OneFromList';
    import FewFromList from './question-types/FewFromList';
    import NumberOption from './question-types/NumberOption';
    import TextOption from "./question-types/TextOption";

    export default {
        components: { FewFromList, OneFromList, NumberOption, TextOption },
        props: {
            position: Number,
            upQuestion: Function,
            downQuestion: Function
        },
        data () {
            return {
                selected: '1',
                options: [
                    { text: 'Один ответ из списка', value: 'one-from-list'},
                    { text: 'Несколько вариантов из списка', value: 'few-from-list'},
                    { text: 'Ввод числа (с указанием погрешности)', value: 'number'},
                    { text: 'Ввод текста', value: 'text'}
                ],
            }
        }
    }
</script>