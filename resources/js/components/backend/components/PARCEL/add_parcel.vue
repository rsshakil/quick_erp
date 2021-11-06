<template>
<div class="main-content-container container-fluid px-4">
    <!-- <form class="form" @submit.prevent="processData()"> -->

    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <!-- <span class="text-uppercase page-subtitle">Overview</span> -->
            <h3 class="page-title">{{ cardTitle }}</h3>
        </div>
    </div>
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
                    <div class="col-md-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- @select="getThanas($event)" -->
                                    <span v-role="['Payra Admin']">
                                        <multiselect v-model="form.merchant" :options="merchants" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select marchent" label="merchant_name" track-by="merchant_id" @select="customerList($event)"></multiselect>
                                    </span>
                                    <fieldset>
                                        <legend>Merchant Information</legend>
                                        <table class="table ">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 40%">Merchant Company </th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%">
                                                        {{ merchant?form.merchant.company_name:''}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Merchant Name</th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%"> {{ merchant?merchant.merchant_name:''}} </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Merchant Contact </th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%"> {{ form.merchant?form.merchant.phone:''}} </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Business Address</th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%">{{ form.merchant?form.merchant.business_address:''}}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Full Address</th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%">{{ form.merchant?form.merchant.full_address:''}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend>Parcel Charge </legend>
                                        <table class="table ">
                                            <tbody>
                                                <tr>
                                                    <th style="width: 40%">Weight Package</th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%">{{ form.weight_name }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Weight Charge </th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%">{{ form.weight_charge }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Collection Amount </th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%">{{ form.collection_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Delivery Option Rate </th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%">{{ form.delivery_option_rate }} %</td>
                                                </tr>

                                                <tr>
                                                    <th style="width: 40%">Delivery Option Charge</th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%">{{ deliveryOptionCharge }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Delivery Charge</th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%">{{ form.delivery_charge }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 40%">Total Charge </th>
                                                    <td style="width: 10%"> : </td>
                                                    <td style="width: 50%">{{ totalCharge }}
                                                        <!-- <input type="hidden" v-model="form.collection_amount=totalCharge" name="collection_amount"> -->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend>Customer Information </legend>
                                        <div class="customer_tabpan">
                                            <b-tabs content-class="mt-3">
                                                <b-tab title="Select Existing Customer" active>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="customer_name">Select customer <code>*</code></label>
                                                            <multiselect v-model="form.customer" :options="customers" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select customer" label="customer_name" track-by="id" @select="setCustomer($event)"></multiselect>
                                                        </div>
                                                    </div>
                                                </b-tab>
                                                <b-tab title="New Customer">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="customer_name">Customer Name <code>*</code></label>
                                                                <input type="text" v-model="form.customer_name" name="customer_name" id="customer_name" value="" class="form-control" placeholder="Customer Name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="customer_contact_number">Customer Contact Number <code>*</code></label>
                                                                <input type="text" v-model="form.contact_number" name="contact_number" id="contact_number" class="form-control" placeholder="Customer Contact Number">
                                                            </div>
                                                        </div>

                                                    </div>

                                                </b-tab>
                                            </b-tabs>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <legend>Customer Address </legend>
                                        <div class="customer_tabpan">
                                            <b-tabs content-class="mt-3">
                                                <b-tab title="Existing Address" active>
                                                    <p>Customer Your address</p>
                                                    <multiselect v-model="form.customer_address" :options="customer_addresses" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select address" label="address" track-by="id" @select="get_district_charge($event)"></multiselect>
                                                </b-tab>
                                                <b-tab title="New Address">
                                                    <div class="row">
                                                        <div class="col-md-4 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="district_id"> Districts <code>*</code> </label>
                                                                <multiselect v-model="form.chargeList" :options="chargeLists" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select charge" label="district_name" track-by="district_id" @select="setDistrict($event)"></multiselect>
                                                                <input type="hidden" name="district_id" v-model="form.district_id">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="upazila_id"> Thana/Upazila <code>*</code> </label>
                                                                <multiselect v-model="form.thana" :options="thanas" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select thana" label="thana_name" track-by="thana_id" @select="setThana($event)"></multiselect>
                                                                <!-- <input type="hidden" name="thana_id" v-model="form.thana_id"> -->

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="area_id"> Area </label>
                                                                <multiselect v-model="form.areaList" :options="areas" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select area" label="area_name" track-by="area_id" @select="setArea($event)"></multiselect>
                                                                <input type="hidden" name="area_id" v-model="form.area_id">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="customer_address">Customer Address <code>*</code></label>
                                                                <input type="text" v-model="form.new_customer_address" name="customer_address" id="customer_address" class="form-control" placeholder="Customer Address">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </b-tab>
                                            </b-tabs>
                                        </div>
                                </div>
                                <div class="col-md-12">
                                    <fieldset>
                                        <legend>Parcel Information </legend>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="marchent_order_id">Merchant Order ID </label>
                                                    <input type="text" name="marchent_order_id" id="marchent_order_id" v-model="form.marchent_order_id" class="form-control" placeholder="Merchant Order ID" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="select_pickup_address"> Select Pickup Address </label>
                                                    <select name="select_pickup_address" id="select_pickup_address" v-model="form.selected_pickup_address" class="form-control select2 select2-hidden-accessible" style="width: 100%" data-select2-id="select_pickup_address" tabindex="-1" aria-hidden="true" @change="setPickupAddress($event)">
                                                        <option value="0">---- Select ----</option>
                                                        <option v-for="(address,i) in selectPickupAddress" :key="i" :value="address">{{ address }}</option>
                                                        <!-- <option value="2">Full Address </option> -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pickup_address">Pickup Address </label>
                                                    <input type="text" name="pickup_address" id="pickup_address" :disabled="is_disabled(false)" v-model="form.pickup_address" class="form-control" placeholder="Pickup Address">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="weight_package_id"> Weight Package <code>*</code> </label>
                                                    <multiselect v-model="form.charge_package" :options="weight_lists" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select weight package" label="weight_name" track-by="id" @select="setweight($event)" required></multiselect>

                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="delivery_option_id"> Delivery Option <code>*</code> </label>
                                                    <multiselect v-model="form.deliveryOption" :options="deliveryOptions" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select delivery" label="option_name" track-by="option_id" @select="setDeliveryOption($event)" required></multiselect>
                                                    <input type="hidden" name="delivery_option_id" v-model="form.delivery_option_id">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="product_description">Product(s) Brief <code>*</code> </label>
                                                    <input type="text" v-model="form.product_description" name="product_description" id="product_description" class="form-control" placeholder="Product Details " required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="total_collection">Collection Amount</label>
                                                    <input type="number" v-model="form.collection_amount" name="total_collection" id="total_collection" class="form-control" placeholder="0.00" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="remark">Remark</label>
                                                    <textarea name="remark" id="remark" v-model="form.remark" class="form-control" placeholder="Parcel Remark" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-12 text-center">
                                    <div class="card-footer">
                                        <b-button pill variant="primary" @click.prevent="saveParcel()" type="submit">
                                            <b-icon icon="inbox-fill" font-scale="1.2"></b-icon> {{form.submit_button}}
                                        </b-button>
                                        <!-- <FormButton :isEdit="isEdit" :backUrl="backUrl"></FormButton> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </form> -->
</div>
</template>

<script>
// import mixin from '../../Mixin/mixin';
export default {
    // mixins:[mixin],
    data() {
        return {
            cardTitle: 'Add Parcel',
            merchants: [],
            merchant: [],
            customers: [],
            weight_lists: [],
            customer_addresses: [],
            chargeLists: [],
            deliveryOptions: [],
            selectPickupAddress: ['Business Address', 'Full Address'],
            form: {
                merchant: [],
                customer: [],
                customer_address: [],
                selected_pickup_address: 0,
                pickup_address: null,
                marchent_order_id: null,
                charge_package: [],
                charge_package_id: null,
                deliveryOption: [],
                product_description: null,
                collection_amount: 0,
                remark: null,
                delivery_charge: 0,
                weight_charge: 0,
                weight_name: "Not confirmed",
                delivery_option_charge: 0,
                delivery_option_rate: 0,
                total_charge: 0,
                chargeList: [],
                thana: [],
                area: [],
                district: [],
                // Customer Area
                customer_name: null,
                contact_number: null,
                district_id: null,
                thana_id: null,
                new_customer_address: null,
                submit_button: 'Save',
            }
        };
    },
    methods: {
        getMerchants() {
            this.loaderrrsss = Vue.$loading.show();
            axios.post("get_merchant", this.form)
                .then(({
                    data
                }) => {
                    console.log(data)
                    // return
                    this.merchants = data.merchants;
                    if (this.merchants.length == 0) {
                        this.form.merchant = data.merchant;
                        this.customers = data.customers;
                    }
                    this.chargeLists = data.chargeLists;
                    this.deliveryOptions = data.deliveryOptions;
                    // console.log(this.deliveryOptions)

                    this.loaderrrsss.hide();
                });
        },
        customerList($event) {
            //   console.log($event)
            axios.get("get_customer_by_merchant/" + $event.merchant_id)
                .then(({
                    data
                }) => {
                    // console.log(data);
                    this.customers = data.data;
                })
        },
        setCustomer($event) {
            this.customer_addresses = $event.customer_addresses;
        },
        get_district_charge($event) {
            //    console.log($event)
            this.form.charge_package = [];
            this.form.weight_name = "Not confirmed";
            this.form.weight_charge = 0;
            axios.get("get_district_charge/" + $event.district_id)
                .then(({
                    data
                }) => {
                    console.log(data)
                    this.form.chargeList = data;
                    this.form.delivery_charge = data.charge_rate;
                    this.weightPackages(data.charge_list_id);
                })
        },
        weightPackages(charge_list_id) {
            axios.post("get_weight_list", {
                    charge_list_id: charge_list_id
                })
                .then(({
                    data
                }) => {
                    console.log(data)
                    this.weight_lists = data.weight_lists;
                })
        },
        setweight($event) {
            console.log($event)
            this.form.charge_package_id = $event.charge_package_id;
            this.form.weight_name = $event.weight_name;
            this.form.weight_charge = $event.charge;
            console.log(this.form);
        },
        setPickupAddress($event) {
            if (Object.entries(this.form.merchant).length) {
                if (this.form.selected_pickup_address == 'Business Address') {
                    this.form.pickup_address = this.form.merchant.business_address
                } else if (this.form.selected_pickup_address == "Full Address") {
                    this.form.pickup_address = this.form.merchant.full_address
                } else {
                    this.form.pickup_address = null;
                }
            } else {
                console.log("Please select merchant")
                this.form.selected_pickup_address = 0;
            }
            //   this.form.selected_pickup_address;
        },

        setDistrict($event) {
            //   console.log($event)
            this.form.delivery_charge = $event.charge_rate
            this.getThanas($event)
            this.weightPackages($event.charge_list_id);
            this.form.district_id = $event.district_id;
        },

        setThana($event) {
            //   this.form.areaList=[];
            // console.log($event)
            this.getAreas($event)
            this.form.thana_id = $event.thana_id;
        },
        setDeliveryOption($event) {
            console.log($event)
            this.form.delivery_option_rate = $event.option_rate
            this.form.delivery_option_id = $event.option_id;
            //   delivery_option_charge:0,
        },
        saveParcel() {
            console.log(this.form)
            if (this.form.customer.length == 0) {
                if (this.form.customer_name == null || this.form.contact_number == null) {
                    this.alert_icon = "warning";
                    this.alert_title = "Information Missing";
                    this.alert_text = "Please select or create customer";
                    this.sweet_normal_alert();
                    //   console.log("Please select or create customer");
                    return;
                }
            }
            if (this.form.customer_address.length == 0) {
                if (this.form.district_id == null || this.form.thana_id == null || this.form.area.length == 0 || this.form.new_customer_address == null) {
                    //   console.log("Please select or create customer address");
                    this.alert_icon = "warning";
                    this.alert_title = "Information Missing";
                    this.alert_text = "Please select or create customer address";
                    this.sweet_normal_alert();
                    return;
                }
            }
            if (this.form.charge_package_id == null) {
                this.alert_icon = "warning";
                this.alert_title = "Information Missing";
                this.alert_text = "Please select weight list";
                this.sweet_normal_alert();
                // console.log("Please select weight list");
                return;
            }
            if (this.form.deliveryOption.length == 0) {
                this.alert_icon = "warning";
                this.alert_title = "Information Missing";
                this.alert_text = "Please select delivery option";
                this.sweet_normal_alert();
                // console.log("Please select delivery option");
                return;
            }
            if (this.form.product_description == null) {
                this.alert_icon = "warning";
                this.alert_title = "Information Missing";
                this.alert_text = "Please write product description";
                this.sweet_normal_alert();
                // console.log("Please write product description");
                return;
            }
            //   if (this.form.deliveryOption.length!=0 && this.form.deliveryOption.option_rate<1) {
            //     console.log("Please mension collection amount");
            //     return;
            //   }
            var loader = Vue.$loading.show();
            var parcel_url='';
            if (this.form.submit_button=="Save") {
                parcel_url=axios.post("parcel", this.form);
            }else if(this.form.submit_button=="Update"){
                parcel_url=axios.put("parcel/"+this.$route.query.parcel_id, this.form);
            }
            // axios.post("parcel", this.form)
                parcel_url.then(({
                    data
                }) => {
                    console.log(data)
                    if (data.status == 1) {
                        // console.log(data.message)
                        this.alert_icon = data.class_name;
                        this.alert_title = this.form.submit_button=="Save"? "Created!":"Updated!";
                        this.alert_text = data.message;
                        this.$router.push({name:'all_parcels'});
                        this.sweet_normal_alert();
                        loader.hide();

                    }
                }).catch(() => {
                    this.sweet_advance_alert();
                    loader.hide();
                    // loader.hide();
                });
        },
        getSingleParcel(parcel_id){
            axios.get("parcel/" + parcel_id)
            .then(({data}) => {
                    console.log(data)
                    this.form=data.data;
                    this.form.merchant = data.merchant;
                    this.customers = data.customers;
                    (this.customers).forEach(element => {
                        if (element.id==data.data.customer_id) {
                            this.customer_addresses = element.customer_addresses;
                            this.form.customer=element;
                        }
                    });
                    (this.customer_addresses).forEach(element => {
                        if (element.id==data.data.customer_address_id) {
                            this.form.customer_address=element;
                        }
                    });
                    this.form.deliveryOption={option_id:data.data.delivery_option_id,option_name:data.data.delivery_option,option_rate:data.data.delivery_option_rate}
                    this.form.chargeList=data.data.charge_package.charge_list
                    this.weightPackages(this.form.chargeList.id)
                    this.form.charge_package=data.data.charge_package.weight_list
                    this.form.district_id= null;
                    this.form.thana_id= null;
                    this.form.area= [];
                    this.form.customer_name= null;
                    this.form.contact_number= null;
                    this.form.submit_button = 'Update';

                })
        }

    },

    created() {
        if (this.$route.query.parcel_id) {
            this.cardTitle = 'Edit Parcel';
            var parcel_id = this.$route.query.parcel_id;
            this.getSingleParcel(parcel_id);
        }
        this.getMerchants();
    },
    mounted() {},
    computed: {
        // a computed getter
        deliveryOptionCharge: function () {
            return this.form.delivery_option_charge = (Number(this.form.delivery_option_rate) * Number(this.form.collection_amount)) / 100
        },
        totalCharge: function () {
            return Number(this.form.weight_charge) + Number(this.form.delivery_charge) + Number(this.form.delivery_option_charge)
        }
    }
};
</script>
