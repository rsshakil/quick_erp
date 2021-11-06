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
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="weight_name">Weight Name</label>
                        <input type="text" id="weight_name" class="form-control" v-model="form.weight_name" placeholder="Enter weight name">
                      </div>
                    </div>
                    <b-button pill variant="primary" @click.prevent="SaveWeight()" type="submit">
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
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>SL#</th>
                      <th>Weight List</th>
                      <th colspan="2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="weight,i in weight_lists" :key="i">
                      <td>{{ i+1 }}</td>
                      <td>{{ weight.weight_name }}</td>
                      <td style="width:20%;">
                      <b-button variant="info" @click.prevent="editWeight(weight)">
                        <b-icon icon="pencil-square" font-scale="1.2"></b-icon>
                      </b-button>
                      </td>
                      <td v-if="weight.deleted_at==null">
                        <b-button pill variant="danger" @click="deleteOrRetrive(weight,'d')"><b-icon icon="trash" font-scale="1.2"></b-icon> Delete</b-button>
                    </td>
                    <td v-else>
                        <b-button pill variant="info" @click="deleteOrRetrive(weight,'r')"><b-icon icon="arrow-counterclockwise" font-scale="1.2"></b-icon> Restore</b-button>
                        </td>
                    </tr>
                    <tr v-if="weight_lists && weight_lists.length==0">
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
        weight_lists:[],
        form:{
            weight_list_id:null,
            weight_name:null,
        }
    };
  },
  methods: {
      getAllWeights(){
        //   this.loaderrrsss = Vue.$loading.show();
          axios.get("weigths", this.form)
          .then(({ data }) => {
            this.weight_lists = data.weight_lists;
            this.loaderrrsss.hide();
        });
      },
      SaveWeight(){
          if (!this.form.weight_name) {
            this.alert_icon='warning';
            this.alert_title='No weight name mantioned!';
            this.alert_text= "Please write weight name";
            this.sweet_normal_alert()
            return;
          }
          this.loaderrrsss = Vue.$loading.show();
          var weight_url=null;
          if (this.form.weight_list_id==null) {
             weight_url=axios.post("weigths",this.form);
          }else{
              weight_url=axios.put("weigths/"+this.form.weight_list_id,this.form);
          }
        weight_url.then(({ data }) => {
            this.alert_icon=data.class_name;
            this.alert_title=data.title;
            this.alert_text= data.message;
            this.sweet_normal_alert()
            if (data.status==1) {
                this.getAllWeights()
            }
            this.loaderrrsss.hide();
        })
      },
      editWeight(weight){
          this.form=weight
      },
      deleteOrRetrive(weight,type='d'){
          console.log(weight)
        this.alert_icon='warning';
        this.alert_title=(type==='d'?'Are you sure?':'Are you sure to retrive it?');
        this.alert_text=(type==='d'?'Deleted data will be able to retrived':'');
        this.yes_btn=(type==='d'?'Yes delete it!':'Yes retrive it!')
        var _this=this;
        this.confirm_sweet().then((result) => {
            if (result.value) {
                var delete_param={weight_list_id:weight.weight_list_id, deleted_at:weight.deleted_at}
                axios.delete('weigths/'+JSON.stringify(delete_param)).then(({ data }) => {
                    if (data.status==1) {
                        _this.alert_icon=data.class_name;
                        _this.alert_title=data.title;
                        _this.alert_text= data.message;
                        _this.sweet_normal_alert()
                        _this.getAllWeights()
                    }
                })
            }
        })
    },
  },

  created() {
      this.loaderrrsss = Vue.$loading.show();
      this.getAllWeights()
  },
  mounted() {
  }
};
</script>
