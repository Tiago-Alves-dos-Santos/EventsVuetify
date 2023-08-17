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
                <v-btn color="primary" class="mt-2" @click="$page.props.valueCalendar = Date.now()">
                    Hoje
                </v-btn>
            </div>
        </v-sheet>
        <v-sheet height="600" style="margin-top: 90px;">
            <v-calendar ref="calendar" v-model="$page.props.valueCalendar" color="primary" :weekdays="weekday" :type="type" :events="$page.props.events"
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
            //valores de select, modificar calendario
            types: [
                { text: 'Mês', value: 'month' },
                { text: 'Semana', value: 'week' },
                { text: 'Dia', value: 'day' },
                { text: '4 dias', value: '4day' },
            ],
            weekdays: [
                { text: 'Domingo - Sabádo', value: [0, 1, 2, 3, 4, 5, 6] },
                { text: 'Segunda - Domingo', value: [1, 2, 3, 4, 5, 6, 0] },
                { text: 'Segunda - Sexta', value: [1, 2, 3, 4, 5] },
                { text: 'Segunda, Quarta, Sexta', value: [1, 3, 5] },
            ],
            //valores de calendario
            type: 'month',
            weekday: [0, 1, 2, 3, 4, 5, 6],
            // value: Date.now(),
        }
    },
    computed: {
        titleCalendar() {//retorna o mês e o ano do calendario, como string
            let monthIndex = new Date(this.$page.props.valueCalendar).getMonth();
            let year = new Date(this.$page.props.valueCalendar).getFullYear();
            let monthNames = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format;
            return `${monthNames(new Date(0, monthIndex))} - ${year}`;
        }
    },
    methods: {
        clickEvent(event) {//clicar no evento do calendario, não implementada
            console.log(event);
        },
        //retornando o evento em mudança de calendario
        getEvents({ start, end }) {
            this.$page.props.events;
        },
        //cores do evento
        getEventColor(event) {
            return event.color
        },
        getEventTextColor(event) {
            return event.textColor
        },
    },
    mounted() {
        // console.log(this.$page.props.events);
    },
}
</script>
