<template>
    <v-dialog v-model="this.show" width="600">
        <v-card>
            <v-card-title class="text-h5 grey lighten-2">
                {{ dataTypeOperation.create == typeOperation ? 'Cadastro Evento':'Atualizar Evento' }}
            </v-card-title>

            <v-card-text>
                <v-container>
                    <v-form ref="form">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field label="Nome"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <v-text-field label="Inicio"></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field label="Fim"></v-text-field>
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
    export default {
        data(){
            return{
                dialog: false,
                dataTypeOperation: TypeOperation
            }
        },
        props:{
            typeOperation: {
                type: Number,
                validator: function(value){
                    return Object.values(TypeOperation).includes(value);
                },
                required: true
            },
            show: {
                type: Boolean,
                default: false
            }
        }
    }
</script>
