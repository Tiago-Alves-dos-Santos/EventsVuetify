<template>
    <v-app app>
        <v-bottom-navigation v-model="this.$page.props.pageValue" :background-color="color" dark shift absolute>
            <v-btn @click="navigateUrl($route('index'))" value='index'>
                <span>Calendário</span>
                <v-icon>mdi-calendar-clock</v-icon>
            </v-btn>

            <v-btn @click="navigateUrl($route('event.viewEvents'))" value="event.viewEvents">
                <span>Eventos</span>
                <v-icon>mdi-calendar-plus</v-icon>
            </v-btn>

            <v-btn @click="navigateUrl($route('historic.index'))" value="historic.index">
                <span>Histórico</span>
                <v-icon>mdi-history</v-icon>
            </v-btn>
        </v-bottom-navigation>
        <v-container style="margin-bottom: 90px;">
            <slot></slot>
        </v-container>
    </v-app>
</template>
<script>
import { router } from '@inertiajs/vue2';

export default {
    data(){
        return{

        }
    },
    methods: {
        navigateUrl(url) {
            router.get(url);
        }
    },
    computed: {
        color() {
            switch (this.$page.props.pageValue) {
                case 'index': return 'indigo darken-4'
                case 'event.viewEvents': return 'pink darken-4'
                case 'historic.index': return 'purple darken-4'
                default: return 'blue-grey'
            }
        },
    },
    mounted() {
    },
}
</script>
