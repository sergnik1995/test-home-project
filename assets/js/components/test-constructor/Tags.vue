<template>
    <div class="input-tag-group">
        <div class="tag-block" v-for="(tag, index) in tags" v-bind:key="tag.position">
            <input v-if="tag.tipId !== null" type="hidden" v-bind:name="'tags[' + index + '][id]'" v-bind:value="tag.tipId">
            <input class="p-2 m-1 border-0" v-model="tag.value" v-bind:name="'tags[' + index + '][name]'" pattern="\S+.*" required>
            <button type="button" class="btn btn-danger close" aria-label="Close"
                    v-on:click="removeTag(index)"><span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="input-tag" id="input-tag">
            <input class="p-1 form-control" placeholder="Добавить тег" id="addTag" tabindex="0"
                   v-model="value"
                   v-on:keyup.enter="addTag"
                   v-on:input="findTag"
            >
        </div>
        <div v-show="tips.length > 0" class="test-tips" id="test-tips">
            <ul class="list-group">
                <li class="list-group-item" v-for="tip in tips" v-on:click="chooseTip(tip)">{{ tip.value }}</li>
            </ul>
        </div>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                tags: [],
                nextTagId: 0,
                value: '',
                tipId: null,
                tips: [],
            }
        },
        methods: {
            addTag () {
                let value = this.value.toLowerCase().trim();

                if(value.length === 0) {
                    alert('Тег не должен быть пустым');
                    return;
                }

                let foundIndex = this.tags.find(function (tag) {
                    return value === tag.value;
                });

                if(foundIndex === undefined) {
                    this.tags.push({
                        value: value,
                        position: this.nextTagId++,
                        tipId: this.tipId
                    });
                } else {
                    alert('Такой тег уже есть');
                }

                this.value = '';
                this.tipId = null;
                this.tips = [];
            },
            removeTag (index) {
                this.tags.splice(index, 1);
                this.tips = [];
            },
            async findTag (event) {
                this.tips.splice(0, this.tips.length);

                let promise = await fetch('/api/findTag', {
                    method: 'POST',
                    body: 'tag=' + this.value,
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    }
                });

                if(promise.ok) {
                    let json = await promise.json();
                    let tips = this.tips;

                    if(json.data && json.data.length > 0) {

                        json.data.forEach(function (tip) {
                            tips.push({
                                value: tip.name,
                                id: tip.id
                            });
                        });

                        let inputTag = document.getElementById('input-tag');
                        let testTips = document.getElementById('test-tips');

                        testTips.style.left = inputTag.getBoundingClientRect().left + window.pageXOffset + 'px';
                        testTips.style.top = inputTag.getBoundingClientRect().top + window.pageYOffset + 'px';
                    }
                }
            },
            chooseTip (tip) {
                this.value = tip.value;
                this.tipId = tip.id;
                this.addTag();
            }
        }
    }
</script>
<style scoped>
    .input-tag {
        vertical-align: top;
        display: inline-block;
        background: #f6f6f6;
    }

    .tag-block {
        display: inline-block;
    }

    .test-tips {
        position: absolute;
    }
</style>