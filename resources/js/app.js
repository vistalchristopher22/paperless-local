import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import 'notyf/notyf.min.css'; 
import "vue-select/dist/vue-select.css";
import getSocketInstance from '@services/socket';


const globalConfig = {
  socket : getSocketInstance(),
  baseUrl : window.location.origin,
}

createInertiaApp({
  id: 'app',
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(autoAnimatePlugin)
      .provide('$config', globalConfig) 
      .mount(el)
  },
});

