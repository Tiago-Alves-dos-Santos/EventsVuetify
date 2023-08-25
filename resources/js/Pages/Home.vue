<template>
    <layout-bottom-navigation>
        <div class="w-100" id="home">
            <v-sheet tile height="54" class="d-flex flex-column">
                <v-row>
                    <v-col sm="12" md="12">
                        <div style="width: 100%;" class="container_calendar_navigation">
                            <v-btn icon class="ma-2" @click="$refs.calendar.prev()">
                                <v-icon>mdi-chevron-left</v-icon>
                            </v-btn>
                            <v-select v-model="type" :items="types" item-text="text" item-value="value" dense outlined
                                hide-details class="ma-2" label="Formato"></v-select>
                            <v-select v-model="weekday" :items="weekdays" dense outlined hide-details label="Semana"
                                class="ma-2"></v-select>
                            <v-btn icon class="ma-2" @click="$refs.calendar.next()">
                                <v-icon>mdi-chevron-right</v-icon>
                            </v-btn>
                        </div>
                    </v-col>
                </v-row>
                <v-row>
                    <div class="container_calendar_navigation_sm">
                        <!-- Botoes de navegação - breakpoint SM -->
                        <div class="arrow_navigation">
                            <v-col>
                                <v-btn icon class="ma-2" @click="$refs.calendar.prev()">
                                    <v-icon>mdi-chevron-left</v-icon>
                                </v-btn>
                                <v-btn icon class="ma-2" @click="$refs.calendar.next()">
                                    <v-icon>mdi-chevron-right</v-icon>
                                </v-btn>
                            </v-col>
                        </div>
                        <!-- FIM Botoes de navegação - breakpoint SM -->
                        <div class="info_navigation">
                            <span>{{ this.titleCalendar }}</span>
                            <v-btn color="primary" class="mt-2" @click="$page.props.valueCalendar = Date.now()">
                                Hoje
                            </v-btn>
                        </div>
                    </div>
                </v-row>
            </v-sheet>
            <v-row>
                <v-col cols="12">
                    <v-sheet height="600" class="row_calendar">
                        <v-calendar ref="calendar" v-model="$page.props.valueCalendar" color="primary" :weekdays="weekday"
                            :type="type" :events="$page.props.events" :event-overlap-threshold="30"
                            :event-color="getEventColor" :event-text-color="getEventTextColor" @change="getEvents"
                            @click:event="clickEvent" @click:more="showMore" @click:date="showMore"></v-calendar>
                    </v-sheet>
                </v-col>
            </v-row>
        </div>
    </layout-bottom-navigation>
</template>
<script>
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
        }
    },
    computed: {
        titleCalendar() {//retorna o mês e o ano do calendario, como string
            let monthIndex = new Date(this.$page.props.valueCalendar).getUTCMonth();
            let year = new Date(this.$page.props.valueCalendar).getFullYear();
            let monthNames = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format;
            return `${monthNames(new Date(0, monthIndex))} - ${year}`;
        }
    },
    methods: {
        clickEvent({ day: { date } }) {//clicar no evento do calendario, não implementada
            this.$page.props.valueCalendar = date;
            this.type = 'day';
        },
        //retornando o evento em mudança de calendario
        getEvents({ end }) {
            this.$page.props.events;
        },
        //cores do evento
        getEventColor(event) {
            return event.color
        },
        getEventTextColor(event) {
            return event.textColor
        },
        showMore({ date }) {
            this.$page.props.valueCalendar = date;
            this.type = 'day';
        }
    },
    mounted() {
    },
}
</script>
