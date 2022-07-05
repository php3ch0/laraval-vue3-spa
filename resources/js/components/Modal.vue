<template>
  <Transition name="modal">
    <div v-if="show" class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container" :class="width">
          <div class="modal-header bg-gray-100 border-b-[1px] border-gray-300 p-3">
            <div class="flex">
              <div class="flex-auto">
                <h3>{{title}}</h3>
              </div>
              <div class="flex-none">
                <i @click="$emit('close')" class="fa-solid fa-xmark hover:text-gray-700 text-black modal-close"></i>
              </div>
            </div>
          </div>
          <div class="modal-body p-3">
            <slot name="body">default body</slot>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script>
export default {
  props: {
    show: Boolean,
    title:String,
    width: {
      String,
      default:'sm'
    }
  }
}
</script>
