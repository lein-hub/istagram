<template lang="">
    <div>
        <carousel :items-to-show="1">
            <slide v-for="img in images" :key="img.id">
                <img class="h-full bg-cover" :src="img.image">
            </slide>

            <template #addons>
                <navigation />
                <pagination />
            </template>
        </carousel>
    </div>
</template>
<script>
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
export default {
    props: [
        'images'
    ],
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    }
}
</script>
<style lang="">

</style>
