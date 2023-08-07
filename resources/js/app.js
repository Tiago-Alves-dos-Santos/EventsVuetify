require('./bootstrap');

window.Vue = require('vue').default;
import vuetify from './vuetify';
import { createInertiaApp } from '@inertiajs/vue2'
//ZIGGY
Vue.prototype.$route = route;
//INERTIA
import { Link } from '@inertiajs/vue2'
Vue.component('Link', Link);
//LAYOUTS
Vue.component('LayoutBottomNavigation', require('./layouts/BottomNavigation.vue').default)


 createInertiaApp({
    progress: {
        delay: 150,

        // The color of the progress bar.
        color: '#ff0a0a',

        // Whether to include the default NProgress styles.
        includeCSS: true,

        // Whether the NProgress spinner will be shown.
        showSpinner: false,
    },
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
      Vue.use(plugin)

      new Vue({
        vuetify,
        render: h => h(App, props),
      }).$mount(el)
    },
  })
