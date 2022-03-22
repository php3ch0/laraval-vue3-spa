function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'home', component: page('home.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },

  { path: '/terms/privacy', name: 'privacy', component: page('terms/privacy.vue') },
  { path: '/terms/terms', name: 'terms', component: page('terms/terms.vue') },

  { path: '/account/profile', name: 'account.profile', component: page('account/profile.vue') },
  { path: '/account/password', name: 'account.password', component: page('account/password.vue') },

  { path: '/admin', name: 'admin.index', component: page('admin/index.vue') },

  { path: '/admin/users', name: 'admin.users.index', component: page('admin/users/index.vue') },
  { path: '/admin/users/add', name: 'admin.users.add', component: page('admin/users/add.vue') },
  { path: '/admin/users/:id', name: 'admin.users.view', component: page('admin/users/view.vue') },

  { path: '/admin/stock', name: 'admin.stock.index', component: page('admin/stock/index.vue') },
  { path: '/admin/stock/:id', name: 'admin.stock.view', component: page('admin/stock/view.vue') },

  { path: '/admin/products/:productid/stock/:stockid/margins', component: page('admin/products/margins.vue')},

  { path: '/admin/products', name: 'admin.products.index', component: page('admin/products/index.vue') },
  { path: '/admin/products/:id', name: 'admin.products.view', component: page('admin/products/view.vue') },

  { path: '/admin/delivery', name: 'admin.delivery.index', component: page('admin/delivery/index.vue') },
  { path: '/admin/delivery/countries', name: 'admin.delivery.countries', component: page('admin/delivery/countries.vue') },
  { path: '/admin/delivery/:id', name: 'admin.delivery.view', component: page('admin/delivery/view.vue') },

  { path: '/admin/orders', name: 'admin.orders.index', component: page('admin/orders/index.vue') },
  { path: '/admin/orders/:id', name: 'admin.orders.view', component: page('admin/orders/view.vue') },

  { path: '/admin/batches', name: 'admin.batches.index', component: page('admin/batches/index.vue') },

  { path: '/admin/tickets', name: 'admin.tickets.index', component: page('admin/tickets/index.vue') },
  { path: '/admin/tickets/:id', name: 'admin.tickets.view', component: page('admin/tickets/view.vue') },

  { path: '/create', name: 'create.index', component: page('create/index.vue') },
  { path: '/create/:id', name: 'create.items', component: page('create/items.vue') },

  { path: '/orders', name: 'orders.index', component: page('orders/index.vue') },
  { path: '/orders/:id', name: 'orders.view', component: page('orders/view.vue') },

  { path: '/invoices', name: 'invoices.index', component: page('invoices/index.vue') },

  { path: '/admin/settings', name: 'admin.settings.index', component: page('admin/settings/index.vue') },
  { path: '/admin/settings/:id', name: 'admin.settings.view', component: page('admin/settings/view.vue') },

  { path: '/prices', name: 'prices', component: page('prices/index.vue') },

  { path: '/tickets', name: 'tickets.index', component: page('tickets/index.vue') },
  { path: '/tickets/:id', name: 'tickets.view', component: page('tickets/view.vue') },




  { path: '*', component: page('errors/404.vue') }
]
