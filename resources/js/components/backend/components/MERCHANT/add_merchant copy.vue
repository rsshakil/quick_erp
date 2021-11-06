<template>
<div class="main-content-container container-fluid px-0">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <h3 class="page-title">All Merchant List</h3>
        </div>
    </div>
    <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Create New Merchant </h3>
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
                                                <label for="merchant_name">Name <span style="font-weight: bold; color: red;">*</span></label>
                                                <input type="text" v-model="form.name" name="merchant_name" id="merchant_name" value="" class="form-control" placeholder="Merchant Name" required="">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="company_name">Company Name <span style="font-weight: bold; color: red;">*</span></label>
                                                <input type="text" name="company_name" v-model="form.company_name" id="company_name" value="" class="form-control" placeholder="Company Name" required="">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="address">Full Address <span style="font-weight: bold; color: red;">*</span></label>
                                                <textarea name="address" v-model="form.full_address" id="address" class="form-control" placeholder="Merchant Address" required=""></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="business_address">Business Address</label>
                                                <textarea name="business_address" v-model="form.business_address" id="business_address" class="form-control" placeholder="Business Address"></textarea>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="district_id"> Districts <span style="font-weight: bold; color: red;">*</span></label>
                                                    <multiselect v-model="form.district" :options="districts" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select district" label="district_name" track-by="district_id" @select="getThanas($event)"></multiselect>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="upazila_id"> Thana/Upazila <span style="font-weight: bold; color: red;">*</span> </label>
                                                    <multiselect v-model="form.thana" :options="thanas" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select thana" label="thana_name" track-by="thana_id" @select="getAreas($event)"></multiselect>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="area_id"> Area <span style="font-weight: bold; color: red;">*</span> </label>
                                                   <multiselect v-model="form.area" :options="areas" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select thana" label="area_name" track-by="area_id" @select="setArea($event)"></multiselect>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="contact_number"> Contact Number <span style="font-weight: bold; color: red;">*</span> </label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                    <div class="input-group-text">+88</div>
                                                    </div>
                                                    <input type="text" name="contact_number" v-model="form.phone" id="contact_number" value="" class="form-control" placeholder="Merchant Contact Number" required="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="fb_url">Facebook</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text">http://</div>
                                                    </div>
                                                    <input type="text" class="form-control" v-model="form.facebook" id="fb_url" name="fb_url" value="" placeholder="Merchant Facebook Url">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="web_url">Website</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                      <div class="input-group-text">http://</div>
                                                    </div>
                                                    <input type="text" class="form-control" v-model="form.website" id="web_url" name="web_url" value="" placeholder="Merchant Website Url">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="image">Image </label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image">
                                                        <label class="custom-file-label" for="image">Choose file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Upload</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="email">Email <span style="font-weight: bold; color: red;">*</span> </label>
                                                <input type="email" name="email" v-model="form.email" id="email" value="" class="form-control" placeholder="Email" required="">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="password">Password</label>
                                                <input type="password" name="password" v-model="form.password" id="password" value="" class="form-control" placeholder="Password">
                                            </div>
                                            <div class="col-md-12 row" style="margin-top: 20px;">
                                                <div class="col-md-12" style="border-bottom: 2px #000 dotted ">
                                                    <label for="charge"> Bank Informations</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="bank_name">Bank Name</label>
                                                    <input type="text" v-model="form.bank_name" id="bank_name" class="form-control" placeholder="Bank Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="bank_account_name">Account Holder Name</label>
                                                    <input type="text" v-model="form.account_holder_name" id="bank_account_name" class="form-control" placeholder="Bank Account Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="bank_account_no">Bank Account Number</label>
                                                    <input type="text" v-model="form.account_number" id="bank_account_no" class="form-control" placeholder="Bank Account Number">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="bkash_number">BKash Number</label>
                                                    <input type="text" v-model="form.bkash_number" id="bkash_number" class="form-control" placeholder="BKash Number">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="nagad_number">Nagad Number</label>
                                                    <input type="text" v-model="form.nagad_number" id="nagad_number" class="form-control" placeholder="Nagad Number">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="rocket_number">Rocket Number</label>
                                                    <input type="text" v-model="form.rocket_number" id="rocket_number" class="form-control" placeholder="Rocket Number">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="nid_card"> NID Card  </label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="nid_card">
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
                                                            <input type="file" class="custom-file-input" id="trade_license">
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
                                                            <input type="file" class="custom-file-input" id="tin_certificate">
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
                                            <button type="submit" class="btn btn-success" @click="addMerchant()">Submit</button>
                                            <button type="reset" class="btn btn-primary" @click="resetMerchantForm()">Reset</button>
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
</div>
</template>
<script>
export default {
  data() {
    return {
    form:{
        merchant_id:null,
        name:null, //merchant_name
        company_name:null,
        phone:null,
        email:null,
        password:null,
        image:null,
        full_address:null,
        business_address:null,
        district:null,
        thana:null,
        area:null,
        facebook:null,
        website:null,
        bank_name:null,
        account_holder_name:null,
        account_number:null,
        bkash_number:null,
        nagad_number:null,
        rocket_number:null,
        nid:null,
        trade_license:null,
        tin:null,
    }
    };
  },
  methods: {
    addMerchant(){
        // console.log(this.form)
        // return 0;
        this.loaderrrsss = Vue.$loading.show();
        var merchent_url="add_merchant";
        if (this.form.merchant_id!=null) {
            merchent_url="update_merchant";
        }
        axios.post(merchent_url, this.form)
          .then(({ data }) => {
            this.alert_icon=data.class_name;
            this.alert_title=data.title;
            this.alert_text= data.message;
            this.sweet_normal_alert()
            this.loaderrrsss.hide();
        });
    },
    resetMerchantForm(){
        Object.assign(this.$data, this.$options.data.apply(this))
        this.getDistricts();
        this.$router.push({name:'add_merchant'}).catch(()=>{});
    },
    setArea($event){
        this.form.area=$event
    },
    getSingleMerchant(merchant_id){
        axios.post("get_single_merchant", {merchant_id:merchant_id})
          .then(({ data }) => {
            //   console.log(data)
              this.form=data.merchant
              this.thanas=this.form.thanas
              this.areas=this.form.areas
            // this.alert_icon=data.class_name;
            // this.alert_title=data.title;
            // this.alert_text= data.message;
            // this.sweet_normal_alert()
            // this.loaderrrsss.hide();
        });
    }
  },

  created() {
      this.getDistricts();
    //   console.log(this.$route.query)
  },
  mounted() {
      this.form.merchant_id=this.$route.query.merchant_id
    if (this.form.merchant_id) {
        this.getSingleMerchant(this.form.merchant_id)
    }
  }
};
</script>
