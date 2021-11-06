<template>
<div class="main-content-container container-fluid px-0">
    <form class="form" @submit.prevent="processData()">
   
    <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    
                    <div class="card-body">
                        <div class="offset-md-1 col-md-10 ">
                            <div class="card card-primary">
                                  <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-6" v-if="isEdit==false">
                                                <label for="merchant_name">Name <span style="font-weight: bold; color: red;">*</span></label>
                                                <input type="text" v-model="inputData.merchant_name" name="merchant_name" id="merchant_name" class="form-control" placeholder="Merchant Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="company_name">Company Name <span style="font-weight: bold; color: red;">*</span></label>
                                                <input type="text" name="company_name" v-model="inputData.company_name" id="company_name" class="form-control" placeholder="Company Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="full_address">Full Address <span style="font-weight: bold; color: red;">*</span></label>
                                                <textarea name="full_address" v-model="inputData.full_address" id="full_address" class="form-control" placeholder="Merchant Address"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="business_address">Business Address</label>
                                                <textarea name="business_address" v-model="inputData.business_address" id="business_address" class="form-control" placeholder="Business Address"></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="district_id"> Districts <span style="font-weight: bold; color: red;">*</span></label>
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
                                                    <input type="text" name="phone" v-model="inputData.phone" id="phone" value="" class="form-control" placeholder="Merchant Contact Number" >
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
                                            <div class="col-md-6">
                                                <label for="website">Website</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text">http://</div>
                                                    </div>
                                                    <input type="text" class="form-control" v-model="inputData.website" id="website" name="website" placeholder="Merchant Website Url">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                    <label for="image">Image </label>
                                                    <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="image" id="image" @change="previewImage">
                                                        <label class="custom-file-label" for="image">Choose file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Upload</span>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <img :src="imageData" width="100px">
                                                    
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-6"  v-if="isEdit==false">
                                                <label for="email">Email <span style="font-weight: bold; color: red;">*</span> </label>
                                                <input type="email" name="email" v-model="inputData.email" id="email" class="form-control" placeholder="Email" >
                                            </div>

                                            <div class="col-md-6"  v-if="isEdit==false">
                                                <label for="password">Password</label>
                                                <input type="password" name="password" v-model="inputData.password" id="password"  class="form-control" placeholder="Password">
                                            </div>
                                            <div class="col-md-12 row" style="margin-top: 20px;">
                                                <div class="col-md-12" style="border-bottom: 2px #000 dotted ">
                                                    <label for="charge"> Bank Informations</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="bank_name">Bank Name</label>
                                                    <input type="text" v-model="inputData.bank_name" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="account_holder_name">Account Holder Name</label>
                                                    <input type="text" v-model="inputData.account_holder_name" name="account_holder_name" id="account_holder_name" class="form-control" placeholder="Bank Account Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="account_number">Bank Account Number</label>
                                                    <input type="text" v-model="inputData.account_number" id="account_number" name="account_number" class="form-control" placeholder="Bank Account Number">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="bkash_number">BKash Number</label>
                                                    <input type="text" v-model="inputData.bkash_number" id="bkash_number" name="bkash_number" class="form-control" placeholder="BKash Number">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="nagad_number">Nagad Number</label>
                                                    <input type="text" v-model="inputData.nagad_number" id="nagad_number" name="nagad_number" class="form-control" placeholder="Nagad Number">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="rocket_number">Rocket Number</label>
                                                    <input type="text" v-model="inputData.rocket_number" name="rocket_number" id="rocket_number" class="form-control" placeholder="Rocket Number">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="nid_card"> NID Card  </label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="nid" id="nid_card">
                                                            <label class="custom-file-label" for="nid_card">Choose file</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="trade_license">Trade License  </label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="trade_license" id="trade_license">
                                                            <label class="custom-file-label" for="trade_license">Choose file</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="tin_certificate">TIN Certificate </label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="tin" id="tin_certificate">
                                                            <label class="custom-file-label" for="tin_certificate">Choose file</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <!--<button type="submit" class="btn btn-success" @click="addMerchant()">Submit</button>
                                            <button type="reset" class="btn btn-primary" @click="resetMerchantForm()">Reset</button>-->

                                        </div>
                                                      <div class="card-footer">
                           <button type="submit" class="btn btn-sm btn-primary float-right m-1" v-text="isEdit?'Update':'Save Changes'"></button>
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
            imageData:'',
            form:{}

    
    };
  },
  methods: {
      
       previewImage: function(event) {
            var input = event.target;

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = (e) => {
                    this.imageData = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        },
         toastMessage(type, message, icon, position, actionIcon) {
            var toast = null;
            if (type == 'success') {
                toast = this.$toasted.success
            } else if (type == 'info') {
                toast = this.$toasted.info
            } else if (type == 'error') {
                toast = this.$toasted.error
            } else if (type == 'warning') {
                toast = this.$toasted.error
            }
            toast(message, {
                // theme:'bubble',
                icon: icon ? icon : 'check',
                position: position ? position : 'top-right',
                iconPack: 'fontawesome',
                icon: icon ? icon : 'check',
                duration: 3000,
                action: {
                    icon: actionIcon ? actionIcon : 'times',
                    class: 'text-white',
                    onClick: (e, toastObject) => {
                        toastObject.goAway(0);
                    }
                },
            });
        },
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
                    this.$router.push({name:'admin_login'})
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

            this.generalApi = 'merchant'
            this.backUrl = '/'
            this.isFile = true
            this.isImage = 'image_path',
            this.cardTitle = this.isEdit ? 'Edit Marchant' : 'Add Marchant'
            this.getDistricts();

        },
  mounted() {

  }
};
</script>
