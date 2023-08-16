<template>
    <v-row justify="center">
      <v-dialog
        v-model="dialog"
        persistent
        max-width="500"
      >
        <v-card>
          <div style="width: 100%;" class="d-flex justify-center" v-if="this.typeAlertIcon.info == this.data.icon">
            <v-icon size="70" color="blue darken-2">mdi-information</v-icon>
          </div>
          <div style="width: 100%;" class="d-flex justify-center" v-else-if="this.typeAlertIcon.success == this.data.icon">
            <v-icon size="70" color="green darken-2">mdi-check-circle</v-icon>
          </div>
          <div style="width: 100%;" class="d-flex justify-center" v-else-if="this.typeAlertIcon.warning == this.data.icon">
            <v-icon size="70" color="yellow darken-2">mdi-alert</v-icon>
          </div>
          <div style="width: 100%;" class="d-flex justify-center" v-else-if="this.typeAlertIcon.error == this.data.icon">
            <v-icon size="70" color="red darken-2">mdi-close-circle </v-icon>
          </div>
          <div style="width: 100%;" class="d-flex justify-center" v-else-if="this.typeAlertIcon.question == this.data.icon">
            <v-icon size="70" color="purple darken-2">mdi-help-circle </v-icon>
          </div>

          <!-- titulo -->
          <v-card-title class="text-h5">
            {{ this.data.titulo }}
          </v-card-title>

          <v-card-text>{{this.data.texto}}</v-card-text>
          <v-card-actions v-if="this.typeAlert == this.typeAlertObj.alert">
            <v-spacer></v-spacer>
            <v-btn
              color="success darken-1"
              style="color:white"
              @click="close()"
            >
              OK
            </v-btn>
          </v-card-actions>
          <v-card-actions v-else-if="this.typeAlert == this.typeAlertObj.question">
            <v-spacer></v-spacer>
            <v-btn
              color="success darken-1"
              style="color:white"
              @click="responseYes()"
            >
              SIM
            </v-btn>
            <v-btn
              color="error darken-1"
              style="color:white"
              @click="close()"
            >
              NÃO
            </v-btn>
          </v-card-actions>
          <v-card-actions v-else-if="this.typeAlert == this.typeAlertObj.questionCancel">
            <v-spacer></v-spacer>
            <v-btn
              color="success darken-1"
              style="color:white"
              @click="responseYes()"
            >
              SIM
            </v-btn>
            <v-btn
              color="error darken-3"
              style="color:white"
              @click="responseNo()"
            >
              NÃO
            </v-btn>
            <v-btn
              color="error darken-1"
              style="color:white"
              @click="close()"
            >
              CANCELAR
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </template>
<script>
import TypeAlert from '../enums/TypeAlert'
import TypeAlertIcon from '../enums/TypeAlertIcon'
import Settings from '../objects/Settings';

export default {
    data() {
        return {
            dialog: false,
            typeAlertIcon: TypeAlertIcon,
            typeAlertObj: TypeAlert,
        }
    },
    props: {
        typeAlert: {
            type: Number,
            required: true
        },//TypeAlert
        data: {
            type: [Object, Array], //Seetings.alertData
            default: () => {
                return Settings.alertData('Data object null','prop data esta nula',TypeAlertIcon.error)
            }
        },
        show: {
            type: Boolean,
            default: false
        },
        yesCallback: Function,
        noCallback:Function

    },
    methods:{
        open(){
            this.dialog = true;
        },
        close(){
            if(this.show){
                this.$emit('close');
            }else{
                this.dialog = false;
            }

        },
        responseYes(){
            if(this.yesCallback){
                this.yesCallback();
            }else{
                this.close();
                console.log("Função 'yesCallback' não adicionada ");
            }

        },
        responseNo(){
            if(this.noCallback){
                this.noCallback();
            }else{
                this.close();
                console.log("Função 'noCallback' não adicionada ");
            }
        }
    },
    watch:{
        show(oldValue, newValue){
            this.dialog = (newValue == this.dialog)?!newValue:newValue;
        },
    },
    mounted() {

    },
}
</script>

