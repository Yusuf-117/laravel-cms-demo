import { createApp } from "vue";
import Portfolio from "./Pages/Portfolio/Index.vue";

import Particles from "@tsparticles/vue3";
import { loadSlim } from "@tsparticles/slim";

const app = createApp(Portfolio);

app.use(Particles, {
    init: async (engine) => {
        await loadSlim(engine);
    },
});

app.mount("#app");
