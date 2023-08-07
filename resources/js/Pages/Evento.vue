<template>
    <layout-bottom-navigation>
        <div class="mt-2">
            <v-data-table locale="pt" :headers="headers" :items="events" item-key="name" class="elevation-1" :search="search"
                :custom-filter="filter" mobile-breakpoint >
                <template v-slot:top>
                    <v-row class="p-3">
                        <v-col cols="6">
                            <v-text-field v-model="search" label="Buscar..."></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-select v-model="select" :items="items" item-text="text" item-value="value"
                                label="Eventos"></v-select>
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
                <template v-slot:body.append>
                    <tr>
                        <td></td>
                        <td>
                            <v-text-field v-model="calories" type="number" label="Less than"></v-text-field>
                        </td>
                        <td colspan="4"></td>
                    </tr>
                </template>
            </v-data-table>
        </div>
    </layout-bottom-navigation>
</template>
<script>
export default {
    data() {
        return {
            search: '',
            calories: '',
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
        }
    },
    computed: {
        headers() {
            return [
                { text: 'Status', value: 'status', },
                { text: 'Nome', value: 'name', },
                { text: 'Começo', value: 'start' },
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
    },
}
</script>
