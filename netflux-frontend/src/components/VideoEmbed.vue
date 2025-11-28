<template>
    <div class="youtube-player">
        <iframe v-if="embedUrl" :src="embedUrl" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen width="100%" height="500"></iframe>
        <p class="error-ytb" v-else>URL YouTube invalide ou absent</p>
    </div>
</template>
<script setup>
import { computed, ref } from 'vue';

const props = defineProps({
    url: {
        type: String,
        required: true
    }
});

function getYoutubeEmbedUrl(url) {
    const regex = /(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/;
    const match = url.match(regex);
    return match && match[1] ? `https://www.youtube.com/embed/${match[1]}` : null;
}

const embedUrl = computed(() => getYoutubeEmbedUrl(props.url))
</script>
<style scoped>
.youtube-player iframe {
    border-radius: 0px 0px 6px 6px;
}

.error-ytb{
    color: red;
    text-align: center;
    font-size: 20px;
    opacity: 0.7;
}
</style>