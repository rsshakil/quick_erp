// import Home from '../components/home_component.vue'
const home = () =>
    import ( /* webpackChunkName: "frontend/home" */ '../components/home_component.vue')
const Login = () =>
    import ( /* webpackChunkName: "backend/Login" */ '../../backend/Login/login_body.vue')
const signup = () =>
    import ( /* webpackChunkName: "frontend/home" */ '../components/SIGNUP/signup.vue')

export const routes = [

    { path: '/', redirect: '/home' },
    {
        path: '/home',
        name: 'home',
        component: home,
    },
    { path: '/signup', name: 'signup', component: signup },

];