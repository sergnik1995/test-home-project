<template>
    <div class="card-body" id="constructor-body">
        <div class="question border p-3 mb-3" v-for="(question, index) in questions" v-bind:key="question.position">
            <test-question
                    v-bind:position="index + 1"
                    v-bind:upQuestion="upQuestion"
                    v-bind:downQuestion="downQuestion"
            ></test-question>
            <button type="button"
                    class="btn btn-danger"
                    v-on:click="deleteQuestion(index)"
            >Удалить вопрос</button>
        </div>
        <button type="button" class="btn btn-primary" v-on:click="addQuestion()">Добавить вопрос</button>
        <button type="button" class="btn btn-primary" v-if="questions.length > 0" v-on:click="submit">Создать тест</button>
    </div>
</template>
<script>
    import TestQuestion from './TestQuestion';

    export default {
        data () {
            return {
                questions: [],
                nextQuestionId: 0
            }
        },
        components: { TestQuestion },
        methods: {
            addQuestion: function () {
                this.questions.push({
                    position: this.nextQuestionId++
                });
            },
            deleteQuestion: function (index) {
                this.questions.splice(index, 1);
            },
            upQuestion: function (index) {
                if(index > 0) {
                    this.questions.splice(index - 1, 2, this.questions[index], this.questions[index - 1]);
                }
            },
            downQuestion: function (index) {
                if(index < this.questions.length - 1) {
                    this.questions.splice(index, 2, this.questions[index + 1], this.questions[index]);
                }
            },
            submit: function () {
                this.validateCheckboxGroup();
                this.validateRadiobuttonGroup();
                this.validateTextOptionGroup();

                let form = document.body.querySelector('form');

                if(form.reportValidity()) {
                    let formData = new FormData(form);

                    fetch('/create-test', {
                        method: 'POST',
                        body: formData,
                    }).then(function (response) {
                        if(response.redirected) {
                            window.location.href = response.url;
                        }
                    });
                }
            },
            validateCheckboxGroup: function () {
                document.body.querySelectorAll('.few-from-list').forEach(function (element) {
                    if(element.querySelectorAll('input[type="checkbox"]').length === 0) {
                        element.querySelector('.few-from-list__input').setCustomValidity('Добавьте хотя бы один вариант');
                    } else {
                        element.querySelector('.few-from-list__input').setCustomValidity('');
                        let firstCheckbox = element.querySelector('input[type="checkbox"]');

                        if(element.querySelectorAll('input[type="checkbox"]:checked').length === 0) {
                            firstCheckbox.setCustomValidity('Выберите хотя бы один вариант');
                        } else {
                            firstCheckbox.setCustomValidity('');
                        }
                    }
                });
            },
            validateRadiobuttonGroup: function () {
                document.body.querySelectorAll('.one-from-list').forEach(function (element) {
                    if(element.querySelectorAll('input[type="radio"]').length === 0) {
                        element.querySelector('.one-from-list__input').setCustomValidity('Добавьте хотя бы один вариант');
                    } else {
                        element.querySelector('.one-from-list__input').setCustomValidity('');
                    }
                });
            },
            validateTextOptionGroup: function () {
                document.body.querySelectorAll('.text-option').forEach(function (element) {
                    if(element.querySelectorAll('.text-option__option').length === 0) {
                        element.querySelector('.text-option__input').setCustomValidity('Добавьте хотя бы один вариант');
                    } else {
                        element.querySelector('.text-option__input').setCustomValidity('');
                    }
                });
            }
        }
    }
</script>