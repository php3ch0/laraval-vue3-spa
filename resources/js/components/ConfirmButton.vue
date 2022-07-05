<template>
  <div id="ConfirmButton" class="w-auto inline">

    <button type="button" class="btn btn-red" @click.prevent="confirmAction">{{ text }}</button>

  <Transition name="modal">
    <div v-if="show" class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container sm">
          <div class="modal-header bg-gray-100 border-b-[1px] border-gray-300 p-3">
                <h3>Please Confirm?</h3>
          </div>
          <div class="modal-body p-3">
            <div class="mt-3 mb-3">
              <p>Are you sure you want to do this?</p>
            </div>

            <div class="grid grid-cols-2">
              <div class="justify-center">
                <button type="button" @click.prevent="cancel" class="btn btn-red">Cancel</button>
              </div>
              <div class="justify-center">
                <button type="button" @click.prevent="confirm" class="btn btn-green">Confirm</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Transition>
  </div>
</template>

<script>
export default {
  props: {
    text:String
  },
  data() {
    return {
      show:false,
    }
  },
  methods: {
    confirmAction() {
      let self=this;
      self.show=true;
    },
    cancel() {
      let self=this;
      self.show=false;
      self.$emit('cancel');
    },
    confirm() {
      let self=this;
      self.show=false;
      self.$emit('confirm');
    }
  }
}
</script>
