<template>
  <div class="flex flex-wrap mb-4" :class="{'control-flush': flush}">
    <div class="w-full flex flex-wrap justify-start control-col" :class="filterClass">
      <slot name="filter"></slot>
    </div>
    <div class="w-full flex flex-wrap justify-end control-col" :class="actionClass">
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
    },
    filterClass: {
      type: String,
      default: 'sm:w-7/12'
    },
    actionClass: {
      type: String,
      default: 'sm:w-5/12'
    }
  }
}
</script>

<style lang="css" scoped>
.control-flush {
  margin-top: -12px;
}
.control-col > * {
  flex-shrink: revert;
}
</style>