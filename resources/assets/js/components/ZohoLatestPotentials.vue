<template>
    <grid :position="grid" modifiers="overflow padded">
       <section class="zoho_latest_potential">
           <h1 class="zoho_latest_potentials__title">Newest Potentials</h1>
           <ul class="zoho_latest_potentials">
               <li v-for="item in items"  class="zoho_latest_potential">
                   <h4 class="zoho_latest_potential__title">{{ item.accountName }} | {{ item.amount }} kr.</h4>
                   <div class="zoho_latest_potential__data"><small>By:</small> {{ item.user }} | {{ item.probability }}% | {{ item.closingDate }}</div>
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
                'Zoho.LatestPotentialsFetched': response => {
                    this.items = response.potentials;
                },
            };
        },

        getSaveStateConfig() {
            return {
                cacheKey: 'zoho-latest-potentials',
            };
        },
    },
};
</script>
