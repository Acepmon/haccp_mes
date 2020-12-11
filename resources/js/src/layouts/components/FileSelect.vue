<template>
    <label class="file-select">
        <vs-button type="border" color="dark" @click="$refs.file.click()">
            <span v-if="value">Selected File: {{value.name}}</span>
            <span v-else>Select File</span>
        </vs-button>
        <input type="file" ref="file" @change="handleFileChange"/>
    </label>
</template>

<script>
export default {
    props: {
        value: File
    },

    methods: {
        handleFileChange(e) {
            this.$emit('input', e.target.files[0])
        }
    }
}
</script>

<style scoped>
.file-select > input[type="file"] {
  display: none;
}
</style>