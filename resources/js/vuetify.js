import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import pt from 'vuetify/lib/locale/pt'
import en from 'vuetify/lib/locale/en'
Vue.use(Vuetify)

export default new Vuetify({
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },
    theme: {
        themes: {
            light: {
                // primary: '#3f51b5',
                // secondary: '#696969',
                // accent: '#8c9eff',
                // error: '#b71c1c',
            },
        },
    },
    lang: {
        locales: { pt, en },
        current: 'pt',
    },
})
