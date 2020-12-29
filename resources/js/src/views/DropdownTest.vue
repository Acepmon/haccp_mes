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

    <v-select v-model="item2" :options="items2" />

    <vs-divider></vs-divider>
    {{ item3 }}
    <v-select v-model="item3" :options="items3" :reduce="item => item.comm2_cd" label="comm2_nm" />
  </vx-card>
</template>

<script>
import comm_cd from '@/services/comm_cd'
export default {
  data () {
    return {
      item: null,
      items: ['Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5', 'Item 6'],
      item2: null,
      items2: ['Item 1', 'Item 2', 'Item 3', 'Item 4', 'Item 5', 'Item 6'],
      item3: null,
      items3: []
    }
  },

  created() {
    comm_cd.fetch({
      'cd1': 'A10'
    }).then((res) => {
      this.$set(this, 'items3', res.data)
    })
  },
};
</script>