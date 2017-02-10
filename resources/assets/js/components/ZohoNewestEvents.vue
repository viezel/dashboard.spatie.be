<template>
    <grid :position="grid" modifiers="overflow padded">
       <section class="zoho_newest_event">
           <h1 class="zoho_newest_events__title">Newest Events</h1>
           <ul class="zoho_newest_events">
               <li v-for="item in items"  class="zoho_newest_event">
                   <h5 class="zoho_newest_event__title">{{ item.subject }}</h5>
                   <div class="zoho_newest_event__data"><small>By:</small> {{ item.user }} | {{ item.eventDate }}</div>
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
            items: [],
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'Zoho.NewestEventsFetched': response => {
                    this.items = response.events;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'zoho-newest-events',
            };
        },
    },
};
</script>
