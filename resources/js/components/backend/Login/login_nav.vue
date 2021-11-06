<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
                <div class="collapse navbar-collapse" id="navbarsExample09">
                 <ul class="navbar-nav  flex-row ">
                                <li class="nav-item">
    <router-link :to="{name:'/'}" class="navbar-brand" ><img class="weblogo" :src="BASE_URL+'/public/images/logo.jpg'" alt="new-redx-logo.svg"></router-link>

                                </li>
                                </ul>
                        <ul class="navbar-nav  float-right pull-right text-right">
                               
                                <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-nowrap px-3" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="flag-icon flag-icon-jp"></span> 日本語
                                            <span class="flag-icon flag-icon-us"></span> English
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-small" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" :href="BASE_URL+'language/en'"><span class="flag-icon flag-icon-us"></span> English</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" :href="BASE_URL+'language/ja'"><span class="flag-icon flag-icon-jp"></span> 日本語</a>
                                        </div>
                                    </li>
                        </ul>

                </div>
            </nav>
</template>
<script>

export default {
data(){
    return{
        BASE_URL: `${process.env.MIX_APP_URL}`,
    }
},
methods:{
    
},
created(){
    console.log(this.BASE_URL);
}
}
</script>
<style>
.weblogo{
  width:200px;
}
</style>


