<script>
import Settings from '../objects/Settings.js';
</script>
<template>
    <layout-bottom-navigation>
        <div>
            <v-row class="mb-3">
                <v-col cols="12 d-flex justify-end">
                    <v-btn color="primary" dark @click="openDialog(typeOperationObj.create)">
                        Novo Evento
                    </v-btn>
                    <!-- Dialog -->
                    <dialog-event ref="dialogForm" :show="show" @closeDialog="closeDialog" :typeOperation="typeOperation" @close="closeDialog"></dialog-event>
                </v-col>
            </v-row>
            <!-- DataTable -->
            <v-data-table locale="pt" :headers="headers" :items="$page.props.events" item-key="name" class="elevation-1"
                :search="search" :custom-filter="filter" mobile-breakpoint>
                <template v-slot:top>
                    <v-row class="mt-1 pa-3">
                        <v-col cols="6">
                            <v-text-field v-model="search" lab  el="Buscar..."></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-select v-model="select" :items="items" item-text="text" item-value="value" label="Eventos"
                                solo></v-select>
                        </v-col>
                    </v-row>
                </template>
                <template v-slot:item.status_br="{ item }">
                    <v-chip :color="getColor(item.status_br)" dark>
                        {{ item.status_br }}
                    </v-chip>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mr-2" @click="openDialog(typeOperationObj.update, item)">
                        mdi-pencil
                    </v-icon>
                    <v-icon small>
                        mdi-delete
                    </v-icon>
                </template>
            </v-data-table>
            <!-- Alerts -->
            <alert-confirm ref="question_delete_event" :typeAlert="typeAlertObj.question"></alert-confirm>
            <alert-confirm :typeAlert="typeAlertObj.alert" :show="this.$page.props.flash.message.show"  :data="this.$page.props.flash.message" @close="closeAlert"></alert-confirm>
        </div>
    </layout-bottom-navigation>
</template>
<script>
import TypeOperation from '../enums/TypeOperation';
import TypeAlert from '../enums/TypeAlert';
import TypeAlertIcon from '../enums/TypeAlertIcon';

export default {

    data() {
        return {
            //tabela
            search: '',
            select: { text: 'Eventos deste ano', value: 'events_year' },
            items: [
                { text: 'Todos os eventos', value: 'events_all' },
                { text: 'Eventos deste ano', value: 'events_year' },
                { text: 'Eventos deste mês', value: 'events_month' },
            ],
            //dialog
            show: false,
            typeOperation: TypeOperation.create,
            typeOperationObj: TypeOperation,
            //alert
            typeAlertObj: TypeAlert,
            data_confirm: null,
        }
    },
    computed: {
        headers() { //cabeçalho da tabela
            return [
                { text: 'Status', value: 'status_br', },
                { text: 'Nome', value: 'name', },
                { text: 'Começo', value: 'date_start_formated' },
                { text: 'Fim', value: 'date_end_formated' },
                {
                    text: 'Ações',
                    value: 'actions',
                    sortable: false
                },
            ]
        },
    },
    methods: {
        //filtro da tabela - ajustar
        filter(value, search, item) {
            // console.log(value,item);
            // value = value.toLocaleLowerCase();
            // search = search.toLocaleLowerCase();
            return value != null &&
                search != null &&
                typeof value === 'string' &&
                value.toString().indexOf(search) !== -1
        },
        //cor status do evento
        getColor(status) {
            switch (status) {
                case 'Em andamento': return '#0D47A1'
                case 'Agendado': return 'yellow'
                case 'Concluído': return 'blue'
                case 'Cancelado': return 'red'
                default: return 'purple'
            }
        },
        //abrir dialog de create ou update
        openDialog(typeOperation, object = null){
            //define o tipo da operação
            this.typeOperation = typeOperation;
            this.event = null;
            this.show = true;
            //setando valores padrões do formulario
            this.$refs.dialogForm.defaultValuesForm();
            if(typeOperation == this.typeOperationObj.update && object){
                //caso update,abre dialog populado por event(object)
                this.$refs.dialogForm.updateOperation(typeOperation,object);
            }

        },
        //fechar dialog
        closeDialog() {
            this.show = false;
        },
        //fechar Alerts
        closeAlert(){
            this.$page.props.flash.message.show = false;
        },
    },
    mounted() {
    },
}
</script>
