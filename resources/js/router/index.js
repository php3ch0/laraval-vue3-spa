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
import AccountIndex from '@/js/pages/account/index';
import AdminIndex from '@/js/pages/admin/index';
import AdminUsersIndex from '@/js/pages/admin/users/index';
import AdminUsersView from '@/js/pages/admin/users/view';

const router = createRouter({
    history: createWebHistory(),
    routes: [

        { path: "/", meta: {auth:['user','admin'] }, name: 'Home', component: Home },
        { path: "/account", meta: {auth:['user','admin'] },name: 'Account', component: AccountIndex },

        { path: '/admin', meta: {auth:['admin'] }, name: 'AdminIndex', component: AdminIndex},
        { path: '/admin/users', meta: {auth:['admin'] }, name: 'AdminUsersIndex', component: AdminUsersIndex},
        { path: '/admin/users/:id', meta: {auth:['admin'] }, name: 'AdminUsersView', component: AdminUsersView},



        { path: "/confirm-password", meta: {auth:['user','admin'] }, name: 'ConfirmPassword', component: ConfirmPassword },
        { path: "/register", name: 'Register', component: Register },


        { path: "/login", name: 'Login', component: Login },
        { path: "/verify-email", name: 'VerifyEmail', component: VerifyEmail },
        { path: "/two-factor-challenge", name: 'TwoFactorChallenge', component: TwoFactorChallenge },
        { path: "/forgot-password", name: 'ForgotPassword', component: ForgotPassword },
        { path: "/reset-password/:token", name: 'ResetPassword', component: ResetPassword },


        { path: '/:pathMatch(.*)*', name: '404', component: NotFound}
    ],
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
