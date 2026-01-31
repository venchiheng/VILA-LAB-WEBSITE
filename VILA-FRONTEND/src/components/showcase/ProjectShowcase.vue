<template>
    <section class="w-full flex justify-center items-center py-20 bg-white min-h-screen">
        <div class="max-w-[1600px] w-full flex flex-col md:flex-row items-center gap-12 px-6">


            <div class="flex flex-col justify-center items-center text-center">

                <h1 class="project-title text-center">
                    {{ title }}
                </h1>


                <p class="text-gray-700 leading-relaxed mt-6 mb-6 max-w-xl">
                    {{ description }}
                </p>


                <button
                    class="bg-primary hover:bg-primary text-bg px-6 py-3 rounded-full font-semibold flex items-center gap-2">
                    Read more
                </button>

            </div>


            <div class="flex gap-6 justify-center md:justify-end mt-10 md:mt-0">
                <div v-for="(box, index) in boxes" :key="index"
                    class="w-40 h-72 rounded-[30px] overflow-hidden relative">
                    <div class="h-1/2" :class="box.topColor"></div>
                    <div class="h-1/2" :class="box.bottomColor"></div>


                    <RoundRight v-if="index === boxes.length - 1" />
                </div>
            </div>

        </div>
    </section>
</template>

<script setup>
import RoundRight from '@/components/buttons/RoundRight.vue'

defineProps({
    title: {
        type: String,
        default: "Our Projects",
    },
    description: {
        type: String,
        default: "Explore our amazing projects showcasing creativity and innovation.",
    },
    boxes: {
        type: Array,
        default: () => ([
            { topColor: "bg-gray-300", bottomColor: "bg-blue-700" },
            { topColor: "bg-gray-300", bottomColor: "bg-pink-700" }
        ]),
    },
});
</script>

<style scoped>
.project-title {
    font-size: 39px;
    font-weight: 800;
    color: var(--color-primary);
    text-align: center;
}

@media (max-width: 1024px) {
    .project-title {
        font-size: 90px;
    }
}

@media (max-width: 768px) {
    .project-title {
        font-size: 60px;
    }
}

@media (max-width: 480px) {
    .project-title {
        font-size: 40px;
    }
}
</style>
