<script>
export default {
    created () {
        this.$store.dispatch('mdn/addTab', {
            path: '/1/1', 
            value: 'page-1-1', 
            label: '회사정보등록', 
            component: 'page-1-1'
        })
    }
}
</script>