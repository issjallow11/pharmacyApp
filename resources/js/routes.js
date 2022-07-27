export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/sale', component: require('./components/sale/sale.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/products', component: require('./components/product/Products.vue').default },
    { path: '/configurations/tag', component: require('./components/configurations/Tag.vue').default },
    { path: '/configurations/category', component: require('./components/configurations/Category.vue').default },
    { path: '/configurations/types', component: require('./components/configurations/Type.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
];
