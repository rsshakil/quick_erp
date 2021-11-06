<template>
<div>
    <section>
        <div class="youtubeVideoslider">
            <div class="row">
                <div class="col-7">
                    <video-wrapper :player="'youtube'" :autoplay="true" :playerHeight="350" :height="350" :loop="true" :controls="true" :fitParent="true" :videoId="'PstAqoYLK9k'" />
                </div>
                <div class="col-5">
                    <div class="card bg-light">
                        <article class="card-body mx-auto" style="max-width: 400px;">
                            <h4 class="mt-3 mb-3 text-center">Create Account</h4>
                           
                            <form>
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <input name="" class="form-control" placeholder="Full name" type="text">
                                </div> <!-- form-group// -->
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                    </div>
                                    <input name="" class="form-control" placeholder="Email address" type="email">
                                </div> <!-- form-group// -->
                                <div class="form-group input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                                    </div>
                                    <select class="custom-select" style="max-width: 120px;">
                                        <option selected="">+971</option>
                                        <option value="1">+972</option>
                                        <option value="2">+198</option>
                                        <option value="3">+701</option>
                                    </select>
                                    <input name="" class="form-control" placeholder="Phone number" type="text">
                                </div> <!-- form-group// -->
                                <div class="form-group">
                                    <button type="submit" style="background:rgb(235, 33, 39);border:1px solid rgb(235, 33, 39);" class="btn btn-primary btn-block"> Create Account </button>
                                </div> 
                                </form>
                                 <p class="divider-text">
                                <span class="bg-light">OR</span>
                            </p>
                            <h4 class="card-title mt-3 text-left">Trace your percel</h4>
                                <div class="form-group input-group">
                                    
                                    <input class="form-control" placeholder="Trucking number" type="text" style="border:1px solid rgb(235, 33, 39);">
                                   <div class="input-group-append" style="background:rgb(235, 33, 39);">
                                        <span class="input-group-text" style="background:rgb(235, 33, 39);border:1px solid rgb(235, 33, 39); color:#fff">Truck</span>
                                    </div>
                                </div> <!-- form-group end.// -->
                               
                        </article>
                    </div> <!-- card.// -->
                </div>
            </div>
        </div>
    </section>
    <section class="slider_clients" style="padding-top:30px;padding-bottom:30px;">
        <div class="row">
            <div class="col-12 text-center">
                <h4 class="text-center">Our Clients</h4>
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients1.png'" alt="No ads" class="img-responsive">
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients2.png'" alt="No ads" class="img-responsive">
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients3.png'" alt="No ads" class="img-responsive">
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients1.png'" alt="No ads" class="img-responsive">
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients2.png'" alt="No ads" class="img-responsive">
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients3.png'" alt="No ads" class="img-responsive">
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients1.png'" alt="No ads" class="img-responsive">
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients2.png'" alt="No ads" class="img-responsive">
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients3.png'" alt="No ads" class="img-responsive">
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients1.png'" alt="No ads" class="img-responsive">
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients2.png'" alt="No ads" class="img-responsive">
            </div>
            <div class="col-1">
                <img :src="BASE_URL+'/public/images/clients/clients3.png'" alt="No ads" class="img-responsive">
            </div>

        </div>
    </section>
    <section class="slider_clients" style="padding-top:30px;padding-bottom:30px;">
        <div class="row">
            <div class="col-12 text-center">
                <h4 class="text-center">Our Services</h4>
            </div>

        </div>
        <div class="row">
            <div class="col-3">
                <img :src="BASE_URL+'/public/images/services/service1.jpg'" alt="No ads" class="img-responsive">
                <h4>Services 1</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make</p>
            </div>
            <div class="col-3">
                <img :src="BASE_URL+'/public/images/services/service2.jpg'" alt="No ads" class="img-responsive">
                <h4>Services 2</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make</p>
            </div>
            <div class="col-3">
                <img :src="BASE_URL+'/public/images/services/service3.jpg'" alt="No ads" class="img-responsive">
                <h4>Services 3</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make</p>
            </div>
            <div class="col-3">
                <img :src="BASE_URL+'/public/images/services/service4.jpg'" alt="No ads" class="img-responsive">
                <h4>Services 4</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make</p>
            </div>
        </div>
    </section>

</div>
</template>

<script>
export default {
    data() {
        return {
            BASE_URL: `${process.env.MIX_APP_URL}`,
        }
    },
    methods: {

    },
    created() {
        console.log(this.BASE_URL);
    }
}
</script>
<style>
.divider-text {
    position: relative;
    text-align: center;
    margin-top: 15px;
    margin-bottom: 15px;
}
.divider-text span {
    padding: 7px;
    font-size: 12px;
    position: relative;   
    z-index: 2;
}
.divider-text:after {
    content: "";
    position: absolute;
    width: 100%;
    border-bottom: 1px solid #ddd;
    top: 55%;
    left: 0;
    z-index: 1;
}

</style>
