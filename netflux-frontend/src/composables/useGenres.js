import { ref } from "vue";
import api from "@/api/axios";

const genres = ref([]);
const genre = ref();
const isLoading = ref(false);
const error = ref(null);

export function useGenres() {
  async function fetchGenres() {
    isLoading.value = true;
    error.value = null;

    try {
      const { data } = await api.get("/genres");
      genres.value = data.member;
    } catch (err) {
      error.value = err.response?.data.message || err.message;
    } finally {
      isLoading.value = false;
    }
  }

  async function fetchGenre(id) {
    isLoading.value = true;
    error.value = null;

    try {
      const { data } = await api.get(`/genres/${id}`);
      genre.value = data;
    } catch (err) {
      error.value = err.response?.data.message || err.message;
    } finally {
      isLoading.value = false;
    }
  }

  async function addGenre(data) {
    error.value = null;

    try {
      const response = await api.post("/genres", data);
      genres.value.unshift(response.data);
    } catch (err) {
      error.value = err.response?.data.message || err.message;
    }
  }

  async function updateGenre(id, data) {
    error.value = null;

    try {
      const response = await api.put(`/genres/${id}`, data);
      const index = genres.value.findIndex((m) => m.id === Number(id));
      if (index !== -1) {
        genres.value[index] = response.data;
      }
      return response.data;
    } catch (err) {
      error.value = err.response?.data.message || err.message;
    }
  }

  async function deleteGenre(id) {
    error.value = null;

    try {
      await api.delete(`/genres/${id}`);
      genres.value = genres.value.filter((m) => m.id !== id);
    } catch (err) {
      error.value =
        err?.message || "Erreur lors de la suppression du film ou de la série.";
      throw err;
    }
  }

  return {
    genre,
    genres,
    fetchGenre,
    fetchGenres,
    addGenre,
    updateGenre,
    deleteGenre,
    isLoading,
    error,
  };
}
