<template>
    <grid :position="grid" modifiers="overflow">
       <section class="laravel-news">
           <!--<h1 class="laravel-news__title">Laravel News</h1>-->
           <section class="laravel-news__news-items">
               <div v-for="item in news" :style="{ 'background-image': 'url(' + item.image + ')' }">
                   <p class="date">{{ item.date }}</p>
                   <p class="title">{{ item.title }}</p>
                   <!--<p class="description">{{ item.description }}</p>-->
               </div>
           </section>

       </section>
    </grid>
</template>

<script>
import echo from '../mixins/echo';
import Grid from './Grid';
import saveState from 'vue-save-state';

export default {

    components: {
        Grid,
    },

    mixins: [echo, saveState],

    props: ['grid'],

    data() {
        return {
            news: [],
        };
    },

    methods: {

        getEventHandlers() {
            return {
                'LaravelNews.NewsFetched': response => {
                    this.news = response.news;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'laravel-news',
            };
        },
    },
};
</script>
