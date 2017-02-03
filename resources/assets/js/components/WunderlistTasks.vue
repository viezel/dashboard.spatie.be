<template>
    <grid :position="grid" modifiers="overflow">
       <section class="wunderlist">
           <h1 class="wunderlist__title">Lunch Wishes</h1>
           <ul class="wunderlist_tasks">
               <li v-for="task in tasks" class="wunderlist_task">
                   <p class="wunderlist__task_title">{{ task.title }}</p>
               </li>
           </ul>
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
            tasks: [],
        };
    },

    methods: {

        getEventHandlers() {
            return {
                'Wunderlist.TaskFetched': response => {
                    this.tasks = response.tasks;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'wunderlist-task',
            };
        },
    },
};
</script>
