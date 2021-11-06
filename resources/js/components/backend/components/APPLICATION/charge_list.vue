<template>
<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <h3 class="page-title">Charge lists manage</h3>
        </div>
    </div>
<div class="row">
    <div class="col-md-4">
        <div class="card card-small mb-4">
          <div class="card-header border-bottom">
            <h6 class="m-0">{{myLang.manage_role}}</h6>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item p-3">
              <div class="row">
                <div class="col">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="district_id"> Districts <span style="font-weight: bold; color: red;">*</span></label>
                            <!-- @select="setDistrictName($event)" -->
                            <multiselect v-model="form.district" :options="districts" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select district" label="district_name" track-by="district_id" ></multiselect>
                        </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="role_description">Rate</label>
                        <input type="text" class="form-control" v-model="form.charge_rate" placeholder="Enter Rate">
                      </div>
                    </div>
                    <b-button pill variant="primary" @click.prevent="SaveCharge()" type="submit">
                      <b-icon icon="inbox-fill" font-scale="1.2"></b-icon> Save </b-button>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
          <div class="col-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Charge list</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <!-- <div class="input-group-append">
                      <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i> Add Charge
                      </button>
                    </div> -->
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>SL#</th>
                      <th>Charge/District Name</th>
                      <th>Charge Rate</th>
                      <th colspan="2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="charge,i in charges" :key="i">
                      <td>{{ i+1 }}</td>
                      <td>{{ charge.district.district_name }}</td>
                      <td>{{ charge.charge_rate }}</td>
                      <td style="width:20%;">
                      <b-button variant="info" @click.prevent="editCharge(charge)">
                        <b-icon icon="pencil-square" font-scale="1.2"></b-icon>
                      </b-button>
                      </td>
                      <td v-if="charge.deleted_at==null">
                        <b-button pill variant="danger" @click="deleteOrRetrive(charge,'d')"><b-icon icon="trash" font-scale="1.2"></b-icon> Delete</b-button>
                    </td>
                    <td v-else>
                        <b-button pill variant="info" @click="deleteOrRetrive(charge,'r')"><b-icon icon="arrow-counterclockwise" font-scale="1.2"></b-icon> Restore</b-button>
                        </td>
                    </tr>
                    <tr v-if="charges && charges.length==0">
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
        charges:[],
        districts:[],
        form:{
            charge_list_id:null,
            district:null,
            charge_rate:null,
        }
    };
  },
  methods: {
      getAllCharges(){
        //   this.loaderrrsss = Vue.$loading.show();
          axios.get("charges", this.form)
          .then(({ data }) => {
            this.charges = data.charges;
            this.loaderrrsss.hide();
        });
      },
      setDistrictName($event){
          this.form.district_id=$event.district_id
      },
      SaveCharge(){
          if (!this.form.district) {
            this.alert_icon='warning';
            this.alert_title='No district!';
            this.alert_text= "Please select district";
            this.sweet_normal_alert()
            return;
          }
          this.loaderrrsss = Vue.$loading.show();
          var charge_url=null;
          if (this.form.charge_list_id==null) {
             charge_url=axios.post("charges",this.form);
          }else{
              charge_url=axios.put("charges/"+this.form.charge_list_id,this.form);
          }
        charge_url.then(({ data }) => {
            this.alert_icon=data.class_name;
            this.alert_title=data.title;
            this.alert_text= data.message;
            this.sweet_normal_alert()
            if (data.status==1) {
                this.getAllCharges()
            }
            this.loaderrrsss.hide();
        })
      },
      editCharge(charge){
          this.form=charge
      },
      deleteOrRetrive(charge,type='d'){
        this.alert_icon='warning';
        this.alert_title=(type==='d'?'Are you sure?':'Are you sure to retrive it?');
        this.alert_text=(type==='d'?'Deleted data will be able to retrived':'');
        this.yes_btn=(type==='d'?'Yes delete it!':'Yes retrive it!')
        var _this=this;
        this.confirm_sweet().then((result) => {
            if (result.value) {
                var delete_param={charge_list_id:charge.charge_list_id, deleted_at:charge.deleted_at}
                axios.delete('charges/'+JSON.stringify(delete_param)).then(({ data }) => {
                    // console.log(data);
                    // return
                    if (data.status==1) {
                        _this.alert_icon=data.class_name;
                        _this.alert_title=data.title;
                        _this.alert_text= data.message;
                        _this.sweet_normal_alert()
                        _this.getAllCharges()
                    }
                })
            }
        })
    },
  },

  created() {
      this.loaderrrsss = Vue.$loading.show();
      this.getAllCharges()
      this.getDistricts();
  },
  mounted() {
  }
};
</script>
