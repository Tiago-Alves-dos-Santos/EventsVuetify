<template>
    <v-dialog v-model="this.show" width="800" @click:outside="$emit('closeDialog')">
        <v-card>
            <v-card-title class="text-h5 grey lighten-2">
                {{ dataTypeOperation.create == typeOperation ? 'Cadastro Evento' : 'Atualizar Evento' }}
            </v-card-title>

            <v-card-text>
                <v-container>
                    <v-form ref="form">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field label="Nome" tabindex="1"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <v-menu v-model="menu[0]" :close-on-content-click="false" :nudge-right="40"
                                    transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="pickerInputStartDateFormatted" label="Começo"
                                            prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker v-model="form.pickerInputStart" @input="menu[0] = false"></v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="6">
                                <v-menu ref="menu1" v-model="menu[1]" :close-on-content-click="false" :nudge-right="40"
                                    :return-value.sync="form.time_start" transition="scale-transition" offset-y
                                    max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="form.time_start" label="Hora"
                                            prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs"
                                            v-on="on"></v-text-field>
                                    </template>
                                    <v-time-picker v-if="menu[1]" v-model="form.time_start" full-width
                                        @click:minute="$refs.menu1.save(form.time_start)"></v-time-picker>
                                </v-menu>

                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <v-menu v-model="menu[2]" :close-on-content-click="false" :nudge-right="40"
                                    transition="scale-transition" offset-y min-width="auto">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="pickerInputEndDateFormatted" label="Fim"
                                            prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker v-model="form.pickerInputEnd" @input="menu[2] = false"></v-date-picker>
                                </v-menu>
                            </v-col>
                            <v-col cols="6">
                                <v-menu ref="menu3" v-model="menu[3]" :close-on-content-click="false" :nudge-right="40"
                                    :return-value.sync="form.time_end" transition="scale-transition" offset-y
                                    max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="form.time_end" label="Hora"
                                            prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs"
                                            v-on="on"></v-text-field>
                                    </template>
                                    <v-time-picker v-if="menu[3]" v-model="form.time_end" full-width
                                        @click:minute="$refs.menu3.save(form.time_end)"></v-time-picker>
                                </v-menu>

                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6" class="d-flex justify-center flex-column">
                                <label for="">Cor do texto</label>
                                <v-color-picker v-model="form.colorText" class="ma-2" hide-mode-switch mode="hexa"></v-color-picker>
                            </v-col>
                            <v-col cols="6" class="d-flex justify-center flex-column">
                                <label for="">Fundo do texto</label>
                                <v-color-picker  v-model="form.bgColor" class="ma-2"  hide-mode-switch mode="hexa"></v-color-picker>
                            </v-col>
                        </v-row>

                    </v-form>
                </v-container>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary">
                    Salvar
                </v-btn>
                <v-btn color="error" @click="$emit('closeDialog')">
                    Cancelar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
import TypeOperation from '../enum/TypeOperation';
let dateEnd = new Date();
dateEnd.setMinutes(dateEnd.getMinutes() + 30);
export default {
    data() {
        return {
            dialog: false,
            dataTypeOperation: TypeOperation,
            //dataPickers e timer menus
            menu: [false,false,false,false],
            //formulario
            form: {
                name: '',
                pickerInputStart: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substring(0, 10),
                pickerInputEnd: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substring(0, 10),
                time_start: (new Date()).getHours() + ":" + String((new Date()).getMinutes()).padStart(2, '0'),
                time_end: dateEnd.getHours() + ":" + String(dateEnd.getMinutes()).padStart(2, '0'),
                colorText: '#ffffff',
                bgColor:'#0008ff'
            }
        }
    },
    props: {
        typeOperation: {
            type: Number,
            validator: function (value) {
                return Object.values(TypeOperation).includes(value);
            },
            required: true
        },
        show: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        pickerInputStartDateFormatted() {
            return this.formatDate(this.form.pickerInputStart)
        },
        pickerInputEndDateFormatted() {
            return this.formatDate(this.form.pickerInputEnd)
        },
    },
    methods: {
        formatDate(date) {
            if (!date) return null;
            const [year, month, day] = date.split('-');
            return `${month}/${day}/${year}`;
        },
    },
}
</script>
