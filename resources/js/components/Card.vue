<template>
  <div class="card">
    <div v-if="title" class="card-header">
      <h5>{{ title }}</h5>
    </div>
    <div v-else class="card-header">
      <slot name="title" />
    </div>

    <div class="card-body">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',

  props: {
    title: { type: String, default: null }
  }
}
</script>
