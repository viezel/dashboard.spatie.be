<template>
    <grid :position="grid" modifiers="overflow padded">
       <section class="gitlab__build">
           <h1 class="gitlab__builds__title">GitLab Builds</h1>
           <ul class="gitlab__builds">
               <li v-for="build in builds"  class="gitlab__build">
                   <h4 class="gitlab__build__title"><span class="gitlab__build__status" v-bind:class="[build.status]"></span> {{ build.project_name }}</h4>
                   <div class="gitlab__build__data"><small>By:</small> {{ build.user }} | <small>Cov:</small> {{ build.coverage }}%</div>
               </li>
           </ul>
       </section>
    </grid>
</template>

<script>
import { relativeDate } from '../helpers';
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
            builds: [],
        };
    },

    methods: {
        relativeDate,

        getEventHandlers() {
            return {
                'GitLab.BuildFetched': response => {
                    this.builds = response.builds;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'gitlab__build',
            };
        },
    },
};
</script>
