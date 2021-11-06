<template>
<div class="main-content-container container-fluid px-0">
    <form class="form" @submit.prevent="processData()">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <h3 class="page-title">HUB</h3>
        </div>
    </div>
    <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">{{ cardTitle }} </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="offset-md-1 col-md-10 ">
                            <div class="card card-primary">
                                  <div class="card-body">
                                        <div class="form-group row">
                                             <input type="hidden" name="hub_id" v-model="inputData.hub_id">
                                            <div class="col-12" v-role="['Payra Admin']">
                                                <multiselect v-model="inputData.hub" :options="hubs" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select hub" label="hub_name" track-by="hub_id" @select="setHub($event)"></multiselect>
                                               

                                            </div>
                                            <div class="col-md-6">
                                                <label for="name"> Name <span style="font-weight: bold; color: red;">*</span></label>
                                                <input type="text" name="name" v-model="inputData.name" id="name" class="form-control" placeholder="Company Name">
                                            </div>
                                            
                                            <div class="col-md-6"  v-if="isEdit==false">
                                                <label for="email">Email <span style="font-weight: bold; color: red;">*</span> </label>
                                                <input type="email" name="email" v-model="inputData.email" id="email" class="form-control" placeholder="Email" >
                                            </div>

                                            <div class="col-md-6"  v-if="isEdit==false">
                                                <label for="password">Password</label>
                                                <input type="password" name="password" v-model="inputData.password" id="password"  class="form-control" placeholder="Password">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="phone"> Contact Number <span style="font-weight: bold; color: red;">*</span> </label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                    <div class="input-group-text">+88</div>
                                                    </div>
                                                    <input type="text" name="phone" v-model="inputData.phone" id="phone" class="form-control" placeholder=" Contact Number" >
                                                </div>
                                            </div>

                                           
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <!--<button type="submit" class="btn btn-success" @click="addMerchant()">Submit</button>
                                            <button type="reset" class="btn btn-primary" @click="resetMerchantForm()">Reset</button>-->

                                        </div>
                                                      <div class="card-footer">
                           <FormButton :isEdit="isEdit" :backUrl="backUrl"></FormButton>
                        </div>
                                    </div>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
  </form>
</div>
</template>
<script>
export default {
  data() {
    return {
    form:{
    },
    inputData:{},
    isFile:false,
    backUrl: '',
    isImage: '',
    showImage: '',
    notReset: {},
    cardTitle: "",
    inputData: {},
    error: {},
    url: `${process.env.MIX_APP_URL}`, //window.location.origin,
    generalApi: null,
    getApi: null,
    postApi: null,
    patchApi: null,
    editApi: null,
    isEdit:false,


    };
    
  },
  methods: {
      
       processData() {

            let api = this.generalApi != null ? this.generalApi : this.postApi
            let post_api = this.url + 'api/' + api
            let patch_api = this.url + 'api/' + api + '/' + this.inputData.id

            let form = jQuery(document).find('.form');
            let formData = new FormData($(form)[0])

            if (this.isEdit == true) {
                formData.append('_method', 'PUT')
                this.inputData._method = 'PUT'
            }

            let getdata = this.isFile == true ? formData : this.inputData

            let axiosRoute = this.isEdit == false ? axios.post(post_api, getdata) : axios.post(patch_api, getdata)

            axiosRoute.then(response => {
                    // if (this.isSamePage == false) {
                    //     let push_url = '/' + api
                    //     this.$router.push(push_url)
                    // } else {
                    //     if (this.isSamePage == false) {

                    //         this.resetForm()
                    //     } else {
                    //         this.dataList = response.data
                    //     }
                    // }
                    if (response.data.status == 1) {
                        let push_url = '/' + api
                        this.$router.push(push_url)
                    }
                    this.toastMessage(response.data.class_name, response.data.message)
                })
                .catch(error => {
                    // console.log(error.response.status)
                    
                    if (error.response) {
                    if (error.response.status == 422) {
                        this.error = error.response.data.errors
                            
                        $.each(error.response.data.errors, function(item, index) {
                            let input = jQuery(document).find('input[name="' + item + '"]')
                            let inputAfter = jQuery(document).find('input[name="' + item + '"] + span')
                           
                            input.addClass('is-invalid')

                            inputAfter.remove()
                            input.after('<span class="text-danger">' + error.response.data.errors[item] + '</span>')

                        })



                    }
                    }
                })
        },
  },
  created() {

            this.generalApi = 'hub-users'
            this.backUrl = '/hub-users'
            this.isFile = true
            this.isImage = 'image_path'
            /*if edit*/
            if (this.$route.params.id) {
                this.isEdit = true
                axios.get(this.url + 'api' + this.$route.path)
                    .then(res => {

                        let image = this.isImage
                            // console.log(typeof(res.data.data[image]));
                        if (typeof(res.data.data[image]) == 'object') {
                            var i = 0;
                            // res.data.data[image].forEach(image => {
                            //     if(image.name){
                            //         // this.showImage +=
                            //         //'<a href="#" data-imageid="'+image.id+'" class="text-danger deleteImage" style="position:absolute; margin-left:10px; z-index:999; "><i class="fa fa-trash"></i></a><img style="width:100px; height:100px; position:relative; margin:10px; padding:5px;" src="'+res.data.data['image_path']+image.name+'">'
                            //     }

                            // })
                        } else {
                            this.showImage = '<img style="width:150px; height:150px;" src="' + res.data.data[image] + '">'
                        }
                        this.inputData = res.data.data;
                        this.inputData.hub = res.data.data.hubinfo

                    })
            }
            /*if edit*/
            this.cardTitle = this.isEdit ? 'Edit Hub' : 'Add Hub'
            this.getHubs();

        },
  mounted() {
  }
};
</script>
