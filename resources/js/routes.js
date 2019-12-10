import VueRouter from 'vue-router';

let routes = [
    {path: '/', component: require('./components/orders/Orders').default, name: 'dashboard'},

    {path: 'order/create', component: require('./components/orders/Create').default, name: 'order.create'},
    {path: 'order/:order_id/edit', component: require('./components/orders/Edit').default, name: 'order.edit'},

    {
        path: '/admin', component: require('./components/admin/settings/Settings').default,
        children: [
            {path: 'products', component: require('./components/admin/products/Products').default, name: 'admin.products'},
            {path: 'product/create', component: require('./components/admin/products/Create').default, name: 'admin.product.create'},
            {path: 'product/:product_id/edit', component: require('./components/admin/products/Edit').default, name: 'admin.product.edit'},
            {path: 'users', component: require('./components/admin/users/Users').default, name: 'admin.users'},
            {path: 'user/create', component: require('./components/admin/users/Create').default, name: 'admin.user.create'},
            {path: 'user/:user_id/edit', component: require('./components/admin/users/Edit').default, name: 'admin.user.edit'}
        ]
    },



    {path: '*', redirect: '/'}
];

const router = new VueRouter({
    routes,
    linkActiveClass: 'current-menu-item'
});

export default router;
