import { ref } from "vue";
import api from "@/api/axios";
import { useMovieErrors } from "./useMovieErrors";

const movies = ref([]);
const movie = ref();
const isLoading = ref(false);
const error = ref(null);
const page = ref(1);
const limit = ref(15);
const totalItems = ref(0);
const { errors, globalError, setViolations, resetErrors } = useMovieErrors();

export function useMovies() {
  async function fetchMovies() {
    isLoading.value = true;
    error.value = null;

    try {
      const { data } = await api.get("/movies", {
        params: { page: page.value, limit: limit.value },
      });
      movies.value = data.member;
      totalItems.value = data.totalItems;
    } catch (err) {
      error.value = err.response?.data.message || err.message;
    } finally {
      isLoading.value = false;
    }
  }

  async function fetchMovie(id) {
    isLoading.value = true;
    error.value = null;

    try {
      const { data } = await api.get(`/movies/${id}`);
      movie.value = data;
    } catch (err) {
      error.value = err.response?.data.message || err.message;
    } finally {
      isLoading.value = false;
    }
  }

  async function createMovie(data) {
    isLoading.value = true;
    resetErrors();
    try {
      const response = await api.post("/movies", data, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });

      movies.value.unshift(response.data);
      return response.data;
    } catch (err) {
      if (err.response?.data?.violations) {
        setViolations(err.response.data.violations);
      } else {
        globalError.value = "Erreur serveur lors de la création du film";
      }
    } finally {
      isLoading.value = false;
    }
  }

  async function updateMovie(id, data) {
    isLoading.value = true;
    resetErrors();

    try {
      const response = await api.post(`/movies/${id}`, data, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });
      const index = movies.value.findIndex((m) => m.id === Number(id));
      if (index !== -1) {
        movies.value[index] = response.data;
      }
      return response.data;
    } catch (err) {
      if (err.response?.data?.violations) {
        setViolations(err.response.data.violations);
      } else {
        globalError.value = "Erreur serveur lors de la mise à jour du film";
      }
    } finally {
      isLoading.value = false;
    }
  }

  async function deleteMovie(id) {
    error.value = null;

    try {
      await api.delete(`/movies/${id}`);
      movies.value = movies.value.filter((m) => m.id !== id);
    } catch (err) {
      error.value =
        err?.message || "Erreur lors de la suppression du film ou de la série.";
      throw err;
    }
  }

  return {
    movies,
    movie,
    error,
    isLoading,
    page,
    limit,
    totalItems,
    fetchMovies,
    fetchMovie,
    createMovie,
    updateMovie,
    deleteMovie,
    errors,
    globalError,
  };
}
