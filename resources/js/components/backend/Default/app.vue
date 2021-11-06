
<template>
<div>
            <navbar v-if="token" :app="this"></navbar>
            <login_navbar v-else :app="this"></login_navbar>
            <sidebar v-if="token" :app="this"></sidebar>

         <div class="content-wrapper">
            <!-- <contentHeader :app="this"></contentHeader> -->
             <!-- Main content -->
                    <section class="content">
                        <div class="container-fluid">
                            <router-view/>
                        </div>
                    </section>
                     <!-- Main content -->
            </div>

            <projectfooter :app="this"></projectfooter>
</div>
</template>

<script>

export default {
name:'app',
components:{
navbar: () => import(/* webpackChunkName: "backend/navbar" */ './navbar.vue'),
login_navbar: () => import(/* webpackChunkName: "backend/login_navbar" */ '../../backend/Login/login_nav'),
sidebar: () => import(/* webpackChunkName: "backend/sidebar" */ './side_bar'),
projectfooter: () => import(/* webpackChunkName: "backend/projectfooter" */ './project_footer')
},
data(){
    return{
        user:null,
        loading:false,
        initiated:false,
        token: null,
    }
},
methods:{
    token_set(){
        // localStorage.removeItem(key)
            this.token=this.getWithExpiry('token')
            if (this.token==null) {
                this.$router.push({name:'admin_login'}).catch(()=>{});
            }
    }
},
created(){
    this.token_set()
    Fire.$on("header_nav", () => {
        // console.log("Token Checked")
            this.token_set();
        });
        // this.$store.commit('UserDetailsModule/loadUserData')
}
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
