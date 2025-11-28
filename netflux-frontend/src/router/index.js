import { createRouter, createWebHistory } from "vue-router";
import HomeView from "@/views/HomeView.vue";
import LoginView from "@/views/LoginView.vue";
import FavoritesView from "@/views/FavoritesView.vue";
import MovieListView from "@/views/MovieListView.vue";
import MovieDetailView from "@/views/MovieDetailView.vue";
import ProfilView from "@/views/ProfilView.vue";
import RegisterView from "@/views/RegisterView.vue";
import { useUserStore } from "@/stores/user";
import AdminView from "@/views/AdminView.vue";
import MoviesDashboard from "@/components/MoviesDashboard.vue";
import UsersDashboard from "@/components/UsersDashboard.vue";
import GenresDashboard from "@/components/GenresDashboard.vue";
import GenresForm from "@/components/GenresForm.vue";
import MovieForm from "@/components/MovieForm.vue";

const routes = [
  { path: "/", name: "home", component: HomeView },
  { path: "/login", name: "login", component: LoginView },
  {
    path: "/profil",
    name: "profil",
    component: ProfilView,
    meta: { requiresAuth: true },
  },
  {
    path: "/favorites",
    name: "favorites",
    component: FavoritesView,
    meta: { requiresAuth: true },
  },
  { path: "/movies", name: "movies", component: MovieListView },
  {
    path: "/movies/:id",
    name: "movie",
    component: MovieDetailView,
    props: true,
  },
  { path: "/register", name: "register", component: RegisterView },
  {
    path: "/admin",
    name: "adminPanel",
    component: AdminView,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "/admin/movies",
    name: "adminMoviesPanel",
    component: MoviesDashboard,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {},
  {
    path: "/admin/users",
    name: "adminUsersPanel",
    component: UsersDashboard,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "/admin/movies/genres",
    name: "adminGenresPanel",
    component: GenresDashboard,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "/admin/movies/genres/:id",
    name: "updateGenre",
    component: GenresForm,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "/admin/movies/genres/new",
    name: "addGenre",
    component: GenresForm,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "/admin/movies/new",
    name: "addMovie",
    component: MovieForm,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "/admin/movies/:id",
    name: "updateMovie",
    component: MovieForm,
    meta: { requiresAuth: true, requiresAdmin: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to) => {
  const store = useUserStore();

  if (to.meta.requiresAuth && !store.token) {
    return { name: "login" };
  }

  if (to.meta.requiresAdmin) {
    const isAdmin = store.user?.roles?.includes("ROLE_ADMIN");
    if (!isAdmin) {
      return { name: "home"};
    }
  }

});

export default router;
