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
                                          
                                            <div class="col-md-6">
                                                <label for="hub_name">HUB Name <span style="font-weight: bold; color: red;">*</span></label>
                                                <input type="text" name="hub_name" v-model="inputData.hub_name" id="hub_name" class="form-control" placeholder="Company Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="address">Full Address <span style="font-weight: bold; color: red;">*</span></label>
                                                <textarea name="address" v-model="inputData.address" id="address" class="form-control" placeholder="Merchant Address"></textarea>
                                            </div>
                                     
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="district_id"> Districts <span style="font-weight: bold; color: red;">*</span></label>
                                                    <!--:close-on-select="true"
                                                    <v-select v-model="inputData.district_id" :options="districts" :reduce="district=>district.district_id" placeholder="Please select district" label="district_name" @input="getThanas_act"></v-select>-->
                                                    <multiselect v-model="inputData.district_ids" :options="districts" :searchable="true" :close-on-select="true" :show-labels="false" return="district_id" placeholder="Please select district" label="district_name" track-by="district_id" @select="getThanas($event)"></multiselect>

                                                    <input type="hidden" name="district_id" v-model="inputData.district_id">

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="upazila_id"> Thana/Upazila <span style="font-weight: bold; color: red;">*</span> </label>
                                                <!--    <v-select v-model="inputData.thana_id" :options="thanas" :reduce="thana=>thana.thana_id" placeholder="Please select thana" label="thana_name" @select="getAreas($event)"></v-select>-->
                                                    <multiselect v-model="inputData.thana_ids" :options="thanas" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select thana" label="thana_name" return="thana_id" track-by="thana_id" @select="getAreas($event)"></multiselect>

                                                    <input type="hidden" name="thana_id" v-model="inputData.thana_id">

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="area_id"> Area <span style="font-weight: bold; color: red;">*</span> </label>
                                                  <!-- <v-select v-model="inputData.area_id" :options="areas"  :reduce="area=>area.area_id"  placeholder="Please select thana" label="area_name" @select="setArea($event)"></v-select>-->
                                                   <multiselect v-model="inputData.area_ids" :options="areas" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select thana" label="area_name" return="area_id" track-by="area_id" @select="setArea($event)"></multiselect>

                                                    <input type="hidden" name="area_id" v-model="inputData.area_id">

                                                </div>
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

                                            <div class="col-md-6">
                                                <label for="facebook">Facebook</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text">http://</div>
                                                    </div>
                                                    <input type="text" class="form-control" v-model="inputData.facebook" id="facebook" name="facebook" value="" placeholder="Merchant Facebook Url">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="website">Website</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text">http://</div>
                                                    </div>
                                                    <input type="text" class="form-control" v-model="inputData.website" id="website" name="website" placeholder="Merchant Website Url">
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

            this.generalApi = 'hubs'
            this.backUrl = '/hubs'
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
                       
                            this.inputData.district_ids = res.data.data.districtInfo
                            this.getThanaListByDistrctId(res.data.data.district_id)
                            this.inputData.thana_ids = res.data.data.thanaInfo
                            this.getAreaListByThanaId(res.data.data.thana_id)
                            this.inputData.area_ids = res.data.data.areaInfo

                    })
            }
            /*if edit*/
            this.cardTitle = this.isEdit ? 'Edit Hub' : 'Add Hub'
            
            this.getDistricts();

        },
  mounted() {
  }
};
</script>
