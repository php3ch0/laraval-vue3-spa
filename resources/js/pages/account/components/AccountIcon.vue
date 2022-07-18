<script setup>

const props = defineProps({
    name: String,
    icon: {
        type: String,
        default: null,
    },
    icon_image: {
        type: String,
        default: null,
    },
    link: {
        type: String,
        default: null,
    },

});

</script>
<template>
<div id="AccountIcon">
    <Link :href="props.link">
        <div class="AccountIcon">
            <div class="image">
                <img v-if="props.icon_image" :src="props.icon_image" :alt="name" />
                <i v-if="props.icon" :class="props.icon"></i>
            </div>
            <div class="text">
                {{ props.name }}
            </div>
        </div>
    </Link>
</div>



</template>
