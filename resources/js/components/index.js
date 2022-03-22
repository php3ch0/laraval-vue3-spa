import Vue from 'vue'
import Card from './Card.vue'
import Child from './Child.vue'
import LoadingSm from "./LoadingSm";
// Components that are registered globaly.
[
  Card,
  Child,
  LoadingSm
].forEach(Component => {
  Vue.component(Component.name, Component)
})
