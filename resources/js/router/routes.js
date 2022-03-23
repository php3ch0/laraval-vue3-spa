function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'home', component: page('home.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },


  { path: '/account', name: 'account.index', component: page('account/index.vue') },
  { path: '/account/profile', name: 'account.profile', component: page('account/profile.vue') },
  { path: '/account/password', name: 'account.password', component: page('account/password.vue') },

  { path: '/admin', name: 'admin.index', component: page('admin/index.vue') },

  { path: '/admin/users', name: 'admin.users.index', component: page('admin/users/index.vue') },
  { path: '/admin/users/add', name: 'admin.users.add', component: page('admin/users/add.vue') },
  { path: '/admin/users/:id', name: 'admin.users.view', component: page('admin/users/view.vue') },

  /* Admin Widgets */
  { path: '/admin/widgets', name: 'AdminWidgets', component: page('admin/widgets/index.vue') },
  { path: '/admin/widgets/add', name: 'AdminWidgetsAdd', component: page('admin/widgets/add.vue') },
  { path: '/admin/widgets/:id', name: 'AdminWidgetsEdit', component: page('admin/widgets/edit.vue') },

  /* Blogs */

  /* Admin Blog */
  { path: '/admin/blog', name: 'AdminBlog', component: page('admin/blog/index.vue') },
  { path: '/admin/blog/add', name: 'AdminBlogAdd', component: page('admin/blog/add.vue') },
  { path: '/admin/blog/:id', name: 'AdminBlogEdit', component: page('admin/blog/edit.vue') },

  /* Public Blogs */
  { path: '/blog', name: 'Blog', component: page('blog/index.vue') },
  { path: '/blog/:slug', name: 'BlogView', component: page('blog/view.vue') },

  /* Admin Galleries */
  { path: '/admin/galleries', name: 'admin.galleries', component: page('admin/galleries/index.vue') },
  { path: '/admin/galleries/:id', name: 'admin.galleries.edit', component: page('admin/galleries/edit.vue') },

  /* Public Galleries */
  { path: '/galleries', name: 'Galleries', component: page('galleries/index.vue') },
  { path: '/galleries/:slug', name: 'GalleriesView', component: page('galleries/view.vue') },

  /* admin testimonials */
  { path: '/admin/testimonials', name: 'AdminTestimonials', component: page('admin/testimonials/index.vue') },
  { path: '/admin/testimonials/:id', name: 'AdminTestimonialsEdit', component: page('admin/testimonials/edit.vue') },

  /* Admin Services */
  { path: '/admin/services', name: 'admin.services', component: page('admin/services/index.vue') },
  { path: '/admin/services/add', name: 'admin.services.add', component: page('admin/services/add.vue') },
  { path: '/admin/services/:id', name: 'admin.services.edit', component: page('admin/services/edit.vue') },

  /* Public Services */
  { path: '/services', name: 'services', component: page('services/index.vue') },
  { path: '/services/:slug', name: 'services.view', component: page('services/view.vue') },

  { path: '/contact', name: 'contact', component: page('contact/index.vue') },



  { path: '*', component: page('errors/404.vue') }
]
