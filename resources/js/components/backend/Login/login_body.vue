<template>
  <div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">

<!--<img :src="logoSrc" id="icon" alt="User Icon" />-->
    </div><br/>
    <!-- Login Form -->
    <div class="row">
        <div class="col-md-3"></div>

        <div class="col-md-6">
            <div class="card">

                <form method="POST" @submit.prevent="login" class="box">

                    <h1>Login</h1>
                    <p class="text-muted"> Please enter your login and password!</p> <input type="text"  v-model="email" placeholder="Username"> <input type="password"  v-model="password" placeholder="Password"> <a class="forgot text-muted" href="#">Forgot password?</a> <input type="submit" value="Login">
                    <div class="col-md-12">
                        <ul class="social-network social-circle">
                            <li><a href="#" class="icoFacebook" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" class="icoGoogle" title="Google +"><i class="fab fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    

    <!-- Remind Passowrd -->
    <div id="formFooter">
        <a class="underlineHover" href="template_vue/password/reset"></a>
      <!-- <a class="underlineHover" href="#">Go to the Site</a> -->
    </div>

  </div>
</div>
</template>
<style>
.card {
    margin-bottom: 20px;
    border: none
}

.box {
    width: 100%;
    position: relative;
    background: #1A1E33;
    text-align: center;
    transition: 0.25s;
    margin: 0 auto;
    padding: 50px;
}

.box input[type="text"],
.box input[type="password"] {
    border: 0;
    background: none;
    display: block;
    margin: 20px auto;
    text-align: center;
    border: 2px solid #3498db;
    padding: 10px 10px;
    width: 250px;
    outline: none;
    color: white;
    border-radius: 24px;
    transition: 0.25s
}

.box h1 {
    color: #ED212A;
    text-transform: uppercase;
    font-weight: 500
}

.box input[type="text"]:focus,
.box input[type="password"]:focus {
    width: 300px;
    border-color: #2ecc71
}

.box input[type="submit"] {
    border: 0;
    background: none;
    display: block;
    margin: 20px auto;
    text-align: center;
    border: 2px solid red;
    padding: 14px 40px;
    outline: none;
    color: white;
    border-radius: 24px;
    transition: 0.25s;
    cursor: pointer
}

.box input[type="submit"]:hover {
    background: #2ecc71
}

.forgot {
    text-decoration: underline
}

ul.social-network {
    list-style: none;
    display: inline;
    margin-left: 0 !important;
    padding: 0
}

ul.social-network li {
    display: inline;
    margin: 0 5px
}

.social-network a.icoFacebook:hover {
    background-color: #3B5998
}

.social-network a.icoTwitter:hover {
    background-color: #33ccff
}

.social-network a.icoGoogle:hover {
    background-color: #BD3518
}

.social-network a.icoFacebook:hover i,
.social-network a.icoTwitter:hover i,
.social-network a.icoGoogle:hover i {
    color: #fff
}

a.socialIcon:hover,
.socialHoverClass {
    color: #44BCDD
}

.social-circle li a {
    display: inline-block;
    position: relative;
    margin: 0 auto 0 auto;
    border-radius: 50%;
    text-align: center;
    width: 50px;
    height: 50px;
    font-size: 20px
}

.social-circle li i {
    margin: 0;
    line-height: 50px;
    text-align: center
}

.social-circle li a:hover i,
.triggeredHover {
    transform: rotate(360deg);
    transition: all 0.2s
}

.social-circle i {
    color: #fff;
    transition: all 0.8s;
    transition: all 0.8s
}
</style>
<script>
  export default {
    data() {
      return {
        email: null,
        password: null,
        logoSrc:'',
        has_error: false
      }
    },
    methods: {
      login() {
          axios.post('auth/login',{email:this.email,password:this.password}).then(({data})=>{
            this.setWithExpiry("token", data.access_token, data.expires_in) //3600 sec or 1 hour
            localStorage.setItem("user", JSON.stringify(data.user))
            localStorage.setItem("Permissions", JSON.stringify(data.permissions))
            localStorage.setItem("Roles", JSON.stringify(data.roles))
            localStorage.setItem("log_first", 1)
            axios.defaults.headers.common['Authorization'] =`Bearer ${this.getWithExpiry("token")}` ;
            this.$router.push({ name: 'admin_home',path:'/admin/home'})
            console.log('loged');
            Fire.$emit('header_nav');
          })
          .catch(() => {
                this.alert_icon='error',
                this.alert_title='Ohh!!',
                this.alert_text='User name or password missmatch'
                this.sweet_advance_alert();
            });
      }
    },
    mounted() {
      //
    },
    created(){
        this.logoSrc = '../public/dashboard/logo/cropped-Jacos-main.png';
        Fire.$emit('header_nav');
    }
  }
</script>


