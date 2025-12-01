import { defineStore } from "pinia";
import api from "@/api/axios";
import router from "@/router";
import { jwtDecode } from "jwt-decode";

export const useUserStore = defineStore("user", {
  state: () => ({
    token: localStorage.getItem("token") || null,
    user: null,
    favorites: [],
    isLoading: false,
    error: null,
    succes: null,
    errors: {},
  }),
  getters: {
    isAdmin: (state) => {
      return state.user?.roles?.includes("ROLE_ADMIN") ?? false;
    },
  },
  actions: {
    initUserFromToken() {
      if (!this.token) return false;

      try {
        const decoded = jwtDecode(this.token);

        const now = Date.now() / 1000;

        if (decoded.exp && decoded.exp < now) {
          console.warn("Token expiré.");
          this.logout();
          return false;
        }

        this.user = {
          id: decoded.id,
          email: decoded.email,
          pseudo: decoded.pseudo,
          roles: decoded.roles || [],
        };
        return true;
      } catch (error) {
        console.error("Token invalide :", error);
        this.logout();
        return false;
      }
    },

    async login(email, password) {
      this.isLoading = true;
      this.error = null;
      try {
        const { data } = await api.post("/login", { email, password });
        this.token = data.token;
        localStorage.setItem("token", this.token);

        this.initUserFromToken();

        this.succes = "Connexion réussie, redirection vers votre profil.";
        setTimeout(() => {
          router.push("/profil");
        }, 2000);

      } catch (err) {
        if (err.response?.data?.message) {
          this.error = err.response.data.message;
        } else if (err.request) {
          try {
            console.log(err.request);
            const responseData = JSON.parse(err.request.response || "{}");
            this.error = responseData.message || "Erreur serveur inconnue";
          } catch {
            this.error = "Erreur serveur non reconnue.";
          }
        } else {
          this.error = err.message || "Erreur inconnue.";
        }
      } finally {
        this.isLoading = false;
      }
    },
    async register(email, pseudo, password, confirmPassword) {
      this.isLoading = true;
      this.errors = {};
      try {
        await api.post("/register", {
          email,
          pseudo,
          password,
          confirmPassword,
        });
        
        router.push("/login");
      } catch (err) {
        if (err.response?.data?.violations) {
          err.response.data.violations.forEach((v) => {
            this.errors[v.propertyPath] = v.message;
          });
        } else if (
          err.response?.data &&
          typeof err.response.data === "object"
        ) {
          Object.assign(this.errors, err.response.data);
        } else if (err.request) {
          try {
            const responseData = JSON.parse(err.request.response || "{}");
            if (typeof responseData === "object") {
              Object.assign(this.errors, responseData);
            } else {
              this.errors.general = responseData;
            }
          } catch {
            this.errors.general =
              "Erreur serveur non reconnue : " + err.request.response;
          }
        } else {
          this.errors = err.message || "Erreur inconnue";
        }
      } finally {
        this.isLoading = false;
      }
    },

    logout() {
      this.token = null;
      this.user = null;
      this.favorites = [];
      localStorage.removeItem("token");
      router.push("/login");
    },
    async fetchUserFavorites() {
      if (!this.user) {
        console.log("Utilisateur non connecté");
        return;
      }

      const { data } = await api.get(`/users/${this.user.id}/favorites`);
      this.favorites = data;
    },
    async addFavorite(movieId) {
      if (!this.user) return;

      const response = await api.post(`/users/${this.user.id}/favorites`, {
        movie_id: movieId,
      });

      const favorite = response.data;

      if (!this.favorites.find((f) => f.id === favorite.id)) {
        this.favorites.unshift(favorite);
      }
    },
    async removeFavorite(movieId) {
      await api.delete(`/users/${this.user.id}/favorites/${movieId}`);

      this.favorites = this.favorites.filter((f) => f.id !== movieId);
    },
  },
});
