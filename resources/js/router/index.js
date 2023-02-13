import { createRouter, createWebHistory } from "vue-router";
import store from '@/js/stores'
import NotFound from '@/js/pages/errors/404'
import Register from '@/js/pages/auth/Register'
import Login from '@/js/pages/auth/Login'
import TwoFactorChallenge from '@/js/pages/auth/TwoFactorChallenge'
import ForgotPassword from '@/js/pages/auth/ForgotPassword'
import ResetPassword from '@/js/pages/auth/ResetPassword'
import VerifyEmail from '@/js/pages/auth/VerifyEmail'

import ConfirmPassword from '@/js/pages/auth/ConfirmPassword'
import Home from '@/js/pages/Home'

/* Account */
import AccountPage from '@/js/pages/account/index';
import TwoFactorAuth from "@/js/pages/account/2fa/index";
import PasswordUpdate from "@/js/pages/account/password/index";
import Profile from "@/js/pages/account/profile/index";
import AccountIndex from "@/js/pages/account/components/AccountIndex";

/* Pages */
import Contact from '@/js/pages/contact/index';
import Cookies from "@/js/pages/legal/Cookies";
import Terms from "@/js/pages/legal/Terms";
import Privacy from "@/js/pages/legal/Privacy";
import About from "@/js/pages/about";
import Clients from "@/js/pages/clients";
import Candidates from "@/js/pages/candidates";
import Membership from "@/js/pages/membership";
import Accreditation from "@/js/pages/accreditation";


import Blog from "@/js/pages/blog";
import BlogView from "@/js/pages/blog/view";
import Auth from "@/js/pages/auth/index";


/*Admin */
import AdminIndex from "@/js/pages/admin/index";
import AdminDashboard from "@/js/pages/admin/dashboard";
import AdminUsersIndex from '@/js/pages/admin/users/index';
import AdminUsersView from '@/js/pages/admin/users/view';

import AdminWidgetsIndex from "@/js/pages/admin/widgets/Index";
import AdminWidgetsEdit from "@/js/pages/admin/widgets/Edit";

import AdminGalleriesIndex from "@/js/pages/admin/galleries/index";
import AdminGalleriesEdit from "@/js/pages/admin/galleries/edit";

import AdminBlogIndex from "@/js/pages/admin/blog/index";
import AdminBlogEdit from "@/js/pages/admin/blog/edit";





const router = createRouter({
    history: createWebHistory(),
    routes: [

        { path: "/", name: 'Home', component: Home },

        { path: "/contact", name: 'Contact', component: Contact },

        { path: "/about", name: 'About', component: About },

        { path: "/clients", name: 'Clients', component: Clients },
        { path: "/candidates", name: 'Candidates', component: Candidates },
        { path: "/membership", name:  'Membership', component: Membership },
        { path: "/accreditation", name:  'Accreditation', component: Accreditation },

        { path: "/blog", name: 'BlogPage', component: Blog },
        { path: "/blog/:slug", name: 'BlogView', component: BlogView },




        { path: "/account", meta: {auth:['user','admin'] },name: 'Account', component: AccountPage,
            children: [
                {path:"", name: 'Index', component: AccountIndex},
                {path:"password", name: 'Password', component: PasswordUpdate},
                {path:"profile", name: 'Profile', component: Profile},
                {path:"2fa", name: 'TwoFactor', component: TwoFactorAuth}
            ]
        },



        { path: '/admin', meta: {auth:['admin'] }, name: 'AdminIndex', component: AdminIndex,
            children: [
                { path: '', name: 'AdminDashboard',component: AdminDashboard},
                { path: '/admin/users', name: 'AdminUsersIndex', component: AdminUsersIndex},
                { path: '/admin/users/:id', name: 'AdminUsersView', component: AdminUsersView},

                {path: '/admin/widgets', name: 'AdminWidgets', component: AdminWidgetsIndex},
                {path: '/admin/widgets/:id', name: 'AdminWidgetsEdit', component: AdminWidgetsEdit},

                {path: '/admin/galleries', name: 'AdminGalleries', component: AdminGalleriesIndex},
                {path: '/admin/galleries/:id', name: 'AdminGalleriesEdit', component: AdminGalleriesEdit},


                {path: '/admin/blog', name: 'AdminBlog', component: AdminBlogIndex},
                {path: '/admin/blog/:id', name: 'AdminBlogEdit', component: AdminBlogEdit}
            ]
        },


        { path: "/", name: 'Auth', component: Auth,
            children: [
                { path: "/register", name: 'Register', component: Register },
                { path: "/confirm-password", meta: {auth:['user','admin'] }, name: 'ConfirmPassword', component: ConfirmPassword },
                { path: "/login", name: 'Login', component: Login },
                { path: "/verify-email", name: 'VerifyEmail', component: VerifyEmail },
                { path: "/two-factor-challenge", name: 'TwoFactorChallenge', component: TwoFactorChallenge },
                { path: "/forgot-password", name: 'ForgotPassword', component: ForgotPassword },
                { path: "/reset-password/:token", name: 'ResetPassword', component: ResetPassword },
            ]
        },






        { path: "/legal/cookies", name: 'Warranties', component: Cookies },
        { path: "/legal/terms", name: 'Terms', component: Terms },
        { path: "/legal/privacy", name: 'Privacy', component: Privacy },


        { path: '/:pathMatch(.*)*', name: '404', component: NotFound}
    ],
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { top: 0 }
        }
    },
});

router.beforeEach((to, from, next) => {
    if(to.meta.auth && !store.getters.user) {
        next({name: "Login"})
    }
    if(to.meta.auth && !to.meta.auth.includes(store.getters.user.role)) {
        next({name: "Login"})
    } else {
        next();
    }
});

export default router;
