<template lang="">
    <button @click="$inertia.get('/user/'+ user.id)" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
        <img :src="user.profile_photo_url" class="h-8 w-8 rounded-full object-cover" alt="profilepic">
    </button>
</template>
<script>
export default {
    props: [
        'user'
    ]
}
</script>
<style lang="">

</style>
