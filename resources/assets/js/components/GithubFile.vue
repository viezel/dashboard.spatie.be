<template>
    <grid :position="grid" modifiers="overflow padded blue">
        <section class="github-file">
            <h1 class="github-file__title">{{ fileName }}</h1>
            <div class="github-file__content" v-html="contents"></div>
        </section>
    </grid>
</template>

<script>
import echo from '../mixins/echo';
import Grid from './Grid';

export default {

    components: {
        Grid,
    },

    mixins: [echo],

    props: ['fileName', 'grid', 'initialState'],

    data() {
        return {
            contents: '',
        };
    },

    created() {
        this.contents = this.initialState[this.fileName];
    }

    methods: {
        getEventHandlers() {
            return {
                'GitHub.FileContentFetched': response => {
                    this.contents = response.fileContent[this.fileName];
                },
            };
        },

        getComponentName() {
            return 'githubFile';
        },
    },
};
</script>
