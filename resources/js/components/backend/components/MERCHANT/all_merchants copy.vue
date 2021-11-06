<template>
<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <!-- <span class="text-uppercase page-subtitle">Overview</span> -->
            <h3 class="page-title">Merchant List</h3>
        </div>
    </div>
<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">You can filter merchants</h3>

                <!-- <div class="card-tools"> -->
                    <table class="table table-bordered" style="width: 100%">
                        <tr>
                           <td class="">Status</td>
                            <td>
                                <select v-model="form.status" class="form-control select2" style="width: 100%;" @change="getAllMerchant()">
                                    <option value="*">All</option>
                                    <option :value="opt" v-for="opt,i in status" :key="i" :selected="form.status==opt">{{ opt }}</option>
                                </select>
                            </td>
                           <td class="">District</td>
                            <td>
                                <select v-model="form.district_id" class="form-control select2" style="width: 100%;" @change="getAllMerchant()">
                                    <option value="*">All</option>
                                    <option :value="opt.district_id" v-for="opt,i in districts" :key="i" :selected="form.district==opt.district_id">{{ opt.district_name }}</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                  <!-- <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div> -->
                <!-- </div> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Sl</th>
                      <th>Merchant Name</th>
                      <th>Company Name</th>
                      <th>Email</th>
                      <th>Area</th>
                      <th>Status</th>
                      <th colspan="2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(merchant,i) in merchants" :key="i">
                      <td>{{ i+1 }}</td>
                      <td>{{ merchant.merchant_name }}</td>
                      <td>{{ merchant.company_name }}</td>
                      <td>{{ merchant.email }}</td>
                      <td>{{ merchant.area_name }}</td>
                      <td>
                        <select name="" id="" class="form-control select2" style="width: 100%;" @change="changeStatus($event,merchant)">
                            <option :value="opt" v-for="opt,i in status" :key="i" :selected="merchant.status==opt">{{ opt }}</option>
                        </select>
                          <!-- <multiselect v-model="merchant.status" :options="status" :searchable="false" :close-on-select="true" :show-labels="false" placeholder="Pick a value" @select="changeStatus($event,merchant)"></multiselect> -->
                      </td>
                    <td v-if="merchant.deleted_at==null">
                        <b-button pill variant="danger" @click="deleteOrRetrive(merchant,'d')">Deleted</b-button>
                    </td>
                    <td v-else><b-button pill variant="info" @click="deleteOrRetrive(merchant,'r')">Retrive</b-button></td>
                    <td><b-button pill variant="info" @click="editMerchant(merchant)">Edit</b-button></td>
                    </tr>
                    <tr v-if="merchants && merchants.length==0">
                        <td class="text-center" colspan="100%">No dat found</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        </div>
</template>
<script>
export default {
  data() {
    return {
        merchants: {},
        form:{
            status:'*',
            district_id:'*'
        }
    };
  },
  methods: {
      getAllMerchant(){
          this.loaderrrsss = Vue.$loading.show();
          axios.post("get_all_merchant", this.form)
          .then(({ data }) => {
            this.merchants = data.merchants;
            this.loaderrrsss.hide();
        });
      },
      changeStatus($event,merchant){
        merchant.changed_status=$event.target.value
        this.alert_icon='warning';
        this.alert_title='Are you sure?';
        this.alert_text="Your data will be "+$event.target.value;
        this.yes_btn='Yes do it!'
        this.confirm_sweet().then((result) => {
            if (result.value) {
                axios.post("change_merchant_status", merchant)
                .then(({ data }) => {
                    if (data.status==1) {
                        this.alert_icon='success';
                        this.alert_title=data.message;
                        this.alert_text= data.message;
                        this.sweet_normal_alert()
                        this.getAllMerchant()
                    }

                    // this.loaderrrsss.hide();
                });

            }else{
                // this.getAllMerchant()
            }


        })
      },
      deleteOrRetrive(value,type){
        // console.log(value)
        this.alert_icon='warning';
        this.alert_title='Are you sure?';
        this.alert_text=(type==='d'?'You will be able to retrive it':'Deleted data will be retrived');
        this.yes_btn=(type==='d'?'Yes delete it!':'Yes retrived it!')
        this.confirm_sweet().then((result) => {
            if (result.value) {
                axios.post("merchant_delete_or_retrive", value).then(({ data }) => {
                    // console.log(data)
                    if (data.status==1) {
                        this.alert_icon='success';
                        this.alert_title=data.message;
                        this.alert_text= 'Total '+data.data_count+' data '+ (type==='d'?'deleted':'retrived');
                        this.sweet_normal_alert()
                        this.getAllMerchant()
                    }
                })
            }
        })
    },
    editMerchant(merchant){
    //    console.log(merchant);
       this.$router.push({name:'add_merchant',query:{merchant_id:merchant.merchant_id}})
    }
  },

  created() {
      this.getDistricts();
      this.getAllMerchant();
        // this.loaderrrsss = Vue.$loading.show();
  },
  mounted() {
  }
};
</script>
