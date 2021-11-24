<template lang="">
    <div>
        {{ chat.user.name }} : {{ chat.content }}
    </div>
</template>
<script>
export default {
    props: [
        'chat'
    ]
}
</script>
<style lang="">

</style>
