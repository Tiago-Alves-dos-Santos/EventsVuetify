<template>
    <layout-bottom-navigation>
        <div>
            <v-row class="mb-3">
                <v-col cols="12 d-flex justify-end">
                    <v-btn color="primary" dark @click="show = true">
                        Novo Evento
                    </v-btn>

                    <dialog-event :show="show" @closeDialog="closeDialog" :typeOperation="typeOperation"></dialog-event>
                </v-col>
            </v-row>
            <v-data-table locale="pt" :headers="headers" :items="events" item-key="name" class="elevation-1"
                :search="search" :custom-filter="filter" mobile-breakpoint>
                <template v-slot:top>
                    <v-row class="mt-1 pa-3">
                        <v-col cols="6">
                            <v-text-field v-model="search" label="Buscar..."></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-select v-model="select" :items="items" item-text="text" item-value="value" label="Eventos"
                                solo></v-select>
                        </v-col>
                    </v-row>
                </template>
                <template v-slot:item.status="{ item }">
                    <v-chip :color="getColor(item.status)" dark>
                        {{ item.status }}
                    </v-chip>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mr-2">
                        mdi-pencil
                    </v-icon>
                    <v-icon small>
                        mdi-delete
                    </v-icon>
                </template>
            </v-data-table>
            <alert-confirm ref="question_delete_event" :typeAlert="typeAlertObj.question" :data="data_confirm"></alert-confirm>
            <!-- <alert-confirm :tipoAlerta="tipoAlerts.alert" :show="this.$page.props.flash.message.show"  :data="this.$page.props.flash.message" @evtClose="closeConfirm"></alert-confirm> -->
        </div>
    </layout-bottom-navigation>
</template>
<script>
import TypeOperation from '../enums/TypeOperation';
import TypeAlert from '../enums/TypeAlert';
import TypeAlertIcon from '../enums/TypeAlertIcon';
import Settings from '../objects/Settings.js';
export default {
    data() {
        return {
            //tabela
            search: '',
            events: [
                {
                    status: 'Em andamento',
                    name: 'Aniversario 1',
                    start: '02/02/2001 as 15',
                    end: '02/02/2001 as 16',
                },
                {
                    status: 'Concluido',
                    name: 'Reunião',
                    start: '02/03/2001 as 17',
                    end: '02/03/2001 as 18',
                },
            ],
            select: { text: 'Eventos deste ano', value: 'events_year' },
            items: [
                { text: 'Todos os eventos', value: 'events_all' },
                { text: 'Eventos deste ano', value: 'events_year' },
                { text: 'Eventos deste mês', value: 'events_month' },
            ],
            //dialog
            show: false,
            typeOperation: TypeOperation.create,
            //alert
            typeAlertObj: TypeAlert,
            data_confirm: ''
        }
    },
    computed: {
        headers() { //cabeçalho da tabela
            return [
                { text: 'Status', value: 'status', },
                { text: 'Nome', value: 'name', },
                { text: 'Começo', value: 'start' },
                { text: 'Fim', value: 'end' },
                {
                    text: 'Ações',
                    value: 'actions',
                    sortable: false
                },
            ]
        },
    },
    methods: {
        filter(value, search, item) {
            value = value.toLocaleLowerCase();
            search = search.toLocaleLowerCase();
            return value != null &&
                search != null &&
                typeof value === 'string' &&
                value.toString().indexOf(search) !== -1
        },
        getColor(status) {
            switch (status) {
                case 'Em andamento': return 'blue-grey'
                case 'Concluido': return 'green'
                default: return 'blue-grey'
            }
        },
        closeDialog() {
            this.show = false;
        },
        openAlert(){

        }
    },
}
</script>
