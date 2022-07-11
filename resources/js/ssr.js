import { createSSRApp, h } from "vue";
import { renderToString } from "@vue/server-renderer";
import { createInertiaApp, Head, Link } from "@inertiajs/inertia-vue3";
import createServer from "@inertiajs/server";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import Authenticated from "./Layouts/Authenticated.vue";

const appName = "Laravel";

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title} - ${appName}`,
        resolve: (name) => {
            const page = resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob("./Pages/**/*.vue")
            );
            page.layout = Authenticated;
            return page;
        },
        setup({ app, props, plugin }) {
            return createSSRApp({ render: () => h(app, props) })
                .use(plugin)
                .use(ZiggyVue, {
                    ...page.props.ziggy,
                    location: new URL(page.props.ziggy.location),
                })
                .component("Link", Link)
                .component("Head", Head);
        },
    })
);
