<template>
<v-app class="bg-transparent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="$gate.isAandSAandEXECandSYS() || $gate.isUP()">
                <section class="section">
                    <div class="section-header">
                        <h1>Daftar Kegiatan {{ nickname }}</h1>
                        <!-- <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item">Settings</div>
                        </div> -->
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <h1 class="section-title mt-0">
                                    <template>
                                    <b-form-datepicker class="mr-2"
                                    v-model="formLoadAct.date"
                                    nav-button-variant="success"
                                    button-variant="success"
                                    selected-variant="success"
                                    button-only
                                    left
                                    locale="en-US"
                                    @input="loadActRefresh"
                                    ></b-form-datepicker>
                                    </template> {{ formLoadAct.date | tanggal }}</h1>
                                <p class="section-lead" style="line-height: 23px">

                                Silahkan lengkapi kegiatan harian anda, karena ini adalah aspek dalam penghitungan <b>Jasa Pelayanan</b>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <!-- list pegawai -->
                            <div class="col-12 col-sm-12 col-md-4" v-if="!listUser">
                                <v-btn-toggle style="width: 100%">
                                <v-btn small width="80%" color="primary" @click="toggleCollapse()">
                                    {{ nickname }}
                                </v-btn>
                                <v-btn small width="20%" text @click="toggleCollapse()">
                                    <v-icon>mdi-menu-down</v-icon>
                                </v-btn>
                                </v-btn-toggle>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4" v-if="listUser">
                                <div class="card" style="height: auto; max-height: 400px">
                                    <div class="card-header" v-if="$gate.isSAandSYS()">
                                        <v-autocomplete prepend-icon="mdi-city" @change="filterUnit" v-model="formUnit.id_unit" :items="units"
                                        item-text="nama_unit" item-value="id" label="Unit"></v-autocomplete>
                                    </div>
                                    <!-- hide -->
                                    <div class="pl-6 pr-6 mb-5">
                                        <v-text-field v-model="filters.name.value" prepend-icon="mdi-magnify" label="Search"
                                        single-line hide-details>
                                        </v-text-field>
                                    </div>
                                    <div class="card-body scrollbar-macosx pb-5 pt-0">
                                        <v-table class="wrap table table-striped " id="table"
                                            :data="users"
                                            @totalItemsChanged="totalItem = $event"
                                            :filters="filters">
                                            <tbody slot="body" slot-scope="{displayData}">
                                                <v-row v-if="loadingUser" align="center" justify="center" no-gutters style="height: 100px;" >
                                                    <v-progress-circular :size="50" :width="5" color="primary" indeterminate ></v-progress-circular>
                                                </v-row>
                                                <div class="align-center text-center text-success my-2"  v-if="totalItem === 0 && loadingUser === false">
                                                    <strong>Pegawai tidak ditemukan</strong>
                                                </div>
                                                <template v-if="!loadingUser">
                                                    <tr v-for="row in displayData" :key="row.id">
                                                    <a type="button" class="nav-link shadowno" @click.prevent="loadActbyUserAndDate(row.id), changeNick(row.nickname), toggleCollapse()"
                                                    :class="{'link-active': formLoadAct.id_user == row.id}">{{ row.fullname}} <span v-if="row.role === 'admin'" class="fas fa-check-circle ml-3"></span></a>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </v-table>
                                    </div>
                                    <br>
                                </div>
                            </div>

                            <!-- activity pegawai -->
                            <div class="col">
                                <transition name="slide-fade">
                                <div class="activities ml-0" v-if="!loading">
                                    <div class="activity" v-for="act in activities" :key="act.id">
                                        <div class="activity-icon bg-primary text-white shadow-primary">
                                        <i class="fas fa-comment-alt"></i>
                                        </div>
                                        <div :id="act.id" class="activity-detail act-wd">
                                        <div class="mb-2">
                                            <span :id="'title'+act.id">
                                                <span class="text-job text-primary">{{act.jam}}</span>
                                                <span class="bullet"></span>
                                                <span class="text-job" :class="{ 'text-primary': act.status === 'Disetujui',
                                                'text-secondary': act.status === 'Menunggu', 'text-danger': act.status === 'Ditolak' }">{{act.status}}</span>
                                            </span>
                                            <span v-show="show" :id="'etitle'+act.id" class="text-job text-primary">Edit Kegiatan</span>
                                            <div class="float-right dropdown">
                                                <a v-show="show" :id="'bsave'+act.id" @click.prevent="bidper ? updateActBidPer(act) : updateAct(act)" class="mr-2"><i class="fas fa-save"></i></a>
                                                <a v-show="show" :id="'bclose'+act.id" @click.prevent="cancelEdit(act.id)" class="mr-1"><i class="fas fa-times"></i></a>
                                                <a v-if="$gate.isAdmin() || activities[0].id_user == $parent.userLogin.id || ( $gate.isSuperAdmin() && activities[0].role === 'admin')" v-show="!editmode" href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-center">
                                                    <div class="dropdown-title">Options</div>
                                                    <a type="button" v-if="activities[0].id_user === $parent.userLogin.id" class="dropdown-item has-icon"  @click="toggleEdit(act), loadRkks()"><i class="fas fa-pen-square"></i> Change</a>
                                                    <a v-if="$gate.isAdmin() || ( $gate.isSuperAdmin() && activities[0].role === 'admin')" href="#" class="dropdown-item has-icon" @click.prevent="ApproveAct(act)"><i class="fas fa-thumbs-up"></i> Approve</a>
                                                    <a v-if="$gate.isAdmin() || ( $gate.isSuperAdmin() && activities[0].role === 'admin')" href="#" class="dropdown-item has-icon text-danger" @click.prevent="DeclineAct(act)"><i class="fas fa-window-close"></i> Decline</a>
                                                    <div v-if="activities[0].id_user === $parent.userLogin.id" class="dropdown-divider"></div>
                                                    <a v-if="activities[0].id_user === $parent.userLogin.id" class="dropdown-item has-icon text-danger" @click.prevent="deleteAct(act.id)"><i class="fas fa-trash-alt"></i> Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                        <p v-if="act.nama_pasien !== null" :id="'keg'+act.id" class="mr-3"><v-icon color="primary">mdi-clipboard-account</v-icon> {{act.nama_pasien}} <br>
                                        <v-icon color="primary">mdi-clipboard-plus</v-icon> {{act.mr}}</p>
                                        <hr>
                                        <p :id="'keg'+act.id" class="mr-3">{{act.kegiatan}}</p>
                                        <div :id="'fkeg'+act.id" v-show="show">
                                            <v-text-field v-model="form.jam" label="Jam" type="time" prepend-icon="mdi-clock-time-four-outline"></v-text-field>
                                            <v-text-field v-if="!bidper" v-model="form.kegiatan" label="Kegiatan" type="text" prepend-icon="mdi-form-textbox"></v-text-field>
                                            <template v-if="bidper">
                                            <div class="row">
                                                <div class="col pt-0">
                                                    <v-text-field v-model="form.nama_pasien" label="Nama Pasien" type="text" prepend-icon="mdi-clipboard-account"
                                                    :error-messages="form.errors.errors.nama_pasien" :class="{ 'v-input--has-state error--text': form.errors.has('nama_pasien')}">
                                                    </v-text-field>
                                                </div>
                                                <div class="col pt-0">
                                                    <v-text-field v-model="form.mr" label="Nomor MR" type="number" prepend-icon="mdi-clipboard-plus"
                                                    :error-messages="form.errors.errors.mr" :class="{ 'v-input--has-state error--text': form.errors.has('mr')}">
                                                    </v-text-field>
                                                </div>
                                            </div>
                                            <v-autocomplete v-model="form.kegiatan" required prepend-icon="mdi-clipboard-check" :loading="loadingtext"
                                                :items="rkks" item-text="kompetensi" item-value="kompetensi" label="Kegiatan"
                                            ></v-autocomplete>
                                            </template>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </transition>
                                <transition name="slide-fade">
                                <div v-if="first" style="text-align: center" class="pl-5 pr-5">
                                    <h3><b>Silahkan Pilih Pegawai</b></h3>
                                    <br>
                                    <img :src="asset('img/setup.svg')" alt="empty" style="width: 90%; height: auto;">
                                </div>
                                </transition>
                                <transition name="slide-fade">
                                <div v-if="empty" style="text-align: center" class="pl-5 pr-5">
                                    <h3><b>There is no Activity</b></h3>
                                    <br>
                                    <img :src="asset('img/setup.svg')" alt="empty" style="width: 80%; height: auto;">
                                </div>
                                </transition>
                                <transition name="slide-fade-load">
                                <v-row v-if="loading" align="center" justify="center" no-gutters style="height: 500px;" >
                                    <v-progress-circular :size="70" :width="7" color="primary" indeterminate ></v-progress-circular>
                                </v-row>
                                </transition>
                            </div>
                        </div>



                    </div>
                </section>
            </div>

            <div class="col-md-12" v-if="!$gate.isAandSAandEXECandSYS() && !$gate.isUP()">
                <not-found-page></not-found-page>
            </div>
        </div>
    </div>
</v-app>
</template>

<script>
import Swal from 'sweetalert2';
    export default {
        data() {
            return {
                listUser: true,
                bidper: false,
                users:[],
                units:[],
                nickname: '',
                empty: false,
                first: false,
                loading: true,
                loadingUser: true,
                loadingtext : false,
                idEdit: null,
                show: false,
                formAddAct: false,
                clock: false,
                clock2: false,
                menu: false,
                editmode: false,
                search: '',
                modal: false,
                totalItem: 0,
                activities: [],
                rkks: [],
                filters: {
                    name: { value: '', keys: ['fullname'] },
                },
                formLoadAct: new Form ({
                    id_user : '',
                    date : '',
                }),
                formUnit: new Form ({
                    id_unit : '',
                }),
                form: new Form ({
                    id:'',
                    id_user: '',
                    kegiatan : '',
                    nama_pasien : null,
                    mr : null,
                    status : '',
                    jam : null,
                    tanggal : null,
                }),
            }
        },
        methods:{
            toggleCollapse(){
                if(this.$vuetify.breakpoint.width <= 600){
                    if (this.listUser == true) {
                        this.listUser = false;
                    }else{
                        this.listUser = true;
                    }
                }else{
                    this.listUser = true;
                }
            },
            changeNick(name){
                this.nickname = name;
            },
            filterUnit(){
                this.loadingUser = true;
                this.first = true;
                this.empty = false;
                this.activities = null;
                this.formUnit.post('api/alluserbyunit')
                .then(( data ) => (this.users = data.data));
            },
            toggleLoading(){
                this.loading = false;
                if(this.activities == ""){
                    this.empty = true;
                }
            },
            toggleLoadingU(){
                this.loadingUser = false;
            },
            cancelEdit(id){
                this.editmode = false;
                $('#'+id).removeClass("act-edit");
                $('#fkeg'+id).hide();
                $('#bsave'+id).hide();
                $('#bclose'+id).hide();
                $('#etitle'+id).hide();
                $('#keg'+id).show();
                $('#title'+id).show();
            },
            toggleEdit(act){
                this.form.fill(act);
                this.idEdit = act.id;
                this.editmode = true;
                // document.getElementById(id).classList.add('act-edit');
                $('#'+act.id).addClass("act-edit");
                $('#fkeg'+act.id).show();
                $('#bsave'+act.id).show();
                $('#bclose'+act.id).show();
                $('#etitle'+act.id).show();
                $('#keg'+act.id).hide();
                $('#title'+act.id).hide();
            },
            ApproveAct(act){
                this.$Progress.start();
                this.form.fill(act);
                this.form.status = 'Disetujui';
                this.form.put("api/apprdecl/"+act.id).then(()=>{
                    this.loadActRefresh();
                    Swal.fire({
                        icon: 'success',
                        title: 'Aprroved!',
                        // text: 'User berhasil dihapus',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.$Progress.finish();
                }).catch(()=>{
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Something went wrong',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.$Progress.fail();
                });
            },
            DeclineAct(act){
                this.$Progress.start();
                this.form.fill(act);
                this.form.status = 'Ditolak';
                this.form.put("api/apprdecl/"+act.id).then(()=>{
                    this.loadActRefresh();
                    Swal.fire({
                        icon: 'success',
                        title: 'Ditolak!',
                        // text: 'User berhasil dihapus',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.$Progress.finish();
                }).catch(()=>{
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Something went wrong',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.$Progress.fail();
                });
            },
            formAct(){
                if(this.formAddAct === false){
                    this.formAddAct = true;
                    this.form.reset();
                    this.form.jam = moment(new Date()).format('HH:mm');
                }else{
                    this.formAddAct = false;
                }
            },
            createActivity(){
                this.form.status = "Menunggu";
                this.form.id_user = this.$parent.userLogin.id;
                this.form.tanggal = this.formLoadAct.date;
                this.$Progress.start();
                this.form.post("api/activity")
                .then(()=>{
                    this.formAddAct = false;
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Kegiatan berhasil ditambah',
                            showConfirmButton: false,
                            timer: 1500,
                        })
                    this.loadActRefresh();
                    this.$Progress.finish();
                    this.form.reset();
                })
                .catch(()=>{
                    this.$Progress.fail()
                    Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Kayaknya ada yang salah deh!',
                            showConfirmButton: false,
                            timer: 1500,
                        })
                })
            },
            updateAct(){
                this.form.id_user = this.$parent.userLogin.id;
                this.$Progress.start();
                this.form.put("api/activity/"+this.form.id)
                .then(()=>{
                    this.formAddAct = false;
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Kegiatan berhasil diupdate',
                            showConfirmButton: false,
                            timer: 1500,
                        })
                        this.cancelEdit(this.form.id)
                    this.loadActRefresh();
                    this.$Progress.finish();
                    this.form.reset();
                })
                .catch(()=>{
                    this.$Progress.fail()
                    Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Kayaknya ada yang salah deh!',
                            showConfirmButton: false,
                            timer: 1500,
                        })
                })
            },
            updateActBidPer(){
                this.form.id_user = this.$parent.userLogin.id;
                this.$Progress.start();
                this.form.put("api/activitybidperedit")
                .then(()=>{
                    this.formAddAct = false;
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Kegiatan berhasil diupdate',
                            showConfirmButton: false,
                            timer: 1500,
                        })
                        this.cancelEdit(this.form.id)
                    this.loadActRefresh();
                    this.$Progress.finish();
                    this.form.reset();
                })
                .catch(()=>{
                    this.$Progress.fail()
                    Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Kayaknya ada yang salah deh!',
                            showConfirmButton: false,
                            timer: 1500,
                        })
                })
            },
            deleteAct(id){
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Kegiatan yang dihapus tidak dapat dikembalikan!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#39af21',
                    confirmButtonText: 'Ya, Hapus saja!'
                }).then((result) => {
                    //send request to the server
                    if (result.value) {
                        this.form.delete('api/activity/'+id).then(()=>{
                            this.loadActRefresh();
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'User berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        }).catch(()=>{
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Something went wrong',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        });
                    }
                })
            },
            setToday() {
                this.formLoadAct.date = moment(new Date()).format('YYYY-MM-DD');
            },
            loadUnit(){
                if(this.$gate.isSuperAdmin()){
                    axios.get("api/unitbybagian").then(( data ) => (this.units = data.data));
                }
                if(this.$gate.isSysDev() || this.$gate.isUP()){
                    axios.get("api/unit").then(( data ) => (this.units = data.data));
                }
            },
            loadUser(){
                this.$Progress.start();
                this.loadingUser = true;
                axios.get("api/userbyunit").then(( data ) => (this.users = data.data));
                this.first = true;
                this.loading = false;
                this.$Progress.finish();
            },
            loadActbyUserAndDate(id){
                this.editmode = false;
                this.loading = true;
                this.empty = false;
                this.first = false;
                this.formLoadAct.id_user = id;
                this.formLoadAct.post("api/activity/byuserdate").then(( data ) => (this.activities = data.data));
            },
            loadActRefresh(){
                this.loading = true;
                this.empty = false;
                this.first = false;
                this.formLoadAct.post("api/activity/byuserdate").then(( data ) => (this.activities = data.data));
            },
            loadRkks() {
                if (this.bidper == true) {
                    axios.get("api/rkk").then(( data ) => (this.rkks = data.data));
                }
            },
            loadActivityToday(){
                // if(this.$gate.isSuperAndAdminAndSys()){
                    axios.get("api/activity").then(( data ) => (this.activities = data.data));
                // }
            },
            loadActivityByDate(){
                // this.activities = undefined;
                this.loading = true;
                this.empty = false;
                this.fDate.post("api/activity/bydate").then(( data ) => (this.activities = data.data));
            },
            editModal(shifts){
                this.editmode = true;
                this.form.reset();
                $('#formActivity').modal('show');
                this.form.fill(shifts);
                this.clock();
            },
            addModal(){
                this.editmode = false;
                this.form.reset();
                this.namaUnit = null;
                this.shift = '';
                $('#formActivity').modal('show');
            },

        },
        created(){
            this.setToday();
            this.loadUnit();
            this.loadUser();
            // this.loadActivityToday();
            // this.loadRkks();
        },
        mounted() {
            // console.log('Component mounted.')
        },
        updated(){
            // this.formUnit.id_unit = this.$parent.userLogin.id_unit;
            if (this.$parent.userLogin.bagian == 'Bidang Keperawatan') {
                this.bidper = true;
            }
            if (this.$vuetify.breakpoint.width >= 600) {
                $(function() {
                    $("body").getNiceScroll().resize();
                    $("body").niceScroll({
                        cursorcolor:"#004E1E",
                        background:"rgba(20,20,20,0.3)",
                        cursorborder:"0px",
                        cursorborderradius:0,
                        cursorwidth:"7px"});
                    $('.scrollbar-macosx').scrollbar();
                });
            }else{
                $(function() {
                    $("body").getNiceScroll().resize();
                    $("body").niceScroll({
                        cursorborder:"0px",
                        cursorcolor:"rgba(20,20,20,0)"});
                    $('.scrollbar-macosx').scrollbar();
                });
            }
        },
        watch: {
            activities : 'toggleLoading',
            // users : 'filterTime',
            'users' (to, from){
                this.formUnit.id_unit = this.users[0].id_unit;
                this.toggleLoadingU();
            }
        },
    }
</script>
<style>
/* .link-activity:hover{
    background-color: rgb(228, 228, 228) !important;
} */
.shadowno{
    box-shadow: none !important;
}
.link-active{
    background-color: #39af21 !important;
    color: white !important;
    border-radius: 5px;
}

.b-form-datepicker .dropdown-menu{
    width: fit-content !important;
}
.act-wd{
    min-width: 20%;
    max-width: 80%;
    border-radius: 6px !important;
}
.act-edit{
    width: 100%;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active di bawah versi 2.1.8 */ {
  opacity: 0;
}
.slide-fade-enter-active {
  transition: all .5s ease;
}
.slide-fade-leave-active {
  transition: all .2s ease;
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active di bawah versi 2.1.8 */ {
  transform: translateY(-20px);
  opacity: 0;
}
.slide-fade-load-enter-active {
  transition: all .6s ease;
}
.slide-fade-load-leave-active {
  transition: all .6s ease;
}
.slide-fade-load-enter, .slide-fade-load-leave-to
/* .slide-fade-leave-active di bawah versi 2.1.8 */ {
  transform: translateY(30px);
  opacity: 0;
}
</style>
