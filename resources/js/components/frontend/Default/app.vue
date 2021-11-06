
<template>
<div>
          <navbar :app="this"></navbar>
            <!-- Main content -->
                        <div class="container-fluid">
                            <router-view/>
                        </div>
            <!-- Main content -->

            <projectfooter :app="this"></projectfooter> 
</div>
</template>

<script>
import navbar from './HEADER/header'
// import login_navbar from '../../backend/Login/login_nav'
// import sidebar from './side_bar'
import projectfooter from './FOOTER/footer'
export default {
name:'app',
components:{
navbar,
projectfooter,
// // contentHeader
},
data(){
    return{

    }
},
methods:{

},
created(){
    console.log("app Loaded")
}
}
</script>
