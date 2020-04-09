<template>
    <div>
        <div class="card-header">
            Создать тест.
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="test-name">Название теста</label>
                <input class="form-control" id="test-name" aria-describedby="test-name-help" name="name" pattern="\S+.*" required>
                <small id="test-name-help" class="form-text text-muted">Максимальное число символов - 40.</small>
            </div>
            <div class="form-group">
                <label for="test-time">Время необходимое для выполнения теста</label>
                <input type="number" class="form-control" min="0" id="test-time" max="600" step="1" value="0" aria-describedby="test-time-help" name="time" pattern="\S+.*" required>
                <small id="test-time-help" class="form-text text-muted">Время необходимое для выполнения теста в минутах. 0 - нет ограничения по времени</small>
            </div>
            <div class="form-group">
                <label for="test-description">Описание теста</label>
                <input class="form-control" id="test-description" aria-describedby="test-description-help" pattern="\S+.*" name="description">
                <small id="test-description-help" class="form-text text-muted">Максимальное число символов - 500.</small>
            </div>
            <div class="form-group">
                <label for="tags">Теги</label>
                <tags id="tags"></tags>
            </div>
        </div>
    </div>
</template>
<script>
    import Tags from './Tags';

    export default {
        components: { Tags },

    }
</script>