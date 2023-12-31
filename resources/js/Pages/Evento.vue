<template>
    <layout-bottom-navigation>
        <div>
            <v-row class="mb-3">
                <v-col cols="12 d-flex justify-center justify-md-end  flex-wrap">
                    <v-btn :color="$page.props.visibleDeletedEvents ? 'green darken-4' : 'deep-orange darken-4'"
                        class="mr-2 mt-2" style="color:white" @click="toggleDeletedEvents"
                        :loading="loads.visibleDeletedEvents" :disabled="loads.visibleDeletedEvents">
                        {{ $page.props.visibleDeletedEvents ? 'Ativos' : 'Deletados' }}
                    </v-btn>
                    <v-btn color="primary" class="mr-2 mt-2" @click="reload()" :loading="loads.reload"
                        :disabled="loads.reload">
                        Recarregar / Limpar filtro
                    </v-btn>
                    <v-btn color="primary" class="mt-2" @click="openDialog(typeOperationObj.create)">
                        Novo Evento
                    </v-btn>
                    <!-- Dialog -->
                    <dialog-event ref="dialogForm" :show="show" :typeOperation="typeOperation" @close="closeDialog"
                        @openAlert="openAlert" :eventStatus="$page.props.eventStatus"
                        @cancelEventQuestion="cancelEventQuestion"></dialog-event>
                </v-col>
            </v-row>
            <!-- DataTable -->
            <v-data-table locale="pt" :headers="headers" :items="$page.props.events" item-key="name" class="elevation-1"
                :search="search" :custom-filter="filter" :loading="loads.dataTable" loading-text="Aguarde..."
                >
                <template v-slot:top>
                    <v-row class="mt-1 pa-3">
                        <v-col cols="12" sm="6" md="6">
                            <v-text-field v-model="search" label="Buscar..."></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="6">
                            <v-select v-model="select" :items="items" item-text="text" item-value="value" label="Eventos"
                                solo @change="getEventsTime"></v-select>
                        </v-col>
                    </v-row>
                </template>
                <template v-slot:item.status_br="{ item }">
                    <v-chip :color="getColor(item.status_br)" dark>
                        {{ item.status_br }}
                    </v-chip>
                </template>
                <div>

                </div>
                <template v-slot:item.actions="{ item }">
                    <div v-if="!$page.props.visibleDeletedEvents">
                        <v-icon small class="" @click="openDialog(typeOperationObj.update, item)">
                            mdi-pencil
                        </v-icon>
                        <v-icon small @click="deleteEventQuestion(item)">
                            mdi-delete
                        </v-icon>
                        <v-tooltip top v-if="item.status != $page.props.eventStatus.CANCELED">
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon small v-bind="attrs" v-on="on" @click="eventForCalendar(item)">
                                    mdi-calendar-clock
                                </v-icon>
                            </template>
                            <span>Ver no calendário</span>
                        </v-tooltip>
                    </div>
                    <div v-else>
                        <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon small v-bind="attrs" v-on="on" @click="restoreQuestion(item)">
                                    mdi-delete-restore
                                </v-icon>
                            </template>
                            <span>Restaurar</span>
                        </v-tooltip>
                    </div>
                </template>
            </v-data-table>
            <!-- Alerts -->
            <alert-confirm ref="alert_question" :typeAlert="typeAlertObj.question" :data="data_confirm"
                :yesCallback="functionCallback"></alert-confirm>
            <!-- alerta chamado via js -->
            <alert-confirm ref="alert_client" :typeAlert="typeAlertObj.alert" :data="data_confirm_alert"></alert-confirm>
            <!-- alerta vindo do inertia - flash messages -->
            <alert-confirm :typeAlert="typeAlertObj.alert" :show="this.$page.props.flash.message.show"
                :data="this.$page.props.flash.message" @close="closeAlert"></alert-confirm>
        </div>
    </layout-bottom-navigation>
</template>
<script>
import TypeOperation from '../enums/TypeOperation';
import TypeAlert from '../enums/TypeAlert';
import TypeAlertIcon from '../enums/TypeAlertIcon';
import Settings from '../objects/Settings.js';
import { router } from '@inertiajs/vue2'
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
                { text: 'Eventos futuros', value: 'events_future' },
            ],
            //loads
            loads: {
                reload: false,
                visibleDeletedEvents: false,
                dataTable: false
            },
            //dialog
            show: false,
            typeOperation: TypeOperation.create,
            typeOperationObj: TypeOperation,
            //alert
            typeAlertObj: TypeAlert,
            data_confirm: {},
            data_confirm_alert: {},
            functions: {
                deleteEvent: 'deleteEvent',
                cancelEvent: 'cancelEvent',
                restoreEvent: 'restoreEvent',
            },
            functionCallback: null,
            //model
            event: {},
            //mostrar registros deletados
            visibleDeletedEvents: false,
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
                case 'Em andamento': return '#896c4f'
                case 'Agendado': return '#0D47A1'
                case 'Concluído': return 'green'
                case 'Cancelado': return 'red'
                default: return 'purple'
            }
        },
        //abrir dialog de create ou update
        openDialog(typeOperation, object = null) {
            this.$refs.dialogForm.defaultValuesForm();
            this.typeOperation = typeOperation;
            this.event = null;
            this.show = true;
            if (typeOperation == this.typeOperationObj.update && object) {
                //caso update,abre dialog populado por event(object)
                this.$refs.dialogForm.updateOperation(typeOperation, object);
            }

        },
        //fechar dialog
        closeDialog() {
            this.show = false;
        },
        //fechar Alerts
        closeAlert() {
            this.$page.props.flash.message.show = false;
        },
        openAlert(object = null) {
            this.data_confirm_alert = object;
            this.$refs.alert_client.open();
        },
        cancelEventQuestion(event) {
            this.event = event;
            this.functionCallback = this.manageAlertFunctions(this.functions.cancelEvent);
            this.data_confirm = Settings.alertData(
                'Atenção!',
                "Deseja prosseguir com o cancelamento do evento: " + event.name + "? <br> Após o cancelamento do evento não é possivel reverter.",
                TypeAlertIcon.question
            );
            this.$refs.alert_question.open();
        },
        cancelEvent() {
            let route_url = this.$route('event.cancel');
            router.put(route_url, { id: this.event.id }, {
                onSuccess: () => {
                    this.$refs.alert_question.close();
                    this.closeDialog();
                }
            });
        },
        deleteEventQuestion(event) {
            this.event = event;
            this.functionCallback = this.manageAlertFunctions(this.functions.deleteEvent);
            this.data_confirm = Settings.alertData('Atenção!', 'Deseja prosseguir com a deleção do evento: ' + event.name + '?', TypeAlertIcon.question);
            this.$refs.alert_question.open();
        },
        deleteEvent() {
            let route_url = this.$route('event.delete', { id: this.event.id });
            router.delete(route_url, {
                onSuccess: () => {
                    this.$refs.alert_question.close();
                }
            });
        },
        restoreQuestion(event) {
            this.event = event;
            this.functionCallback = this.manageAlertFunctions(this.functions.restoreEvent);
            this.data_confirm = Settings.alertData('Atenção!', 'Deseja restaurar o evento: ' + event.name + '?', TypeAlertIcon.question);
            this.$refs.alert_question.open();
        },
        restoreEvent() {
            let route_url = this.$route('event.restore');
            router.put(route_url, { id: this.event.id }, {
                onSuccess: () => {
                    this.$refs.alert_question.close();
                }
            });
        },
        manageAlertFunctions(value) {
            if (typeof this[value] === 'function') {
                return this[value]; // Chama a função pelo nome passado como valor, necessarios existir no methods
            } else {
                this.data_confirm_alert = Settings.alertData('Erro: manageAlertFunctions', 'O valor ' + value + ' não se encaixa como uma função', TypeAlertIcon.error);
                this.$refs.alert_client.open();
            }
        },
        eventForCalendar(event) {
            let route_url = this.$route('index');
            router.get(route_url, { valueCalendar: event.date_start });
        },
        reload() {
            router.get(this.$route('event.viewEvents'), {}, {
                onStart: () => this.loads.reload = true,
                onFinish: () => this.loads.reload = false,
            });
        },
        toggleDeletedEvents() {
            this.$page.props.visibleDeletedEvents = !this.$page.props.visibleDeletedEvents;
            let value = this.$page.props.visibleDeletedEvents;
            if (this.$page.props.visibleDeletedEvents == false) {//ativos
                value = '';
            }
            router.get(this.$inertia.page.url, { visibleDeletedEvents: value }, {
                preserveState: true,
                onStart: () => {
                    this.loads.visibleDeletedEvents = true;
                    this.loads.dataTable = true;
                },
                onFinish: () => {
                    this.loads.visibleDeletedEvents = false;
                    this.loads.dataTable = false;
                }
            });
        },
        getEventsTime() {
            router.get(this.$inertia.page.url, { eventTimeFilter: this.select }, {
                preserveState: true,
                onStart: () => this.loads.dataTable = true,
                onFinish: () => this.loads.dataTable = false,
            });
        }
    },

    mounted() {
    },
}
</script>
