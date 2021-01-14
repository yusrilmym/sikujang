<template>
<v-app class="bg-transparent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- v-if="$gate.isSuperAndAdminAndSys()" -->
                <!-- User Section -->
                <section class="section">
                    <div class="section-header">
                    <h1>Jadwal Shift Pegawai</h1>
                    </div>
                </section>
            </div>

            <!-- <div class="col-md-12" v-if="!$gate.isSuperAndAdminAndSys()">
                <not-found></not-found>
            </div> -->
        </div>

        <!-- calendar -->
        <template>
            <v-sheet height="auto">
                <v-toolbar flat dark color="primary">
                    <v-toolbar-title v-if="$vuetify.breakpoint.width >= 600">
                        {{ formDate.date | bulanTahun }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn v-if="$gate.isAdmin() || $gate.isSysDev()" outlined class="mr-4" color="white" @click="addModal">
                        <v-icon dark> mdi-plus </v-icon>
                    </v-btn>
                    <v-btn outlined class="mr-4" color="white" @click="setToday">
                        <v-icon dark small> mdi-calendar-today </v-icon>
                       <span v-if="$vuetify.breakpoint.width >= 600" class="ml-2"> Today </span>
                    </v-btn>
                    <v-menu bottom right>
                        <template v-slot:activator="{ on, attrs }">
                        <v-btn outlined color="white" v-bind="attrs" v-on="on">
                            <span>{{ typeToLabel[type] }}</span>
                            <v-icon right> mdi-menu-down </v-icon>
                        </v-btn>
                        </template>
                        <v-list>
                            <v-list-item @click="type = 'day'">
                                <v-list-item-title>Day</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="type = 'month', filterUnit()">
                                <v-list-item-title>Month</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                    <v-spacer v-if="$vuetify.breakpoint.width <= 600"></v-spacer>
                </v-toolbar>
                <v-row class="mx-2" v-if="$gate.isSAandSYS()">
                    <v-col lg="6" md="12" sm="12" xs="12" cols="12">
                        <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40"
                            transition="scale-transition" offset-y min-width="290px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="formDate.date" label="Pilih tanggal" prepend-icon="mdi-calendar"
                                    readonly v-bind="attrs" v-on="on" hide-details>
                                </v-text-field>
                            </template>
                            <v-date-picker v-model="formDate.date" locale="id" @input="menu = false"></v-date-picker>
                        </v-menu>
                    </v-col>
                    <v-col lg="6" md="12" sm="12" xs="12" cols="12">
                        <form @submit.prevent ="filterUnit()">
                        <v-autocomplete prepend-icon="mdi-city" @change="type === 'day' ? viewDay2() : filterUnit()" v-model="formDate.id_unit" :items="units"
                            item-text="nama_unit" item-value="id" label="Unit" hide-details></v-autocomplete>
                        </form>
                    </v-col>
                </v-row>
                <v-row class="mx-2" v-if="$gate.isAdmin() || $gate.isUser()">
                    <v-col lg="12" md="12" sm="12" xs="12">
                        <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40"
                            transition="scale-transition" offset-y min-width="290px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="formDate.date" label="Pilih tanggal" prepend-icon="mdi-calendar"
                                    readonly v-bind="attrs" v-on="on" hide-details>
                                </v-text-field>
                            </template>
                            <v-date-picker v-model="formDate.date" locale="id" @input="menu = false"></v-date-picker>
                        </v-menu>
                    </v-col>
                </v-row>
            </v-sheet>
            <v-sheet height="600" v-if="type === 'month'">
                <v-calendar ref="calendar" :start="formDate.date" :events="jadwalShift" event-name="fullname"
                event-start="tanggalin" event-end="tanggalout" event-overlap-mode="stack" interval-height="25"
                color="primary" :type="type" locale="id" @click:date="viewDay" @click:more="viewDay" @click:event="editModal">
                </v-calendar>
            </v-sheet>
            <div class="card-body table-responsive-sm p-0 mb-0" v-if="type === 'day'">
                <!-- style="height: 450px" -->
                <v-table class="wrap table table-hover table-bordered text-nowrap bg-white" id="table"
                :data="jadwalShiftDay"
                :filters="filters"
                @totalItemsChanged="totalItem = $event"
                @totalPagesChanged="totalPages = $event">
                <thead slot="head">
                    <tr>
                        <v-th sortKey="fullname">Nama</v-th>
                        <v-th sortKey="tanggalin">Jam Kerja</v-th>
                    </tr>
                </thead>
                <tbody slot="body" slot-scope="{displayData}">
                    <tr role="row" class="b-table-busy-slot" v-if="loading === true">
                        <td colspan="2" role="cell" class="">
                            <div class="text-center text-success my-2">
                                <span aria-hidden="true" class="align-middle spinner-border"></span>
                                <strong>Loading...</strong>
                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="b-table-busy-slot" v-if="totalItem === 0 && loading === false">
                        <td colspan="2" role="cell" class="">
                            <div class="text-center text-success my-2">
                                <strong>Jadwal shift belum ditentukan</strong>
                            </div>
                        </td>
                    </tr>
                    <template v-if="loading === false">
                    <tr v-for="row in displayData" :key="row.id" @click="editModalDay(row)">
                        <td style="width: fit-content">{{row.fullname}}</td>
                        <td style="width: fit-content">{{row.tanggalin | jamMenit}} - {{row.tanggalout | jamMenit}}</td>
                    </tr>
                    </template>
                </tbody>
                </v-table>
            </div>
        </template>

        <!-- Modal Add + Edit-->
        <div class="modal fade" tabindex="-1" id="formJadwal"  data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="exampleModalCenterTitle">Tambah Jadwal Shift</h5>
                        <h5 class="modal-title" v-show="editmode" id="exampleModalCenterTitle">Edit Jadwal Shift</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent ="editmode ? updateJadwal() : createJadwal()">
                    <div class="modal-body">
                        <v-row>
                            <v-col>
                                <v-autocomplete v-model="form.id_user" required prepend-icon="mdi-account" clearable
                                    :items="users" label="Nama pegawai" item-text="fullname" item-value="id" hide-selected
                                    :error-messages="form.errors.errors.id_user" :class="{ 'v-input--has-state error--text': form.errors.has('id_user')}"
                                ></v-autocomplete>
                                <v-autocomplete v-model="form.id_shift" required prepend-icon="mdi-clock-time-four-outline" clearable
                                    :items="shifts" label="Shift" item-text="nama" item-value="id" hide-selected
                                    :error-messages="form.errors.errors.id_shift" :class="{ 'v-input--has-state error--text': form.errors.has('id_shift')}"
                                ></v-autocomplete>
                                <v-menu v-model="menu1" :close-on-content-click="false" :nudge-right="40"
                                    transition="scale-transition" offset-y min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="form.tanggal" label="Pilih tanggal" prepend-icon="mdi-calendar"
                                            readonly v-bind="attrs" v-on="on">
                                        </v-text-field>
                                    </template>
                                    <v-date-picker v-model="form.tanggal" locale="id" @input="menu1 = false"></v-date-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </div>
                    <div class="modal-footer" style="display: flow-root; padding-left: 1.75rem; padding-right: 1.75rem;">
                        <div>
                            <v-btn v-show="editmode" dark color="red" class="text-capitalize float-left" @click="menu1 = false, deleteJadwal()">Delete</v-btn>
                            <div class="text-right">
                                <v-btn color="secondary" data-dismiss="modal" class="text-capitalize" @click="menu1 = false">Batal</v-btn>
                                <v-btn v-show="editmode" color="primary" type="submit" class="text-capitalize" @click="menu1 = false">Update</v-btn>
                                <v-btn v-show="!editmode" color="primary" type="submit" class="text-capitalize" @click="menu1 = false">Simpan</v-btn>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</v-app>
</template>

<script>
import Swal from 'sweetalert2';
    export default {
        // props: ['userLogin'],
        data() {
            return {
                // loginData: this.userLogin,
                selectedEvent: {},
                selectedElement: null,
                search: '',
                modal: false,
                // userLogin: [],
                jadwalShift: [],
                jadwalShiftDay: [],
                menu: false,
                menu1: false,
                type: 'month',
                typeToLabel: {
                    month: 'Month',
                    week: 'Week',
                    day: 'Day',
                    '4day': '4 Days',
                },
                loading: true,
                editmode: false,
                users : [],
                units : [],
                shifts : [],
                positions : [],
                filters: {
                    name: { value: '', keys: ['fullname'] },
                    date: { value: { start: null,  end: null }, custom: this.dateFilter },
                },
                formUnit: new Form ({
                    id_unit : '',
                }),
                formDate: new Form ({
                    date : '',
                    id_unit : '',
                }),
                form: new Form ({
                    id: '',
                    id_user: '',
                    id_shift: '',
                    tanggal: '',
                }),
            }
        },
        methods:{
            //calendar
            // viewDay ({ date }) {
            //     this.formDate.date = date
            //     this.type = 'day'
            // },
            viewDay({ date }) {
                this.formDate.date = date;
                this.type = 'day';
                this.formDate.post('api/schedule/viewday')
                .then(( data ) => (this.jadwalShiftDay = data.data));
            },
            viewDay2(){
                this.loading = true;
                if(this.$gate.isUser()){
                    this.formDate.id_unit = this.$parent.userLogin.id_unit;
                }
                this.formDate.post('api/schedule/viewday')
                .then(( data ) => (this.jadwalShiftDay = data.data));
            },
            setToday () {
                this.formDate.date = moment(new Date()).format('YYYY-MM-DD');
            },
            showEvent ({ nativeEvent, event }) {
                const open = () => {
                    this.selectedEvent = event
                    this.selectedElement = nativeEvent.target
                }
                nativeEvent.stopPropagation()
            },
            filterUnit(){
                this.formDate.post('api/filterunit')
                .then(( data ) => (this.jadwalShift = data.data));
            },
            toggleLoading() {
                this.loading = false;
            },

            scroll(){
                $(function() {
                    $("body").getNiceScroll().resize();
                    $("body").niceScroll();
                    $("#cardtable").getNiceScroll().resize();
                    $(".card").niceScroll();
                });
            },
            reset(){
                this.item = {}
                this.filters.name.value = null;
                this.filters.date.value.start = null;
                this.filters.date.value.end = null ;
            },
            editModal(event){
                if(this.$gate.isAandSYS()){
                    // this.$refs.sp.remove();
                    // console.log(event)
                    this.form.reset();
                    this.form.errors.errors = {};
                    this.editmode = true;
                    this.form.fill(event.event);
                    // this.form.password = '';
                    $('#formJadwal').modal('show');
                }
            },
            editModalDay(row){
                if(this.$gate.isAandSYS()){
                    // this.$refs.sp.remove();
                    // console.log(event)
                    this.form.errors.errors = {};
                    this.form.reset();
                    this.editmode = true;
                    this.form.fill(row);
                    // this.form.password = '';
                    $('#formJadwal').modal('show');
                }
            },
            addModal(){
                // this.$refs.sp.remove();
                if(this.$gate.isAandSYS()){
                    this.editmode = false;
                    this.form.errors.errors = {};
                    this.form.reset();
                    $('#formJadwal').modal('show');
                }
            },
            createJadwal(){
                this.$Progress.start();
                this.form.post('api/schedule')
                .then(()=>{
                    if (this.type === 'month') {
                        this.filterUnit();
                    }else{
                        this.viewDay2();
                    }
                    $('#formJadwal').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Jadwal berhasil ditambah',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                })
                .catch(()=>{
                    this.$Progress.fail()
                })
                this.$Progress.finish();
            },
            updateJadwal(){
                this.$Progress.start();
                this.form.put('api/schedule/'+this.form.id)
                .then(() => {
                    if (this.type === 'month') {
                        this.filterUnit();
                    }else{
                        this.viewDay2();
                    }
                    $('#formJadwal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'User berhasil diupdate',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
            },
            deleteJadwal(){
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "User yang dihapus tidak dapat dikembalikan!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#39af21',
                    confirmButtonText: 'Ya, Hapus saja!'
                }).then((result) => {
                    //send request to the server
                    if (result.value) {
                        $('#formJadwal').modal('hide');
                        this.form.delete('api/schedule/'+this.form.id).then(()=>{
                            if (this.type === 'month') {
                                this.filterUnit();
                            }else{
                                this.viewDay2();
                            }
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'User berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        }).catch(()=>{
                            Swal.fire({
                                icon: 'warning',
                                title: 'Gagal!',
                                text: 'Anda tidak memiliki akses',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        });
                    }
                })
            },

            loadUser(){
                if(this.$gate.isSAandSYS()){
                    this.$Progress.start();
                    this.reset();
                    axios.get("api/user").then(( data ) => (this.users = data.data));
                    this.$Progress.finish();
                }
                if(this.$gate.isAdmin()){
                    this.$Progress.start();
                    this.reset();
                    axios.get("api/userbyunit").then(( data ) => (this.users = data.data));
                    this.$Progress.finish();
                }
            },
            loadSchedule(){
                // this.formUnit.id_unit = this.userLogin.id_unit;
                axios.get("api/schedule").then(( data ) => (this.jadwalShift = data.data));
            },
            // loadUserLogin(){
            //     axios.get("api/profile").then(( data ) => (this.userLogin = data.data));
            // },
            loadUnit(){
                if(this.$gate.isAandSAandSYS()){
                    axios.get("api/unit").then(( data ) => (this.units = data.data));
                }
            },
            loadShift(){
                if(this.$gate.isAandSYS()){
                    axios.get("api/shift").then(( data ) => (this.shifts = data.data));
                }
            },
        }, //end methods
        created(){
            window.scrollTo(0,0);
            this.setToday();
            this.loadUser();
            this.loadSchedule();
            this.loadUnit();
            this.loadShift();
        },
        mounted() {
            // $('.card').css('height', 'auto');

        },
        computed: {
            // rows(){
            //     return this.users.length;
            // },
        },
        updated(){
            // this.formUnit.id_unit = this.$parent.userLogin[0].id_unit;
            $(function() {
                    $("body").getNiceScroll().resize();
                    $("body").niceScroll();
                    $('.scrollbar-macosx').scrollbar();
                    // $(".js-select2").select2({


                    // });
                });

        },
        watch: {
            jadwalShiftDay : 'toggleLoading',
            'users' (to, from){
                this.formDate.id_unit = this.$parent.userLogin.id_unit;
            },
            'formDate.date' (to, from){
                this.viewDay2();
            }
        },

    }//end export default
</script>
