<template>
<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <h3 class="page-title">Charge package manage</h3>
        </div>
    </div>
<div class="row">
    <div class="col-md-4">
        <div class="card card-small mb-4">
          <div class="card-header border-bottom">
            <h6 class="m-0">Add Package</h6>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item p-3">
              <div class="row">
                <div class="col">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="district_id"> Charge List <span style="font-weight: bold; color: red;">*</span></label>
                            <multiselect v-model="form.district" :options="chargeLists" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select district" label="district_name" track-by="district_id" @select="changeRate($event)" ></multiselect>
                        </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="role_description">Charge rate</label>
                        <input type="text" class="form-control" v-model="form.charge_rate" placeholder="Enter Rate" :disabled="true">
                      </div>
                    </div>
                    <table class="table table-hover text-nowrap">
              <thead>
                  <th>Sl#</th>
                  <th>All <input @click="checkAll" v-model="isCheckAll" type="checkbox" />
                  <th>Weight Name</th>
                  <th>Charge</th>
              </thead>
              <tbody>
                  <tr v-for="weightList,i in weightLists" :key="i">
                      <td>{{ i+1 }}</td>
                      <td>
                          <input type="checkbox" v-bind:value="weightList.weight_list_id" v-model="selected" @change="updateCheck(weightList)" />
                      </td>
                      <td>{{ weightList.weight_name }}</td>
                      <td><input type="text" class="form-control" v-model="weightList.charge"></td>
                  </tr>
              </tbody>
          </table>
                    <b-button pill variant="primary" @click.prevent="SaveChargePackage()" type="submit">
                      <b-icon icon="inbox-fill" font-scale="1.2"></b-icon> {{ form.save_flag }} </b-button>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
          <div class="col-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Package list</h3>
                <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 100px;">
                    <!-- <input type="text" name="table_search" class="form-control float-right" placeholder="Search"> -->

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default" @click="resetDataList()">
                        Restore
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>SL#</th>
                      <th>Package Name</th>
                      <th>Charge Rate</th>
                      <th>Weight and Charge</th>
                      <th colspan="2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="pack,i in packages" :key="i">
                      <td>{{ i+1 }}</td>
                      <td>{{ pack.district_name }}</td>
                      <td>{{ pack.charge_rate }}</td>
                      <td>
                          <ul>
                              <li v-for="pc,j in (pack.weights)" :key="j">{{ pc.weight_name }} | {{ pc.charge }}</li>
                          </ul>
                      </td>
                      <td style="width:20%;">
                      <b-button variant="info" @click.prevent="editChargePack(pack)">
                        <b-icon icon="pencil-square" font-scale="1.2"></b-icon>
                      </b-button>
                      </td>
                      <td v-if="pack.deleted_at==null">
                        <b-button pill variant="danger" @click="deleteOrRetrive(pack,'d')"><b-icon icon="trash" font-scale="1.2"></b-icon> Delete</b-button>
                    </td>
                    <td v-else>
                        <b-button pill variant="info" @click="deleteOrRetrive(pack,'r')"><b-icon icon="arrow-counterclockwise" font-scale="1.2"></b-icon> Restore</b-button>
                        </td>
                    </tr>
                    <tr v-if="packages && packages.length==0">
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
        packages:[],
        chargeLists:[],
        weightLists:[],
        isCheckAll: false,
        selected:[],
        form:{
            district:[],
            charge_list_id:null,
            charge_rate:null,
            district_name:null,
            weights:[],
            save_flag:'Save',
        }
    };
  },
  methods: {
      getAllChargePackages(){
        //   this.loaderrrsss = Vue.$loading.show();
          axios.get("charge_package", this.form)
          .then(({ data }) => {
            //   console.log(data)
            this.packages = data.packages;
            this.chargeLists = data.charge_list;
            this.weightLists = data.weight_lists;
            this.loaderrrsss.hide();
        });
      },
      changeRate($event){
        //   console.log($event)
          this.form.charge_list_id=$event.charge_list_id
          this.form.charge_rate=$event.charge_rate
          this.form.district_name=$event.district_name
          this.form.district_id=$event.district_id
      },
      updateCheck(weightList){
        //   console.log(this.selected)
            this.form.weights=[]
          this.weightLists.forEach(element => {
              if (this.selected.includes(element.weight_list_id)) {
                  this.form.weights.push(element)
              }
          });
          if (this.selected.length==this.weightLists.length) {
            this.isCheckAll=true
        }else{
            this.isCheckAll=false
        }
        //   console.log(this.form.weights)
      },
      checkAll() {
      this.isCheckAll = !this.isCheckAll;
      if (this.selected.length>0) {
          this.selected=[]
      }

      if (this.isCheckAll) {
          this.form.weights=this.weightLists
          this.weightLists.forEach(element => {
          this.selected.push(element.weight_list_id)
          });
      }else{
          this.form.weights=[]
          this.selected=[]
      }
      console.log(this.form.weights)
    },
      SaveChargePackage(){
        //   console.log(this.form.charge_list_id)
        //   console.log(this.form)
        //   return
          if (!this.form.charge_list_id) {
            this.alert_icon='warning';
            this.alert_title='No charge!';
            this.alert_text= "Please select charge";
            this.sweet_normal_alert()
            return;
          }
          if (!this.form.weights.length) {
            this.alert_icon='warning';
            this.alert_title='No weight!';
            this.alert_text= "Please select at least one weight";
            this.sweet_normal_alert()
            return;
          }
          this.loaderrrsss = Vue.$loading.show();
            axios.post("charge_package",this.form).then(({ data }) => {
            this.alert_icon=data.class_name;
            this.alert_title=data.title;
            this.alert_text= data.message;
            this.sweet_normal_alert()
            if (data.status==1) {
                this.resetDataList();
            }
            this.loaderrrsss.hide();
        })
      },
      editChargePack(pack){
          this.loaderrrsss = Vue.$loading.show();
        this.form=pack
        this.selected=[]
        this.form.district={district_name:pack.district_name,district_id:pack.district_id}
        var all_weight=pack.weights;
        all_weight.forEach(element => {
            this.selected.push(element.weight_list_id)
        });
        if (this.selected.length==this.weightLists.length) {
            this.isCheckAll=true
        }else{
            this.isCheckAll=false
        }
        for (let i = 0; i < this.weightLists.length; i++) {
            if (this.selected.includes(this.weightLists[i].weight_list_id)) {
                all_weight.forEach(element => {
                    if (element.weight_list_id==this.weightLists[i].weight_list_id) {
                        this.weightLists[i].charge=element.charge;
                    }
                });
            }

        }
        this.form.save_flag="Update"
        this.loaderrrsss.hide();

      },
      deleteOrRetrive(pack,type='d'){
        //   return
        this.alert_icon='warning';
        this.alert_title=(type==='d'?'Are you sure?':'Are you sure to retrive it?');
        this.alert_text=(type==='d'?'Deleted data will be able to retrived':'');
        this.yes_btn=(type==='d'?'Yes delete it!':'Yes retrive it!')
        var _this=this;
        this.confirm_sweet().then((result) => {
            if (result.value) {
                this.loaderrrsss = Vue.$loading.show();
                var delete_param={charge_list_id:pack.charge_list_id, deleted_at:pack.deleted_at}
                axios.delete('charge_package/'+JSON.stringify(delete_param)).then(({ data }) => {
                    if (data.status==1) {
                        _this.alert_icon=data.class_name;
                        _this.alert_title=data.title;
                        _this.alert_text= data.message;
                        _this.sweet_normal_alert()
                        _this.getAllChargePackages()
                    }
                })
            }
        })
    },
    resetDataList(){
        this.loaderrrsss = Vue.$loading.show();
        Object.assign(this.$data, this.$options.data.apply(this))
        this.getAllChargePackages()
    }
  },

  created() {
      this.loaderrrsss = Vue.$loading.show();
      this.getAllChargePackages()
      this.getDistricts();
  },
  mounted() {
  }
};
</script>
