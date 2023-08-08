<template>
    <v-app app>
        <v-bottom-navigation v-model="this.$page.props.pageValue" :background-color="color" dark shift absolute>
            <v-btn @click="navigateUrl($route('event.index'))">
                <span>Calendário</span>
                <v-icon>mdi-calendar-clock</v-icon>
            </v-btn>

            <v-btn @click="navigateUrl($route('event.events'))">
                <span>Eventos</span>
                <v-icon>mdi-calendar-plus</v-icon>
            </v-btn>

            <v-btn>
                <span>Histórico</span>
                <v-icon>mdi-history</v-icon>
            </v-btn>

            <v-btn>
                <span>Lixeira</span>
                <v-icon>mdi-trash-can-outline</v-icon>
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
                case 0: return 'blue-grey'
                case 1: return 'teal'
                case 2: return 'brown'
                case 3: return 'indigo'
                default: return 'blue-grey'
            }
        },
    },
    mounted() {
    },
}
</script>
