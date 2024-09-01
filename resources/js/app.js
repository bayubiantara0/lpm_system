import './bootstrap';
import { createApp } from 'vue';
import FormComponent from './components/FormComponent.vue';
import axios from 'axios';

// Create the Vue application
const app = createApp({});

// Register the FormComponent
app.component('form-component', FormComponent);

// Mount the application
app.mount('#app');

// Set up axios globally (optional)
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
