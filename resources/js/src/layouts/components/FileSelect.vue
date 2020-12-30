<template>
    <label class="file-select">
        <vs-button type="border" color="dark" @click="$refs.file.click()">
            <span v-if="value">{{value.name}}</span>
            <span v-else>화일선택</span>
        </vs-button>
        <input type="file" ref="file" @change="handleFileChange" accept=".docx, .doc, .xls, .xlsx, .pdf, .hwp, image/*"/>
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