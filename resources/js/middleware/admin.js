import store from '~/store'

export default (to, from, next) => {
  if (!store.getters['auth/check'] || store.getters['auth/user'].role !== 'admin') {
    next({ name: 'login' })
  } else {
    next()
  }
}
