<template>
    <div class="demo-alignment">
      <div class="fill-row-loading m-0">
        <div :id="[`loading-border`]" class="vs-con-loading__container loading-example">
        </div>
      </div>
  </div>
</template>

<script>
export default {
    data:()=>({
        types:[
            'border',
        ]
    }),
    mounted(){
        this.types.forEach((type)=>{
            this.$vs.loading({
                container: `#loading-border`,
                type: 'border',
            })
        })
    },
}
</script>

<style lang="scss">
.fill-row-loading {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  .loading-example {
    width: 60px;
    float: left;
    height: 60px;
    margin: 8px;
    transition: all 0.3s ease;
  }
  .con-vs-loading {
    background: #f8f8f8;
  }
}
</style>