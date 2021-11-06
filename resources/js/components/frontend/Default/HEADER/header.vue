<template>
<div>
    <section class="w3l-bootstrap-header">
  <nav class="navbar navbar-expand-lg navbar-light py-lg-2 py-2">
    <div class="container">
    <router-link :to="{name:'home'}" class="navbar-brand" ><img class="weblogo" :src="BASE_URL+'/public/images/logo.jpg'" alt="new-redx-logo.svg"></router-link>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon fa fa-bars"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item" style="padding-top:10px;">
          <a class="call-us-link" href="tel:+09610007339"><img src="https://redx.com.bd/images/revamp/phone-icon.svg" alt="Phone Icon"><p class="css-93h3gp" style="text-transform: none; font-family: NotoSansBengali, sans-serif;">কল করুন</p> <p class="redx-phone css-93h3gp" style="text-transform: none; font-family: NotoSansBengali, sans-serif;">০১৮৬৬৭৭৬৯৭০</p></a>
        </li>
        <li class="nav-item">
            <a href="admin" class="btn btn-default custombtnlog">Login</a>
          <!-- <router-link :to="{name:'admin_login'}" class="btn btn-default custombtnlog" >Login</router-link> -->
        </li>
        <li class="nav-item">
          <router-link :to="{name:'signup'}" class="btn btn-default custombtnlog">Register</router-link>
        </li>
      </ul>

    </div>
  </div>
  </nav>
</section>
</div>
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
.custombtnlog{
    border:1px solid red !important;
}
.weblogo{
  width:200px;
}
.css-93h3gp {
    font-size: 16px;
    font-weight: normal;
    font-stretch: normal;
    font-style: normal;
    line-height: 24px;
    color: rgb(66, 66, 66);
    margin-left:10px;
    float:right;
}
.nav-links .redx-phone {
    color: rgb(235, 33, 39);
}
.nav-links a.call-us-link {
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    margin-right: 20px;
    -webkit-box-align: center;
    align-items: center;
    width: 200px;
}
</style>
