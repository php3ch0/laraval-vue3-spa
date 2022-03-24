import Vue from 'vue'
import Card from './Card.vue'
import Child from './Child.vue'
import LoadingSm from "./LoadingSm";
import Widget from "./Widget";
import GallerySlide from "./GallerySlide";
import GalleryView from "./GalleryView";

// Components that are registered globaly.
[
  Card,
  Child,
  LoadingSm,
  Widget,
  GallerySlide,
  GalleryView
].forEach(Component => {
  Vue.component(Component.name, Component)
})
