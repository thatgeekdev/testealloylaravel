import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';

import '../css/app.css';
import '../css/normalize.css'
import '../css/webflow.css'
import '../css/alloy-tests.webflow.css'




const app = createApp(App);
app.use(createPinia());
app.mount('#app');
