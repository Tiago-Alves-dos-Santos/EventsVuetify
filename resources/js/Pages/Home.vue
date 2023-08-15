<template>
    <layout-bottom-navigation>
        <v-sheet tile height="54" class="d-flex flex-column">
            <div style="width: 100%;" class="d-flex justify-center">
                <v-btn icon class="ma-2" @click="$refs.calendar.prev()">
                    <v-icon>mdi-chevron-left</v-icon>
                </v-btn>
                <v-select v-model="type" :items="types" item-text="text" item-value="value" dense outlined hide-details
                    class="ma-2" label="Formato"></v-select>
                <v-select v-model="weekday" :items="weekdays" dense outlined hide-details label="Semana"
                    class="ma-2"></v-select>
                <v-btn icon class="ma-2" @click="$refs.calendar.next()">
                    <v-icon>mdi-chevron-right</v-icon>
                </v-btn>
            </div>
            <div style="width: 100%; text-transform: uppercase;" class="d-flex flex-column align-center justify-center">
                {{ this.titleCalendar }}
                <v-btn color="primary" class="mt-2" @click="value = Date.now()">
                    Hoje
                </v-btn>
            </div>
        </v-sheet>
        <v-sheet height="600" style="margin-top: 90px;">
            <v-calendar ref="calendar" v-model="value" :weekdays="weekday" :type="type" :events="$page.props.events"
                :event-overlap-threshold="30" :event-color="getEventColor" :event-text-color="getEventTextColor"
                @change="getEvents" @click:event="clickEvent"></v-calendar>
        </v-sheet>
    </layout-bottom-navigation>
</template>
<script>
import Settings from '../objects/Settings';
export default {
    data() {
        return {
            type: 'month',
            types: [
                { text: 'Mês', value: 'month' },
                { text: 'Semana', value: 'week' },
                { text: 'Dia', value: 'day' },
                { text: '4 dias', value: '4day' },
            ],
            weekday: [0, 1, 2, 3, 4, 5, 6],
            weekdays: [
                { text: 'Domingo - Sabádo', value: [0, 1, 2, 3, 4, 5, 6] },
                { text: 'Segunda - Domingo', value: [1, 2, 3, 4, 5, 6, 0] },
                { text: 'Segunda - Sexta', value: [1, 2, 3, 4, 5] },
                { text: 'Segunda, Quarta, Sexta', value: [1, 3, 5] },
            ],
            value: Date.now(),
        }
    },
    computed: {
        titleCalendar() {
            let monthIndex = new Date(this.value).getMonth();
            let year = new Date(this.value).getFullYear();
            let monthNames = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format;
            return `${monthNames(new Date(0, monthIndex))} - ${year}`;
        }
    },
    methods: {
        clickEvent(event) {
            console.log(event);
        },
        props: {
        },
        getEvents({ start, end }) {

            let events_array = [];
            for (const propriedade in this.$page.props.events) {
                let events = {
                    status: this.$page.props.events[propriedade].status,
                    name: this.$page.props.events[propriedade].name + ' - ' + Settings.convertTimeString(this.$page.props.events[propriedade].time_end),
                    start: this.$page.props.events[propriedade].date_start + 'T' + this.$page.props.events[propriedade].time_start,
                    end: this.$page.props.events[propriedade].date_end + 'T' + this.$page.props.events[propriedade].time_end,
                    color: this.$page.props.events[propriedade].text_background,
                    textColor: this.$page.props.events[propriedade].text_color,
                }
                // console.log(new Date(this.$page.props.events[propriedade].date_end+'T'+this.$page.props.events[propriedade].time_end));

                events_array.push(events);
            }
            this.$page.props.events = events_array;

        },
        getEventColor(event) {
            return event.color
        },
        getEventTextColor(event) {
            return event.textColor
        },
        titleCalendar() {
            let monthIndex = new Date(this.value).getMonth();
            let monthNames = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format;
            return monthNames(new Date(0, monthIndex));
        },
    },
    mounted() {
        // console.log(this.$page.props.events);
    },
}
</script>
