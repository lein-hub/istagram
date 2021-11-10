<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <carousel-plate v-if="images.length > 0">
                            <img v-for="(img, index) in images" :key="index" :src="img.image" alt="" >
                        </carousel-plate>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import CarouselPlate from 'vue-owl-carousel'

    export default {
        components: {
            CarouselPlate
        },
        props: {
            images: Array
        },
        data() {
            return {
                imgData: []
            }
        },
        mounted() {
            console.log(this.images);
        }
    }

</script>

<style>
</style>
