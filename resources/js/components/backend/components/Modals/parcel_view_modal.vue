<template>
    <b-modal size="lg" @close.prevent="$emit('close')" @ok.prevent="$emit('close')"
     :hide-backdrop="false" :title="parcel_view_title"
      v-model="parcel_modal_show" :no-enforce-focus="true"
      ok-only ok-variant="secondary" ok-title="Cancel" no-close-on-backdrop>
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
                </b-modal>
</template>
<script>
    export default {
      name: "parcel_view_modal",
      props: ["parcel_view", "parcel_modal_show","parcel_view_title"],
       data() {
            return {
                // parcel_modal_show: false,
            }
        },
        methods: {
            // changeValue: function() {
            //     this.parcel_modal_show = false;
            // }
        },
        mounted() {
            // this.parcel_modal_show = this.parcel_modal_show;
        },
        destroyed(){
            // this.parcel_modal_show = false;
        }
    };
    </script>
