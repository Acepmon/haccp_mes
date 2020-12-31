<template>
  <div class="flex flex-wrap mb-4" :class="{'control-flush': flush}">
    <div class="w-full sm:w-1/2 flex justify-start">
      <slot name="filter"></slot>
    </div>
    <div class="w-full sm:w-1/2 flex justify-end">
      <slot name="action"></slot>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    flush: {
      type: Boolean,
      default: false
    }
  }
}
</script>

<style lang="css" scoped>
.control-flush {
  margin-top: -12px;
}
</style>