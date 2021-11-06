<template>
            <!-- /.card-header -->
            <!-- <TableContent class="py-5" v-if="typeof(dataList) == 'object'" :searchForm="searchForm" :sortingForm="sortingForm" :isAddItem="isAddItem" :isEditBtn="isEditBtn" :isDelBtn="isDelBtn" :isActionBtn="isActionBtn" :cardTitle="cardTitle" :columnsHead="columnsHead" :columnsBody="columnsBody" :dataList="dataList" :showEditForm="showEditForm" :deleteItem="deleteItem" :getAllParcels="getAllParcels" :excelFields="excelFields" :excelTitle="excelTitle" :isDownload="isDownload" :isSearchBox="isSearchBox" :isMerchantFilter="isMerchantFilter" route="admin"></TableContent> -->
            <div class="row py-5">

                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ cardTitle }}</h3>
                            <router-link :to="{name:'add_parcel'}" class="btn btn-sm btn-primary float-right m-1">Add New</router-link>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-12" style="padding: 10px">
                                    <table class="table orderDetailTable cmnWidthTable table-bordered" style="width: 100%">
                                        <tr>
                                            <td class="cl_custom_color">
                                                Customer Name
                                            </td>
                                            <td>
                                                <input type="text" v-model="form.search" class="form-control" placeholder="Customer Name">
                                            </td>

                                            <td class="cl_custom_color">
                                                Status
                                            </td>
                                            <td>
                                                <v-select @input="getAllParcels" v-model="form.status" :options="parcelStatusItems" :reduce="parcelStatusItems => parcelStatusItems" label="parcelStatusItems" placeholder="Status"></v-select>
                                            </td>

                                            <td class="cl_custom_color">Delivery</td>
                                            <td>
                                                <v-select @input="getAllParcels" v-model="form.status" :options="statusItems" :reduce="statusItems => statusItems" label="statusItems" placeholder="Status"></v-select>

                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="cl_custom_color">District Name</td>
                                            <td><input type="text" v-model="form.search" class="form-control" placeholder="District Name"></td>

                                            <td class="cl_custom_color">Thana Name</td>
                                            <td><input type="text" v-model="form.search" class="form-control" placeholder="Thana Name"></td>

                                            <td class="cl_custom_color">Area Name</td>
                                            <td><input type="text" v-model="form.search" class="form-control" placeholder="Area Name"></td>
                                        </tr>

                                        <tr>
                                            <td class="cl_custom_color">Marchents</td>
                                            <td>
                                                <v-select @input="getAllParcels()" v-model="form.merchant" :options="merchants" label="company_name" placeholder="Merchants" v-if="merchants.length!=0"></v-select>
                                            </td>
                                            <td class="cl_custom_color_extra">Merchant Name</td>
                                            <td>{{ form.merchant?form.merchant.company_name:'' }}</td>
                                            <td class="cl_custom_color_extra">Address</td>
                                            <td>{{ form.merchant?form.merchant.business_address:'' }}</td>
                                        </tr>

                                    </table>

                                </div>
                                <br />
                                <div class="col-12" style="text-align: center">
                                    <button class="btn btn-primary active srchBtn" type="button" @click="getAllParcels()">
                                        Search
                                    </button>
                                </div>
                            </div>
                            <button class="col-md-2 float-right m-1 btn btn-info" @click="downloadParcel()">Download</button>
                            <button class="col-md-2 float-right m-1 btn btn-info" @click="pickRequest()">Pick request</button>
                            <v-select @input="getAllParcels()" v-model="form.per_page" class="col-md-2 float-right m-1" :options="sortingData" :reduce="sorting => sorting.count_num" label="count_num" placeholder="Sort Item"></v-select>
                            <table class="table table-bordered customDataTable table-responsive w-100 d-block d-md-table table-response">
                                <thead>
                                    <tr class="table-secondary">
                                        <td>
                                            <input @click="checkAll" v-model="isCheckAll" type="checkbox" /> All
                                        </td>
                                        <td>SL#</td>
                                        <td>Customer Name</td>
                                        <td>District Name</td>
                                        <td>Charge Rate</td>
                                        <td>Weight Name</td>
                                        <td>Weight Charge</td>
                                        <td>Delivery Option</td>
                                        <!-- <td>Option rate</td>-->
                                        <td>Option Charge</td>
                                        <!-- <td>Marchent Order Id</td>
                                <td>Pickup Address</td>-->
                                        <!-- <td>Product Description</td> -->
                                        <td>Collection Amount</td>
                                        <!-- <td>Charge Amount</td> -->
                                        <td>Total Collection</td>
                                        <!-- <td>remark</td> -->
                                        <td>Status</td>
                                        <td colspan="4">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="parcel,i in parcels.data" :key="i">
                                        <td>
                                            <input type="checkbox" v-bind:value="parcel.id" v-model="selected" v-if="parcel.status=='pending'" />
                                            <b-button pill variant="info" v-else>{{ parcel.status | capitalize }}</b-button>
                                        </td>
                                        <td>{{ parcels.meta.current_page * form.per_page - form.per_page + i + 1 }}</td>
                                        <td>{{ parcel.customer_name }}</td>
                                        <td>{{ parcel.district_name }}</td>
                                        <td>{{ parcel.delivery_charge }}</td>
                                        <td>{{ parcel.weight_name }}</td>
                                        <td>{{ parcel.weight_charge }}</td>
                                        <td>{{ parcel.delivery_option }}</td>
                                        <!--<td>{{ parcel.delivery_option_rate }}</td>-->
                                        <td>{{ parcel.option_charge }}</td>
                                        <!-- <td>{{ parcel.marchent_order_id }}</td>
                                <td>{{ parcel.pickup_address }}</td>-->
                                        <!-- <td>{{ parcel.product_description }}</td> -->
                                        <td>{{ parcel.collection_amount }}</td>
                                        <!-- <td>{{ parcel.charge_amount }}</td> -->
                                        <td>{{ parcel.total_collection }}</td>
                                        <!-- <td>{{ parcel.remark }}</td> -->
                                        <td>{{ parcel.status }}</td>
                                        <td>
                                            <a href="#" @click.prevent="ShowParcel(parcel)" class="btn btn-info btn-circle btn-xs">
                                                <b-icon icon="eye-fill" font-scale="1.2"></b-icon>
                                            </a>
                                        </td>
                                        <td>
                                            <!-- <b-button title="Download as PDF">
                                                <b-icon icon="file-earmark" aria-hidden="true"></b-icon>
                                            </b-button> -->
                                            <a href="#" title="Download as PDF" @click.prevent="downloadParcel(parcel)" class="btn btn-info btn-circle btn-xs">
                                                <!-- <b-icon icon="eye-fill" font-scale="1.2"></b-icon> -->
                                                <b-icon icon="file-earmark" aria-hidden="true"></b-icon>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" @click.prevent="editParcel(parcel)" class="btn btn-success btn-circle btn-xs">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" @click.prevent="deleteOrRetrive(parcel,parcel.deleted_at==null?'d':'r')" class="btn btn-circle btn-xs" :class="parcel.deleted_at==null?'btn-danger':'btn-info'">
                                                <b-icon icon="trash" v-if="parcel.deleted_at==null" font-scale="1.2"></b-icon>
                                                <b-icon icon="arrow-counterclockwise" font-scale="1.2" v-else></b-icon>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr v-if="parcels.data && parcels.data.length==0">
                                        <td colspan="100%">There is no record available!</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">

                            <p>
                                <span class="tableRowsInfo">{{ parcels.meta.from }}〜{{ parcels.meta.to }} View／Total：{{ parcels.meta.total }} Parcel(s)</span>
                                <span class="pagi">
                                    <advanced-laravel-vue-paginate :data="parcels" :onEachSide="2" previousText="<" nextText=">" alignment="center" @paginateTo="getAllParcels" />
                                </span>
                                <span>

                                </span>
                            </p>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- <b-modal size="lg" :hide-backdrop="true" :title="parcel_view_title" v-model="parcel_modal_show" :no-enforce-focus="true">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-responsive w-100 d-block d-md-table table-response">
                                <tr>
                                    <td>Customer Name</td>
                                    <td>{{ parcel_view?parcel_view.customer_name:'' }}</td>
                                </tr>
                                <tr>
                                    <td>District Name</td>
                                    <td>{{ parcel_view?parcel_view.district_name:'' }}</td>
                                </tr>
                                <tr>
                                    <td>District Charge</td>
                                    <td>{{ parcel_view?parcel_view.delivery_charge:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Weight Name</td>
                                    <td>{{ parcel_view?parcel_view.weight_name:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Weight Charge</td>
                                    <td>{{ parcel_view?parcel_view.weight_charge:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Delivery Option</td>
                                    <td>{{ parcel_view?parcel_view.delivery_option:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Option Rate</td>
                                    <td>{{ parcel_view?parcel_view.delivery_option_rate:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Option Charge</td>
                                    <td>{{ parcel_view?parcel_view.option_charge:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Marchent Order ID</td>
                                    <td>{{ parcel_view?parcel_view.marchent_order_id:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Pickup Address</td>
                                    <td>{{ parcel_view?parcel_view.pickup_address:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Product Description</td>
                                    <td>{{ parcel_view?parcel_view.product_description:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Collection Amount</td>
                                    <td>{{ parcel_view?parcel_view.collection_amount:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Charge Amount</td>
                                    <td>{{ parcel_view?parcel_view.charge_amount:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Total Collection</td>
                                    <td>{{ parcel_view?parcel_view.total_collection:'' }}</td>
                                </tr>
                                <tr>
                                    <td>Remark</td>
                                    <td>{{ parcel_view?parcel_view.remark:'' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </b-modal> -->
                <!-- <parcel_view_modal v-if="parcel_modal_show" @close="parcel_modal_show = false" :parcel_view="parcel_view" :parcel_view_title="parcel_view_title" /> -->
                <parcel_view_modal :modal-visible="parcel_modal_show" @close="parcel_modal_show = false" :parcel_modal_show="parcel_modal_show" :parcel_view="parcel_view" :parcel_view_title="parcel_view_title" />
            </div>
</template>

<script>
export default {
    components: {
        // parcelModalView: () => import(/* webpackPrefetch: true */ '../Modals/parcel_view_modal.vue')
        parcel_view_modal: () => import(/* webpackChunkName: "backend/parcel_view_modal" */ '../Modals/parcel_view_modal.vue')
    },
    data() {
        return {
            cardTitle: "Parcel List",
            statusItems: ['All', 'active', 'pending', 'rejected'],
            merchants: [],
            parcel_view: {},
            parcel_view_title: "Parcel View",
            parcel_modal_show: false,
            isCheckAll: false,
            selected: [],
            parcels: {
                meta: {
                    from: 1,
                }
            },
            form: {
                search: null,
                per_page: 15,
                page: 1,
                merchant: [],
                status: 'All',
            }
        }
    },
    methods: {
        getAllParcels(page = 1) {
            // console.log(this.form.merchant)
            this.loader = Vue.$loading.show();
            this.form.page = page;
            axios.post("parcels", this.form)
                .then(({
                    data
                }) => {
                    // console.log(data);
                    this.merchants = data.merchants;
                    if (this.merchants.length == 0) {
                        this.form.merchant = data.merchant;
                    }
                    this.parcels = data;
                    this.loader.hide();
                    // this.customers = data.data;
                }).catch(() => {
                    this.sweet_advance_alert();
                    this.loader.hide();
                });
        },
        ShowParcel(parcel) {
            console.log(parcel)
            this.parcel_view = parcel;
            this.parcel_modal_show = true;
        },
        editParcel(parcel) {
            // console.log(parcel)
            this.$router.push({
                name: 'add_parcel',
                query: {
                    parcel_id: parcel.id
                }
            })
        },
        deleteOrRetrive(parcel, type = 'd') {
            this.alert_icon = 'warning';
            this.alert_title = (type === 'd' ? 'Are you sure?' : 'Are you sure to retrive it?');
            this.alert_text = (type === 'd' ? 'Deleted data will be able to retrived' : '');
            this.yes_btn = (type === 'd' ? 'Yes delete it!' : 'Yes retrive it!')
            var _this = this;
            this.confirm_sweet().then((result) => {
                if (result.value) {
                    var delete_param = {
                        parcel_id: parcel.id,
                        deleted_at: parcel.deleted_at
                    }
                    axios.delete('parcel/' + JSON.stringify(delete_param)).then(({
                        data
                    }) => {
                        if (data.status == 1) {
                            _this.alert_icon = data.class_name;
                            _this.alert_title = data.title;
                            _this.alert_text = data.message;
                            _this.sweet_normal_alert()
                            _this.getAllParcels(this.form.page)
                        }
                    })
                }
            })
        },
        checkAll(){
            this.isCheckAll = !this.isCheckAll;
            if (this.selected.length>0) {
                this.selected=[]
            }

            if (this.isCheckAll) {
                this.parcels.data.forEach(element => {
                    if (element.status=='pending') {
                        this.selected.push(element.id)
                    }
                });
            }else{
                this.selected=[]
            }
            console.log(this.selected)
        },
        pickRequest(){
        //   console.log(this.selected)
          if (this.selected.length<=0) {
              this.alert_icon = 'warning';
                this.alert_title = "Not Updated!";
                this.alert_text = 'Please select at least one item';
                this.sweet_normal_alert()
              return
          }
          var params={parcel_ids:this.selected,status:'picking'}
          axios.post("parcel_status_update", params)
            .then(({ data }) => {
                if (data.status==1) {
                    this.alert_icon = data.class_name;
                    this.alert_title = "Updated!";
                    this.alert_text = data.message;
                    this.sweet_normal_alert()
                    this.isCheckAll=false;
                    this.getAllParcels(this.form.page)
                }
            })
      },
      downloadParcel(parcel=null){
        this.loader = Vue.$loading.show();
        var download_url=null;
        if (parcel!=null) {
            download_url=axios.post("get_parcel_pdf", parcel);
        }else{
            download_url=axios.post("get_parcel_pdf");
        }
        download_url.then(({data}) => {
            this.downloadFromUrl(data.pdf_data)
            this.loader.hide();
        }).catch(() => {
            this.sweet_advance_alert();
            this.loader.hide();
        });
      }
    },
    beforeCreate: function () {
        Fire.$emit('header_nav');
    },

    created() {
        this.form = this.$store.getters['allParcelModule/getFormData'];
        this.getAllParcels();
        //    this.isDownload = true
        //     this.excelFields = {
        //             "pickup_address" : "pickup_address",
        //             "collection_amount": "collection_amount",
        //             "total_collection": "total_collection",
        //             "remark" : "remark"

        //     }

    }
}
</script>
