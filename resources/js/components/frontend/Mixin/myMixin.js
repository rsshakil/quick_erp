export default {
    data() {
        return {
            global_user_id: '',
            myLang: '',
            BASE_URL: `${process.env.MIX_APP_URL}`,
            alert_icon: 'error',
            alert_title: 'Oops...',
            alert_text: 'Something went wrong!',
            alert_footer: 'May be internet or url problem',
        }
    },
    methods: {

        sweet_normal_alert() {
            Swal.fire({
                icon: this.alert_icon,
                title: this.alert_title,
                text: this.alert_text
            })
        },
        sweet_advance_alert() {
            Swal.fire({
                icon: this.alert_icon,
                title: this.alert_title,
                text: this.alert_text,
                footer: this.alert_footer
            })
        },
        delete_sweet() {
            this.alert_icon = 'warning'
            this.alert_title = 'Are you sure?'
            this.alert_text = "You won't be able to revert this!"
            var status = Swal.fire({
                icon: this.alert_icon,
                title: this.alert_title,
                text: this.alert_text,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            return status;
        },
        is_disabled(is_system = 0) {
            if (is_system == 0) {
                return true;
            } else {
                return false;
            }
        },
        getDistricts() {
            axios.post("get_districts")
                .then(({ data }) => {
                    this.districts = data.districts;
                    // console.log(this.districts);
                })
        },
        getHubs() {
            axios.post("get_hubs")
                .then(({ data }) => {
                    this.hubs = data.hubs;
                })
        },
        getThanaListByDistrctId(id) {
            axios.post("get_thanas", { district_id: id })
                .then(({ data }) => {
                    this.thanas = data.thanas;
                })
        },
        getAreaListByThanaId(id) {
            axios.post("get_areas", { thana_id: id })
                .then(({ data }) => {
                    this.areas = data.areas;
                })
        },
        getThanas($event) {
            this.form.thana = null
            this.form.area = null
            this.form.district = $event
            console.log($event);
            if (this.$route.name == "signup") {
                this.inputData.district_id = $event.district_id;
            }
            axios.post("get_thanas", { district_id: $event.district_id })
                .then(({ data }) => {
                    this.thanas = data.thanas;
                })
        },
        getAreas($event) {
            this.form.area = null
            this.form.thana = $event
            if (this.$route.name == "add-merchant" || this.$route.name == "edit-merchant" || this.$route.name == "add-hubs" || this.$route.name == "edit-hubs" || this.$route.name == "signup") {
                this.inputData.thana_id = $event.thana_id
            }
            axios.post("get_areas", { thana_id: $event.thana_id })
                .then(({ data }) => {
                    this.areas = data.areas;
                })
        },
        setArea($event) {
            this.form.area = $event
            if (this.$route.name == "add-merchant" || this.$route.name == "edit-merchant" || this.$route.name == "add-hubs" || this.$route.name == "edit-hubs" || this.$route.name == "signup") {
                this.inputData.area_id = $event.area_id;
            }

        },
        // logout() {
        //     localStorage.removeItem("user")
        //     localStorage.removeItem("Permissions")
        //     localStorage.removeItem("token")
        //     this.$router.push({ name: 'login' })
        //     Fire.$emit('header_nav');

        // }
    }
};