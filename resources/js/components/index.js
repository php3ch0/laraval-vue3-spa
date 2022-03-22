import Vue from 'vue'
import Card from './Card.vue'
import Child from './Child.vue'
import LoadingSm from "./LoadingSm";
import PageHeader from "./PageHeader";
import DashIcon from "./DashIcon";
import SettingText from "./SettingText";

// Components that are registered globaly.
[
  Card,
  Child,
  LoadingSm,
  PageHeader,
  DashIcon,
  SettingText
].forEach(Component => {
  Vue.component(Component.name, Component)
})
