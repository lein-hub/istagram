<template lang="">
    <carousel :items-to-show="1">
        <slide v-for="(img, index) in images" :key="index">
            <img class="bg-cover m-auto object-contain" :src="img">
        </slide>

        <template #addons>
            <navigation />
            <pagination />
        </template>
    </carousel>
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
<style scoped>
.carousel {
  object-fit: contain;
  height: 100%;
}

.carousel >>> .carousel__viewport {
  object-fit: contain;
  height: 100%;
}

.carousel >>> .carousel__viewport >>> .carousel__track {
  height: 100%;
}
</style>
