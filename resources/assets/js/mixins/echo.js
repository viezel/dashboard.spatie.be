import { forIn } from 'lodash';

export default {
    created() {
        forIn(this.getEventHandlers(), (handler, eventName) => {
            this.$root.echo
                .private('dashboard')
                .listen(`.App.Events.${eventName}`, eventName => handler(eventName));

            this.$root.echo
                .private('sales-dashboard')
                .listen(`.App.Events.${eventName}`, eventName => handler(eventName));
        });
    },
};
