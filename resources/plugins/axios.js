import Vue from "vue";
import axios from "axios";
import { vue } from "laravel-mix";

axios.defaults.baseURL = '';



vue.use({
    install(Vue){
        vue.prototype.$http = axios
    }
})
