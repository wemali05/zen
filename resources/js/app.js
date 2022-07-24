import { createApp, h } from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'

import route from 'ziggy'
import { ZiggyVue } from './ziggy'


import { createInertiaApp } from '@inertiajs/inertia-vue3'
import Toaster from "@meforma/vue-toaster";

createApp().use(VueAxios, axios, Toaster).mount('#app')

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            // .mixin({ methods: { route: window.route } })
            .mixin({ methods: { route } })
            .mount(el)
    },
})
