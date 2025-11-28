<template>
    <nav>
        <router-link class="link" to="/">Netflux</router-link>
        <router-link class="link" to="/favorites">Favoris</router-link>
        <router-link class="link" to="/movies">Films & Séries</router-link>
        <router-link class="link" :to="store.user ? '/profil' : '/login'">{{ store.user ? store.user.pseudo :
            "Connexion" }}</router-link>
        <router-link v-if="isAdmin" class="link" to="/admin">Dashboard</router-link>
    </nav>


</template>
<script setup>
import { useUserStore } from '@/stores/user';
import { onMounted, computed } from 'vue';

const store = useUserStore();

onMounted(() => {
    store.initUserFromToken();
});

const isAdmin = computed(() => store.isAdmin)


</script>
<style scoped>
nav {
    padding: 15px;
    display: flex;
    gap: 20px;
    border-bottom: 3px solid var(--graphite);
    justify-content: center;
}

.link {
    text-decoration: none;
    color: var(--cyan-cold);
    font-size: 1.8rem;
    text-shadow: 6px 4px 4px black;
}

.link:hover {
    color: var(--blue-ice);
    transform: scale(1.2);
}

.container {
    width: 100%;
    max-width: 100%;
}



@media only screen and (max-width: 600px) {
    nav {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
}
</style>