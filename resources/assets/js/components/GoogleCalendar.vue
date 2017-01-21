<template>
    <grid :position="grid" modifiers="overflow padded blue">
       <section class="google-calendar">
           <h1 class="google-calendar__title">Upcoming</h1>
           <ul class="google-calendar__events">
               <li v-for="event in events"  class="google-calendar__event">
                   <h2 class="google-calendar__event__title">{{ event.name }}</h2>
                   <div class="google-calendar__event__date">{{ relativeDate(event.date) }}</div>
               </li>
           </ul>
       </section>
    </grid>
</template>

<script>
import { relativeDate } from '../helpers';
import echo from '../mixins/echo';
import Grid from './Grid';
import initialState from '../mixins/initialState';

export default {

    components: {
        Grid,
    },

    mixins: [echo],

    props: ['grid', 'initialState'],

    data() {
        return {
            events: [],
        };
    },

    created() {
        this.events = this.initialState;
    }

    methods: {
        relativeDate,

        getEventHandlers() {
            return {
                'GoogleCalendar.EventsFetched': response => {
                    this.events = response.events;
                },
            };
        },
    },
};
</script>
