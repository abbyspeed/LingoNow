import { createRouter, createWebHistory } from 'vue-router'
import store from './store'
import HomePage from './pages/HomePage.vue'
import LoginPage from './pages/LoginPage.vue'
import SignupPage from './pages/SignupPage.vue'
import SearchPage from './pages/SearchPage.vue'
import AboutUsPage from './pages/AboutUsPage.vue'
import CategoriesPage from './pages/CategoriesPage.vue'
import AdminHomePage from './pages/AdminHomePage.vue'
import AdminCreatePage from './pages/AdminCreatePage.vue'
import AdminAboutPage from './pages/AdminAboutPage.vue'
import AdminUpdatePage from './pages/AdminUpdatePage.vue'
import AdminStatsPage from './pages/AdminStatsPage.vue'
import AdminManagePage from './pages/AdminManagePage.vue'
import AdminProfilePage from './pages/AdminProfilePage.vue'
import AdminProfileUpdatePage from './pages/AdminProfileUpdatePage.vue'

const routes = [
  { path: '/', name: "Home", component: HomePage },
  { path: '/Login', name: "Login", component: LoginPage },
  { path: '/Signup', name: "Signup", component: SignupPage },
  { path: '/Search', name: "Search", component: SearchPage },
  { path: '/About', name: "About", component: AboutUsPage },
  { path: '/Categories', name:"Categories", component: CategoriesPage },

  // Admin routes
  // { path: '/Admin/Home', name: "AdminHome", component: AdminHomePage, meta: { requiresAuth: true } },
  // { path: '/Admin/About', name: "AdminAbout", component: AdminAboutPage, meta: { requiresAuth: true } },
  // { path: '/Admin/Manage', name: "AdminManage", component: AdminManagePage, meta: { requiresAuth: true } },
  // { path: '/Admin/Stats', name: "AdminStats", component: AdminStatsPage, meta: { requiresAuth: true } },
  // { path: '/Admin/Profile', name: "AdminProfile", component: AdminProfilePage, meta: { requiresAuth: true } },

  // { path: '/Admin/Manage/Create', name:"AdminCreate", component: AdminCreatePage, meta: { requiresAuth: true } },
  // { path: '/Admin/Manage/:id/Update', name: "UpdateSlang", component: AdminUpdatePage, meta: { requiresAuth: true } },
  // { path: '/Admin/Profile/:id/Update', name: "UpdateProfile", component: AdminProfileUpdatePage, meta: { requiresAuth: true } },

  // Testing
  { path: '/Admin/Home', name: "AdminHome", component: AdminHomePage},
  { path: '/Admin/About', name: "AdminAbout", component: AdminAboutPage},
  { path: '/Admin/Manage', name: "AdminManage", component: AdminManagePage},
  { path: '/Admin/Stats', name: "AdminStats", component: AdminStatsPage},
  { path: '/Admin/Profile', name: "AdminProfile", component: AdminProfilePage},

  { path: '/Admin/Manage/Create', name:"AdminCreate", component: AdminCreatePage},
  { path: '/Admin/Manage/:id/Update', name: "UpdateSlang", component: AdminUpdatePage},
  { path: '/Admin/Profile/:id/Update', name: "UpdateProfile", component: AdminProfileUpdatePage},
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

// Route guards
router.beforeEach((to, from, next) => {
  const isAuthenticated = store.state.user;
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

  if (requiresAuth && !isAuthenticated) {
    next('/Login'); 

  } else {
    next();
  }
});

export default router;