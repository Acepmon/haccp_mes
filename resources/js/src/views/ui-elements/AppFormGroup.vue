<template>
  <div class="w-full mb-3" :class="{'sm:w-1/2': !full}">
    <div :class="{'vx-row': !full, 'flex flex-row': full}">
      <div class="vx-col flex justify-end" :class="{'sm:w-1/3 pr-0': !full, 'sm:w-1/6 pr-1': full}">
        <span class="control-label flex flex-wrap content-center justify-end">
          <span class="text-danger pt-1 mr-1" v-if="required">&#42;</span>
          <slot name="label"></slot>
        </span>
      </div>

      <div class="vx-col" :class="{'sm:w-2/3 pl-2': !full, 'sm:w-5/6 pl-05': full}">
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