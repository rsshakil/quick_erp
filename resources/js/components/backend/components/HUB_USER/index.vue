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

                                            <td class="cl_custom_color">Hub</td>
                                            <td v-role="['Payra Admin']">
                                              
                                                
                                                <multiselect v-model="searchForm.hub" :options="dataList.hubs" :searchable="true" :close-on-select="true" :show-labels="false" placeholder="Please select hub" label="hub_name" track-by="hub_id" @select="setHub($event)"></multiselect>

                                            </td>
                                            <td>
                                                {{dataList.data['0'].hubinfo.hub_name}}
                                            </td>

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
                ],
                url: `${process.env.MIX_APP_URL}`, //window.location.origin,
            isEdit: false,
            isEditItem: false,
            isFile: false,
            isAddItem: true,
            isPagination: true,
            isSingleItem: false,
            isSamePage: false,
            isSearch: false,
            isActionBtn: true,
            isEditBtn: true,
            isDelBtn: true,
            isSearchBox: true,
            isMerchantFilter: true,
            isStatusList: true,
            isFilterByStatus: true,
            backUrl: '',
            isImage: '',
            showImage: '',
            notReset: {},
            cardTitle: "",
            error: {},
            dataList: {},
            excelFields: {},
            excelTitle: {},
            isDownload: true,
            isSorting: true,
            searchApi: null,
            generalApi: null,
            getApi: null,
            postApi: null,
            patchApi: null,
            editApi: null,
            search: "",
            showPagination: true,
            tableContent: "",
            columnsHead: [],
            columnsBody: [],
            columnsBodyExtra: [],
            vColumns: [],
            isDataSearching: false,
            dataSearchingApi: null,
            searchForm: {},
            sortingForm: {},
            imageData:''
            }
        },
        methods: {
             updateItem(item) {

            let _this = this;
            let api = this.generalApi != null ? this.generalApi : this.postApi
            let patch_api = this.url + 'api/' + api + '/' + item.id + '/?optional_id=' + item.id

            axios.delete(patch_api, { data: item }).then(response => {

                    this.toastMessage('success', response.data.message)
                })
                .catch(error => {

                    if (error.response.status == 422) {
                        this.error = error.response.data.errors
                       
                        console.log('sweet alter not working');
                        $.each(error.response.data.errors, function(item, index) {
                            let input = jQuery(document).find('input[name="' + item + '"]')
                            let inputAfter = jQuery(document).find('input[name="' + item + '"] + span')

                            input.addClass('is-invalid')

                            inputAfter.remove()
                            input.after('<span class="text-danger">' + error.response.data.errors[item] + '</span>')

                            

                        })



                    }
                })
        },
              dialogConfig() {
            let message = "Are you sure?";

            let options = {
                html: false, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: false, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Delete',
                cancelText: 'Close',
                animation: 'bounce', // Available: "zoom", "bounce", "fade"
                type: 'basic', // coming soon: 'soft', 'hard'
                verification: 'continue', // for hard confirm, user will be prompted to type this to enable the proceed button
                verificationHelp: 'Type "[+:verification]" below to confirm', // Verification help text. [+:verification] will be matched with 'options.verification' (i.e 'Type "continue" below to confirm')
                clicksCount: 3, // for soft confirm, user will be asked to click on "proceed" btn 3 times before actually proceeding
                backdropClose: false, // set to true to close the dialog when clicking outside of the dialog window, i.e. click landing on the mask
                customClass: '' // Custom class to be injected into the parent node for the current dialog instance
            };

            let config = {
                message: message,
                options: options
            }

            return config


        },

        /* This delete function work for multiple image delete with relational data and it can
        also delete single image item form it's table */

        deleteItem(i, j) {

            /*   j = When you have to delete a single image from multiple image during edit
               then this 'j' parameter passed image id and it helps to delete image item from it's table*/

            let message = this.dialogConfig().message
            let options = this.dialogConfig().options

            this.$dialog.confirm(message, options)

            .then(res => {
                    let api = this.generalApi != null ? this.generalApi : this.getApi

                    let api_path = this.url + 'api/' + api + '/' + i + '?optional_id=' + j

                    axios.delete(api_path)
                        .then(response => {

                            this.toastMessage(response.data.class_name, response.data.message)
                            this.getDataList()
                           // this.generalSettings()

                        })
                        .catch(error => {
                            this.toastMessage('error', error.response.data.message, 'times')
                        })

                })
                .catch(error => {
                    this.toastMessage('success', 'Thanks for keeping me safe!')
                });

        },
        toastMessage(type, message, icon, position, actionIcon) {
            var toast = null;
            if (type == 'success') {
                toast = this.$toasted.success
            } else if (type == 'info') {
                toast = this.$toasted.info
            } else if (type == 'error') {
                toast = this.$toasted.error
            } else if (type == 'warning') {
                toast = this.$toasted.error
            }
            toast(message, {
                // theme:'bubble',
                icon: icon ? icon : 'check',
                position: position ? position : 'top-right',
                iconPack: 'fontawesome',
                icon: icon ? icon : 'check',
                duration: 3000,
                action: {
                    icon: actionIcon ? actionIcon : 'times',
                    class: 'text-white',
                    onClick: (e, toastObject) => {
                        toastObject.goAway(0);
                    }
                },
            });
        },
        getDataList(page = 1) {
            let api = this.generalApi != null ? this.generalApi : this.getApi

            let search = "";

            if ((this.searchForm.search && this.searchForm.search != 'undefined')) {

                search = this.searchForm.search

            } else {

                search = false

            }

            let sorting_item = ""

            if (this.sortingForm.sorting_item && this.sortingForm.sorting_item != 'undefined') {

                sorting_item = this.sortingForm.sorting_item
                page = (sorting_item - sorting_item) + 1

            } else {

                sorting_item = false

            }
            let merchant_filter_item = ""
            if (this.sortingForm.merchantFilterItem && this.sortingForm.merchantFilterItem != 'undefined') {
                merchant_filter_item = this.sortingForm.merchantFilterItem
                page = 1
            } else {
                merchant_filter_item = false
            }
            let status_filter_item = ""
            if (this.sortingForm.statusFilterItem && this.sortingForm.statusFilterItem != 'undefined') {
                status_filter_item = this.sortingForm.statusFilterItem
                page = 1
            } else {
                status_filter_item = false
            }




            let api_path = this.url + 'api/' + api + '?page=' + page + '&search=' + search + '&sorting=' + sorting_item + '&merchant=' + merchant_filter_item + '&status_filter=' + status_filter_item

            axios.get(api_path)
                .then(response => {

                    if (response.status == 200) {

                        this.dataList = response.data
                     

                    }


                })
                .catch(error => {
                    if (error.response !== undefined && error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        this.toastMessage('error', error, 'check', '', 'times')
                    }
                })
                .finally(() => {

                })
        },



        showEditForm(id) {
            let api = this.generalApi != null ? this.generalApi : this.getApi
            this.$router.push({ path: api + '/' + id });

        },
        },
        created(){
            this.generalApi = "hub-users"
        this.cardTitle ="HUB User List"
        this.isMerchantFilter = false;
        this.columnsHead.push(
          'SL#',
          'User Name',
          'HUB Name',
          'Email',
          'Status',
          'Action'
        )

        this.columnsBody.push(
        'name',
        'hub_name',
        'email')
        // this.columnsBodyExtra =
       this.isDownload = true
        this.excelFields = {
                "HUB Name" : "hub_name",
                "User name": "name",
                "email": "email"

        }
            this.getDataList()
        },
        beforeCreate: function() {
            Fire.$emit('header_nav');
        },
    }

</script>

