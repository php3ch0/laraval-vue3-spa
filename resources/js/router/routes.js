function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'home', component: page('home.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },



  { path: '/account/profile', name: 'account.profile', component: page('account/profile.vue') },
  { path: '/account/password', name: 'account.password', component: page('account/password.vue') },

  { path: '/admin', name: 'admin.index', component: page('admin/index.vue') },

  { path: '/admin/users', name: 'admin.users.index', component: page('admin/users/index.vue') },
  { path: '/admin/users/add', name: 'admin.users.add', component: page('admin/users/add.vue') },
  { path: '/admin/users/:id', name: 'admin.users.view', component: page('admin/users/view.vue') },


  { path: '*', component: page('errors/404.vue') }
]
