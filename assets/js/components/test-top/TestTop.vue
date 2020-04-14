<template>
    <div class="card">
        <div class="card-header">
            Топ тестов
        </div>
        <div class="card-body card-columns">
            <div v-for="(test, index) in tests" class="card">
                <div class="card-body" >
                    <h5 class="card-title">{{ test.name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">
                        <span v-for="tag in test.tags">
                            {{ '#' + tag.name }}
                        </span>
                    </h6>
                    <p class="card-text">{{ test.description }}</p>
                    <a v-bind:href="'/test/' + test.id" class="card-link">Пройти тест</a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                tests: []
            }
        },
        async created() {
            let promise = await fetch('/api/getTestsTop');

            if(promise.ok) {
                let json = await promise.json();
                let tests = this.tests;

                json.data.forEach(function (test) {
                    tests.push({
                        'id': test.id,
                        'name': test.name,
                        'description': test.description,
                        'tags': test.tags
                    });
                });
            }
        }
    }
</script>