import '../css/app.css';
import './bootstrap';

import { createApp } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import StripeCheckout from './Components/StripeCheckout.vue';

const app = createApp({});
app.component('stripe-checkout', StripeCheckout);
app.use(ZiggyVue);
app.mount('#app');
