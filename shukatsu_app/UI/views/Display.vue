<template>
    <select name="display" v-model="display">
        <option value="ongoing">選考中のみ表示</option>
        <option value="favorite">気になる表示</option>
        <option value="all">すべてを表示</option>
        <option value="get">内定のみ表示</option>
    </select>
</template>
<script>
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
    setup() {
        
    },
})
</script>
