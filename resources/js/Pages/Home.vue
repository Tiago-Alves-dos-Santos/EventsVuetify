<template>
    <layout-bottom-navigation>
        <v-sheet tile height="54" class="d-flex">
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
        </v-sheet>
        <v-sheet height="600">
            <v-calendar ref="calendar" v-model="value" :weekdays="weekday" :type="type" :events="events"
                :event-overlap-threshold="30" :event-color="getEventColor" @change="getEvents" @click:event="clickEvent"></v-calendar>
        </v-sheet>
    </layout-bottom-navigation>
</template>
<script>
export default {
    data: () => ({
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
        value: '',
        events: [],
        colors: ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'],
    }),
    methods: {
        clickEvent(event){
            console.log(event);
        },
        props:{
        },
        getEvents({ start, end }) {

            this.events = [
                {
                    name: 'Evento 1',
                    details: 'Detalhes do Evento 1',
                    start: '2023-08-06T13:20:34',
                    end: '2023-08-06T23:59:59',
                    color: this.colors[this.rnd(0, this.colors.length - 1)],
                },
                {
                    name: 'Evento 2',
                    details: 'Detalhes do Evento 2',
                    start: '2023-08-10T00:00:00',
                    end: '2023-08-11T23:59:59',
                    color: this.colors[this.rnd(0, this.colors.length - 1)],
                },
            ];
        },
        getEventColor(event) {
            return event.color
        },
        rnd(a, b) {
            return Math.floor((b - a + 1) * Math.random()) + a
        },
    },
    mounted() {
    },
}
</script>
