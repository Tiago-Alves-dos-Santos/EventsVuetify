<template>
    <layout-bottom-navigation>
        <div>
            <v-row class="mb-3">
                <v-col cols="12 d-flex justify-end">
                    <v-btn color="primary" dark @click="openAlertQuestionTruncate">
                        Limpar tudo
                    </v-btn>
                </v-col>
            </v-row>
            <!-- DataTable -->
            <v-data-table locale="pt" :headers="headers" :items="$page.props.historics" item-key="name" class="elevation-1"
                :search="search" :custom-filter="filter" mobile-breakpoint>
            </v-data-table>
            <!-- Alerts -->
            <alert-confirm ref="question_delete_event" :typeAlert="typeAlertObj.question" :data="data_confirm"
                :yesCallback="truncate"></alert-confirm>

        </div>
    </layout-bottom-navigation>
</template>
<script>
import TypeAlert from '../enums/TypeAlert';
import TypeAlertIcon from '../enums/TypeAlertIcon';
import Settings from '../objects/Settings.js';
import { router } from '@inertiajs/vue2'
export default {

    data() {
        return {
            //tabela
            search: '',
            //alert
            typeAlertObj: TypeAlert,
            data_confirm: {},
        }
    },
    computed: {
        headers() { //cabeçalho da tabela
            return [
                { text: 'ID', value: 'id', },
                { text: 'Registro', value: 'registry', },
                { text: 'Data', value: 'created_at_formatted' },
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
        openAlertQuestionTruncate() {
            this.data_confirm = Settings.alertData('Atenção', 'Após limpar o histórico a ação não poderá ser revertida. Deseja prosseguir ?', TypeAlertIcon.question);
            this.$refs.question_delete_event.open();
        },
        truncate() {
            let route_url = this.$route('historic.truncate');
            router.delete(route_url, {
                onSuccess: page => {
                    this.$refs.question_delete_event.close();
                }
            });
        }
    },
    mounted() {
    },
}
</script>
