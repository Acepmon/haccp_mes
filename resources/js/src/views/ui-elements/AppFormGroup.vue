<template>
  <div class="w-full sm:w-1/2">
    <div class="vx-row mb-3">
      <div class="vx-col sm:w-1/3 w-full flex justify-end pr-0">
        <span class="pt-1">
          <span class="text-danger" v-if="required">*</span>
          <slot name="label"></slot>
        </span>
      </div>

      <div class="vx-col sm:w-2/3 pl-2 w-full">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      // 
    }
  },

  props: {
    full: {
      type: Boolean,
      default: false
    },
    required: {
      type: Boolean,
      default: false
    }
  }
}
</script>