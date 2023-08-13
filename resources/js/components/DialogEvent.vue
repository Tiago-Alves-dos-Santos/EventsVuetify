<template>
    <v-dialog v-model="this.show" width="800" @click:outside="$emit('closeDialog')">
        <v-card>
            <v-card-title class="text-h5 grey lighten-2">
                {{ dataTypeOperation.create == typeOperation ? 'Cadastro Evento' : 'Atualizar Evento' }}
            </v-card-title>

            <v-card-text>
                <v-container>
                    <v-form ref="form" @submit.prevent="createOrUpdate">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field label="Nome" tabindex="1" prepend-icon="mdi-pencil"
                                    v-model="form.name"></v-text-field>
                                <span class="message-error"
                                    v-if="$page.props.errors.name">{{ $page.props.errors.name }}</span>
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
                                    <v-date-picker v-model="form.date_start" ref="startDatePicker"
                                        @input="menu[0] = false"></v-date-picker>
                                </v-menu>
                                <span class="message-error"
                                    v-if="$page.props.errors.date_start">{{ $page.props.errors.date_start }}</span>
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
                                    <v-time-picker v-if="menu[1]" ref="startTimePicker" v-model="form.time_start" full-width
                                        @click:minute="$refs.menu1.save(form.time_start)"></v-time-picker>
                                </v-menu>
                                <span class="message-error"
                                    v-if="$page.props.errors.time_start">{{ $page.props.errors.time_start }}</span>
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
                                    <v-date-picker v-model="form.date_end" ref="endDatePicker"
                                        @input="menu[2] = false"></v-date-picker>
                                </v-menu>
                                <span class="message-error"
                                    v-if="$page.props.errors.date_end">{{ $page.props.errors.date_end }}</span>
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
                                    <v-time-picker v-if="menu[3]" ref="endTimePicker" v-model="form.time_end" full-width
                                        @click:minute="$refs.menu3.save(form.time_end)"></v-time-picker>
                                </v-menu>
                                <span class="message-error"
                                    v-if="$page.props.errors.time_end">{{ $page.props.errors.time_end }}</span>

                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6" class="d-flex justify-center flex-column">
                                <label for="">Cor do texto</label>
                                <v-color-picker v-model="form.text_color" class="ma-2" hide-mode-switch
                                    mode="hexa"></v-color-picker>
                                <span class="message-error"
                                    v-if="$page.props.errors.text_color">{{ $page.props.errors.text_color }}</span>
                            </v-col>
                            <v-col cols="6" class="d-flex justify-center flex-column">
                                <label for="">Fundo do texto</label>
                                <v-color-picker v-model="form.text_background" class="ma-2" hide-mode-switch
                                    mode="hexa"></v-color-picker>
                                <span class="message-error"
                                    v-if="$page.props.errors.text_background">{{ $page.props.errors.text_background }}</span>
                            </v-col>
                        </v-row>
                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" type="submit" :loading="load_form" :disabled="load_form">
                                Salvar
                            </v-btn>
                            <v-btn color="error" @click="$emit('closeDialog')">
                                Cancelar
                            </v-btn>
                        </v-card-actions>
                    </v-form>
                </v-container>
            </v-card-text>


        </v-card>
    </v-dialog>
</template>
<script>
import { router } from '@inertiajs/vue2';
import TypeOperation from '../enums/TypeOperation';
let dateEnd = new Date();
dateEnd.setMinutes(dateEnd.getMinutes() + 30);
export default {
    data() {
        return {
            dialog: false,
            dataTypeOperation: TypeOperation,
            //dataPickers e timer menus
            menu: [false, false, false, false],
            //formulario
            form: {
                name: '',
                date_start: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substring(0, 10),
                date_end: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substring(0, 10),
                time_start: String(new Date().getHours()).padStart(2, '0') + ":" + String((new Date()).getMinutes()).padStart(2, '0'),
                time_end: String(dateEnd.getHours()).padStart(2, '0') + ":" + String(dateEnd.getMinutes()).padStart(2, '0'),
                text_color: '#ffffff',
                text_background: '#0008ff'
            },
            load_form: false,
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
        },
    },
    computed: {
        pickerInputStartDateFormatted() {
            return this.formatDate(this.form.date_start);
        },
        pickerInputEndDateFormatted() {
            return this.formatDate(this.form.date_end);
        },
    },
    methods: {
        formatDate(date) {
            if (!date) return null;
            const [year, month, day] = date.split('-');
            return `${day}/${month}/${year}`;
        },
        createOrUpdate() {
            if (this.typeOperation == TypeOperation.create) {
                let route_url = this.$route('event.create');
                router.post(route_url, this.form, {
                    onStart: () => {
                        this.load_form = true;
                    },
                    onSuccess: page => {
                        this.$emit('close');
                        this.defaultValuesForm();
                    },
                    onFinish: visit => {
                        this.load_form = false;
                    }
                });
            } else {
                console.log('form atulizar');
            }
        },
        defaultValuesForm() {
            this.form = {
                name: '',
                date_start: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substring(0, 10),
                date_end: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substring(0, 10),
                time_start: String(new Date().getHours()).padStart(2, '0') + ":" + String((new Date()).getMinutes()).padStart(2, '0'),
                time_end: String(dateEnd.getHours()).padStart(2, '0') + ":" + String(dateEnd.getMinutes()).padStart(2, '0'),
                text_color: '#ffffff',
                text_background: '#0008ff'
            };
            console.log(this.form);
        }
    },
}
</script>
