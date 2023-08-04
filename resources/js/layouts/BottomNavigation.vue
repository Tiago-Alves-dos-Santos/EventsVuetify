<template>
    <v-app app>
        <v-bottom-navigation v-model="value" :background-color="color" dark shift absolute>
            <v-btn>
                <span>Calendário</span>

                <v-icon>mdi-calendar-clock</v-icon>
            </v-btn>

            <v-btn>
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
        <v-container>
            <slot></slot>
        </v-container>
    </v-app>
</template>
<script>
  export default {
    data: () => ({ value: 1 }),

    computed: {
      color () {
        switch (this.value) {
          case 0: return 'blue-grey'
          case 1: return 'teal'
          case 2: return 'brown'
          case 3: return 'indigo'
          default: return 'blue-grey'
        }
      },
    },
  }
</script>
