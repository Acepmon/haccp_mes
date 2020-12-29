<template>
  <vx-card>
    <vs-select class="mt-3 w-full" v-model="item">
      <vs-select-item
        v-for="(item, index) in items"
        :key="index"
        :text="item"
        :value="item"
      ></vs-select-item>
    </vs-select>

    <vs-divider></vs-divider>

    <v-select v-model="item2" :options="items2" :value="item2" />
  </vx-card>
</template>

<script>
export default {
  data () {
    return {
      item: null,
      items: ['Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5', 'Item 6'],
      item2: null,
      items2: ['Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5', 'Item 6'],
    }
  },

  created() {
    console.log("Dropdown Test created");
  },
};
</script>