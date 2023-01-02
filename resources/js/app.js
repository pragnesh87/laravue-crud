import "./bootstrap";

import Swal from "sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

window.Swal = Swal;
const toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showCloseButton: false,
    timer: 3000,
    timerProgressBar: true,
});
window.toast = toast;

import { createApp, markRaw } from "vue";
import { createPinia } from "pinia";

import App from "./front/App.vue";
import router from "./front/router/index";

const pinia = createPinia();
pinia.use(({ store }) => {
    store.router = markRaw(router);
});

const app = createApp(App);
app.use(pinia);
app.use(router);
//app.component("fa-icon", FontAwesomeIcon);

app.mount("#app");
