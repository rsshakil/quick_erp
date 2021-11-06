<template>
<div class="main-content-container container-fluid px-4">
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <h3 class="page-title">Delivery option manage</h3>
        </div>
    </div>
<div class="row">
    <div class="col-md-4">
        <div class="card card-small mb-4">
          <div class="card-header border-bottom">
            <h6 class="m-0">Add Option</h6>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item p-3">
              <div class="row">
                <div class="col">
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="option_name">Option Name</label>
                        <input type="text" id="option_name" class="form-control" v-model="form.option_name" placeholder="Enter delivery option name">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label for="option_rate">Percent</label>
                        <input type="text" id="option_rate" class="form-control" v-model="form.option_rate" placeholder="Enter option rate">
                      </div>
                    </div>
                    <b-button pill variant="primary" @click.prevent="SaveDeleveryOption()" type="submit">
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
                      <th>Option Name</th>
                      <th>Option Rate</th>
                      <th colspan="2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="option,i in options" :key="i">
                      <td>{{ i+1 }}</td>
                      <td>{{ option.option_name }}</td>
                      <td>{{ option.option_rate }}</td>
                      <td style="width:20%;">
                      <b-button variant="info" @click.prevent="editWeight(option)">
                        <b-icon icon="pencil-square" font-scale="1.2"></b-icon>
                      </b-button>
                      </td>
                      <td v-if="option.deleted_at==null">
                        <b-button pill variant="danger" @click="deleteOrRetrive(option,'d')"><b-icon icon="trash" font-scale="1.2"></b-icon> Delete</b-button>
                    </td>
                    <td v-else>
                        <b-button pill variant="info" @click="deleteOrRetrive(option,'r')"><b-icon icon="arrow-counterclockwise" font-scale="1.2"></b-icon> Restore</b-button>
                        </td>
                    </tr>
                    <tr v-if="options && options.length==0">
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
        options:[],
        form:{
            option_id:null,
            option_name:null,
            option_rate:0,
        }
    };
  },
  methods: {
      getAllOptions(){
        //   this.loaderrrsss = Vue.$loading.show();
          axios.get("delivery_options", this.form)
          .then(({ data }) => {
            this.options = data.options;
            this.loaderrrsss.hide();
        });
      },
      SaveDeleveryOption(){
          if (!this.form.option_name) {
            this.alert_icon='warning';
            this.alert_title='No option!!';
            this.alert_text= "Please write option name";
            this.sweet_normal_alert()
            return;
          }
          if (!this.form.option_rate) {
            this.alert_icon='warning';
            this.alert_title='No rate!';
            this.alert_text= "Please write option rate";
            this.sweet_normal_alert()
            return;
          }
          this.loaderrrsss = Vue.$loading.show();
          var option_url=null;
          if (this.form.option_id==null) {
             option_url=axios.post("delivery_options",this.form);
          }else{
              option_url=axios.put("delivery_options/"+this.form.option_id,this.form);
          }
        option_url.then(({ data }) => {
            this.alert_icon=data.class_name;
            this.alert_title=data.title;
            this.alert_text= data.message;
            this.sweet_normal_alert()
            if (data.status==1) {
                this.getAllOptions()
            }
            this.loaderrrsss.hide();
        })
      },
      editWeight(option){
          this.form=option
      },
      deleteOrRetrive(option,type='d'){
        //   console.log(weight)
        this.alert_icon='warning';
        this.alert_title=(type==='d'?'Are you sure?':'Are you sure to retrive it?');
        this.alert_text=(type==='d'?'Deleted data will be able to retrived':'');
        this.yes_btn=(type==='d'?'Yes delete it!':'Yes retrive it!')
        var _this=this;
        this.confirm_sweet().then((result) => {
            if (result.value) {
                var delete_param={option_id:option.option_id, deleted_at:option.deleted_at}
                axios.delete('delivery_options/'+JSON.stringify(delete_param)).then(({ data }) => {
                    if (data.status==1) {
                        _this.alert_icon=data.class_name;
                        _this.alert_title=data.title;
                        _this.alert_text= data.message;
                        _this.sweet_normal_alert()
                        _this.getAllOptions()
                    }
                })
            }
        })
    },
  },

  created() {
      this.loaderrrsss = Vue.$loading.show();
      this.getAllOptions()
  },
  mounted() {
  }
};
</script>
