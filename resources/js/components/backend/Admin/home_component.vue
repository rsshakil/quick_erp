<template>
<!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ total_parcels }}</h3>

                <p>Total Parcel</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" @click.prevent="goToParcelPage(status='All')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ total_pending_parcels }}</h3>
                <p>New/Pending Parcel(s)</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" @click.prevent="goToParcelPage(status='pending')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ total_delivered_parcels }}</h3>

                <p>Parcel Delivered</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" @click.prevent="goToParcelPage(status='delivered')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ total_returned_parcels }}</h3>

                <p>Parcel Returned</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" @click.prevent="goToParcelPage(status='returned')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ total_pending_parcels }}</h3>
                <p>Total Sales</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" @click.prevent="goToParcelPage(status='pending')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ total_pending_parcels }}</h3>
                <p>Total Delivery Fee Paid</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" @click.prevent="goToParcelPage(status='pending')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>0</h3>

                <p>Payment Processing</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>0</h3>

                <p>Total Unpaid Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</template>

<script>
    export default {
        data(){
            return {
                home_text:"Welcome",
                activeVal: 'home',
                total_pending_parcels:0,
                total_parcels:0,
                total_delivered_parcels:0,
                total_returned_parcels:0,
            }
        },
        methods:{
            loadHomePageData(){
                axios.get("home", this.form)
                .then(({ data }) => {
                    console.log(data)
                    this.total_pending_parcels = data.total_pending_parcels;
                    this.total_parcels = data.total_parcels;
                    this.total_delivered_parcels = data.total_delivered_parcels;
                    this.total_returned_parcels = data.total_returned_parcels;
                    // this.loaderrrsss.hide();
                });
            },
            goToParcelPage(status='pending'){
                this.$store.commit('allParcelModule/updateFormValue',{target:'status',value:status})
                this.$router.push({name:'all_parcels'});
            }
        },
        mounted() {
          if(localStorage.getItem("log_first")==1){
            localStorage.removeItem("log_first");
            let loaderrrsss = Vue.$loading.show();
            this.$router.go(0);
          }
        },
        created(){
            this.loadHomePageData();
            console.log("Home Created")
        }
    }
</script>
