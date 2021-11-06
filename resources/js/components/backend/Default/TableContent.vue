<template>
    <div class="row py-5">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-4">
            <div class="card">
                <div class="card-header">
                     <h3 class="card-title">{{ cardTitle }}</h3>
                    <router-link :to="this.$route.path+'/create'" class="btn btn-sm btn-primary float-right m-1" v-if="isAddItem">Add New</router-link>

                </div>
                <div class="card-body">


 <div class="row">
                                <div class="col-12" style="padding: 10px">
                                    <table class="table orderDetailTable cmnWidthTable table-bordered" style="width: 100%">
                                        <tr>
                                            <td class="cl_custom_color">
                                                 Name
                                            </td>
                                            <td>
                                                <input type="text" v-model="searchForm.search" class="form-control" placeholder=" Name">
                                            </td>

                                            <td class="cl_custom_color">
                                                Status
                                            </td>
                                            <td>
                                                <v-select @input="getDataList" :isFilterByStatus="isFilterByStatus" v-model="sortingForm.statusFilterItem" :options="statusItems" :reduce="statusItems => statusItems" label="statusItems" placeholder="Status" v-if="isFilterByStatus"></v-select>
                                            </td>

                                            <td class="cl_custom_color">Delivery</td>
                                            <td>
                                              
                                                <input type="text" v-model="searchForm.search" class="form-control" placeholder=" Name">

                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="cl_custom_color">District Name</td>
                                            <td><input type="text" v-model="searchForm.search" class="form-control" placeholder="District Name"></td>

                                            <td class="cl_custom_color">Thana Name</td>
                                            <td><input type="text" v-model="searchForm.search" class="form-control" placeholder="Thana Name"></td>

                                            <td class="cl_custom_color">Area Name</td>
                                            <td><input type="text" v-model="searchForm.search" class="form-control" placeholder="Area Name"></td>
                                        </tr>

                                        <tr>
                                            <td class="cl_custom_color">Marchents</td>
                                            <td>
                                               
                    <v-select @input="getDataList" :isMerchantFilter="isMerchantFilter" v-model="sortingForm.merchantFilterItem" :options="dataList.merchants" :reduce="merchants => merchants.id" label="company_name" placeholder="Merchants" v-if="isMerchantFilter"></v-select>

                                            </td>
                                            <td class="cl_custom_color_extra">Merchant Name</td>
                                            <td>{{  dataList.merchant?dataList.merchant.company_name:'' }}</td>
                                            <td class="cl_custom_color_extra">Address</td>
                                            <td>{{ dataList.merchant?dataList.merchant.business_address:'' }}</td>
                                        </tr>

                                    </table>

                                </div>
                                <br />
                                <div class="col-12" style="text-align: center">
                                    <button class="btn btn-primary active srchBtn" type="button" @click="getDataList()">
                                        Search
                                    </button>
                                </div>
                            </div>



                    <v-select @input="getDataList" :isSorting="isSorting" v-model="sortingForm.sorting_item" class="col-md-2 float-right m-1" :options="sortingData" :reduce="sorting => sorting.count_num" label="count_num" placeholder="Sort Item"></v-select>

                    <downloadExcel :style="isDownload == false?'display:none':''" class="btn btn-sm btn-success float-right m-1" :data="dataList.data" :fields="excelFields"  :name="cardTitle"></downloadExcel>
                  
                   
                    <table class="table table-bordered customDataTable table-responsive w-100 d-block d-md-table table-response">
                        <thead>
                            <tr class="table-secondary">
                                <td  v-for="(thead, i) in columnsHead"  :key="i">{{ thead }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in dataList.data" :key="index" v-if="!item.isComplete">
                                <td>{{ dataList.meta.from +index }}</td>
                                <td v-for="(tbody, i) in columnsBody.slice(0, columnsBody.length)" :key="i" v-html="item[tbody]">

                                </td>
                                <td>
                                    <!-- @input="getDataList" -->
                                    <v-select :isStatusList="isStatusList" v-model="item.status" :options="statusItems" :reduce="statusItems => statusItems" label="statusItems" placeholder="Status" @input="updateItem(item)"  v-if="isStatusList"></v-select>
                                </td>
                                <td class="text-center" v-if="isActionBtn">
                                    <a href="#" v-if="isEditBtn" @click.prevent="showEditForm(item.id)"
                                        class="btn btn-success btn-circle btn-xs">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" v-if="isDelBtn" @click.prevent="deleteItem(item.id)"
                                        class="btn btn-circle btn-xs" :class="item.deleted_at==null?'btn-danger':'btn-info'">
                                        <!-- <i class="fas fa-trash" v-if="item.deleted_at==null"></i> -->
                                        <b-icon icon="trash" v-if="item.deleted_at==null" font-scale="1.2"></b-icon>
                                        <b-icon icon="arrow-counterclockwise" font-scale="1.2" v-else></b-icon>
                                        <!-- <i class="fas fa-reset" v-else></i> -->
                                    </a>
                                </td>

                            </tr>
                            <tr v-else><td :colspan="columnsHead.length" class="text-danger text-center">There is no record available!</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <pagination class="pagination pagination-sm m-0 float-right" :data="dataList"
                        @pagination-change-page="getDataList"></pagination>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'isAddItem', 'isEditBtn', 'isDelBtn','isActionBtn', 'cardTitle','columnsHead', 'columnsBody', 'dataList', 'showEditForm', 'deleteItem', 'getDataList', 'excelFields','excelTitle', 'isDownload', 'isSorting','isSearchBox','isMerchantFilter','isStatusList','searchForm', 'sortingForm','updateItem','isFilterByStatus'
            ],

        data(){
            return {
                statusItems: ['active', 'pending', 'rejected'],
                sortingData:[
                    {count_num:15},
                    {count_num:25},
                    {count_num:50},
                    {count_num:100},
                    {count_num:500},
                    {count_num:1000},
                ]
            }
        },
        beforeCreate: function() {
            Fire.$emit('header_nav');
        },
    }

</script>

