<template>
    <grid :position="grid" modifiers="padded transparent">
        <section class="new_relic">
            <h1>Throughput - {{ average }} RPM</h1>

            <div class="new_relic_rpm__graph" style="height:90%">
                <graph
                  :labels="graphLabels"
                  :values="graphData"
                  displayAxes=true
                  line-color="rgba(19,134,158, .5)"
                  background-color="rgba(19,134,158, .25)"
                ></graph>
            </div>
        </section>
    </grid>
</template>

<script>
import { filter, map, sumBy } from 'lodash';
import echo from '../mixins/echo';
import Graph from './Graph';
import Grid from './Grid';
import { addClassModifiers } from '../helpers';

export default {

    components: {
        Grid,
        Graph,
    },

    mixins: [echo],

    props: ['grid'],

    computed: {

        graphLabels() {
            return map(this.points, 'label');
        },

        graphData() {
            return map(this.points, 'value');
        },
    },

    data() {
        return {
            points: [],
            average: 0,
        };
    },

    methods: {
        addClassModifiers,

        getEventHandlers() {
            return {
                'Relic.RPMFetched': response => {
                    this.points = response.points;
                    this.average = response.average;
                },
            };
        },
    },
};
</script>
