<template>
    <grid :position="grid" modifiers="overflow padded">
       <section class="zoho_summary_event">
           <h1 class="zoho_summary_events__title">Meeting Booked</h1>
           <ul class="zoho_summary_events">
               <li v-for="item in items"  class="zoho_summary_event">
                   <h5 class="zoho_summary_event__title">{{ item.user }}</h5>
                   <div class="zoho_summary_event__data">Siesta: {{ item.siesta }} | Partner: {{ item.partner }} | Total: {{ item.total }}</div>
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
                'Zoho.SummaryEventsFetched': response => {
                    this.items = response.events;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'zoho-summary-events',
            };
        },
    },
};
</script>
