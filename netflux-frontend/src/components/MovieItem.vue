<template>
    <div>
        <p>{{ formattedType }}</p>
        <p>{{ genreNames }}</p>
        <p>{{ formattedDate }}</p>
        <p>{{ formattedDuration || noTime }}</p>
    </div>
</template>
<script setup>
import { computed } from 'vue';

const props = defineProps({
    movie: {
        type: Object
    }
});

const genreNames = computed(() => {
    return props.movie.genres.map(g => g.name).join(', ');
});

const formattedDate = computed(() => {
    return new Intl.DateTimeFormat('fr-FR', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    }).format(new Date(props.movie.releaseDate));
});

const formattedDuration = computed(() => {
    const noTime = "Inconnu";
    if (!props.movie.duration) {
        return noTime;
    } else {
        const total = props.movie.duration;
        const hours = Math.floor(total / 60);
        const minutes = total % 60;
        if(hours === 0) {
            return `${minutes} min`;
        }

        return `${hours}h ${minutes.toString().padStart(2, '0')}min`;
    }
});

const formattedType = computed(() => {
    if(props.movie.type === "movie") {
        return "Film";
    } else return "Série";
})
</script>
<style scoped></style>