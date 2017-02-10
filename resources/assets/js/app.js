import './bootstrap.js';

import Echo from 'laravel-echo';
import Vue from 'vue';

import CurrentTime from './components/CurrentTime';
import GithubFile from './components/GithubFile';
import GoogleCalendar from './components/GoogleCalendar';
import InternetConnection from './components/InternetConnection';
import LastFm from './components/LastFm';
import PackagistStatistics from './components/PackagistStatistics';
import RainForecast from './components/RainForecast';
import Twitter from './components/Twitter';
import NewRelicServer from './components/NewRelicServer';
import NewRelicRpm from './components/NewRelicRpm';
import GitLabBuilds from './components/GitLabBuilds';
import WunderlistTasks from './components/WunderlistTasks';
import BugsnagErrors from './components/BugsnagErrors';
import ZohoLatestPotentials from './components/ZohoLatestPotentials';
import ZohoWonPotentials from './components/ZohoWonPotentials';
import ZohoNewestEvents from './components/ZohoNewestEvents';
import ZohoSummaryEvents from './components/ZohoSummaryEvents';
import LaravelNews from './components/LaravelNews';

new Vue({

    el: '#dashboard',

    components: {
        CurrentTime,
        GithubFile,
        GoogleCalendar,
        InternetConnection,
        LastFm,
        PackagistStatistics,
        RainForecast,
        Twitter,
        NewRelicServer,
        NewRelicRpm,
        GitLabBuilds,
        WunderlistTasks,
        BugsnagErrors,
        ZohoLatestPotentials,
        ZohoWonPotentials,
        ZohoNewestEvents,
        ZohoSummaryEvents,
        LaravelNews,
    },

    created() {

        let options = {
            broadcaster: 'pusher',
            key: window.dashboard.pusherKey,
            cluster: window.dashboard.pusherCluster,
        };

        if (window.dashboard.usingNodeServer) {
            options = {
                broadcaster: 'socket.io',
                host: 'http://dashboard.spatie.be:6001',
            };
        }

        this.echo = new Echo(options);
    },
});
