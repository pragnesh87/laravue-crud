import ProductIndex from "../components/products/Index.vue";
import ProductCreate from "../components/products/Create.vue";
import ProductEdit from "../components/products/Edit.vue";
import NotFound from "../components/NotFound.vue";

const routes = [
    {
        path: "/",
        name: "product",
        component: ProductIndex,
    },
    {
        path: "/product/create",
        name: "product-new",
        component: ProductCreate,
    },
    {
        path: "/product/edit/:id",
        name: "product-edit",
        component: ProductEdit,
        props: true,
    },
    {
        path: "/:pathMatch(.*)*",
        component: NotFound,
    },
];

export default routes;
