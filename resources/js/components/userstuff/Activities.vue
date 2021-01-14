<template>
<v-app class="bg-transparent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
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
                            <div class="col-lg-8 col-md-12 order-2 order-lg-1">
                                <h1 class="section-title mt-0">{{ fDate.date | tanggal }}</h1>
                                <p class="section-lead" style="line-height: 23px">
                                Silahkan lengkapi kegiatan harian anda, karena ini adalah aspek dalam penghitungan <b>Jasa Pelayanan</b>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-12 order-1 order-lg-2 text-right">
                                <div class="section-tools" style="margin-top:0px">
                                    <template>
                                    <b-form-datepicker class="mr-2"
                                    v-model="fDate.date"
                                    nav-button-variant="success"
                                    button-variant="success"
                                    selected-variant="success"
                                    button-only
                                    right
                                    locale="en-US"
                                    @input="loadActivityByDate"
                                    ></b-form-datepicker>
                                    </template>
                                    <button v-if="plusAct" class="btn btn-success" @click="formAct(); cancelEdit(idEdit)">
                                    <i class="fas fa-plus fa-fw"></i>    Kegiatan</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <transition name="slide-fade">
                                <!-- ini form nya -->
                                <div v-if="formAddAct">
                                    <form @submit.prevent ="bidper ? createActivityBidPer() : createActivity() ">
                                        <div class="activities ml-0">
                                        <div class="activity">
                                            <div class="activity-icon bg-primary text-white shadow-primary">
                                            <i class="fas fa-plus"></i>
                                            </div>
                                            <div class="activity-detail pr-5 pl-5 mb-2" style="width: 100%">
                                                <div class="mb-2">
                                                    <span class="bullet"></span>
                                                    <span class="text-job text-primary">Input Kegiatan Baru</span>
                                                    <div class="float-right dropdown">
                                                        <a @click="formAct()" class="mr-2"><i class="fas fa-times"></i></a>
                                                    </div>
                                                </div>
                                                <v-menu ref="menu" v-model="clock" :close-on-content-click="false" required left
                                                    :return-value.sync="form.jam" transition="slide-y-transition" max-width="290px" min-width="290px">
                                                    <template v-slot:activator="{ on, attrs }" >
                                                        <v-text-field v-model="form.jam" label="Jam Kegiatan" prepend-icon="mdi-clock-time-four-outline"
                                                            readonly v-bind="attrs" v-on="on">
                                                        </v-text-field>
                                                    </template>
                                                    <v-time-picker v-if="clock" v-model="form.jam" full-width @click:minute="$refs.menu.save(form.jam)" format="24hr"></v-time-picker>
                                                </v-menu>
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
                                                    <v-autocomplete v-model="form.kegiatan" @click="loadRkks" required prepend-icon="mdi-clipboard-check" :loading="loadingtext"
                                                        :items="rkks" item-text="kompetensi" item-value="kompetensi" label="Kegiatan"
                                                    ></v-autocomplete>
                                                </template>
                                                <div class="modal-footer">
                                                    <v-btn color="secondary" class="text-capitalize" @click.prevent="formAct">Batal</v-btn>
                                                    <v-btn color="primary" type="submit" class="text-capitalize">Simpan</v-btn>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                    <hr>
                                </div>
                                </transition>
                                <!-- ini activitynya -->
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
                                                <span class="text-job mr-2" :class="{ 'text-primary': act.status === 'Disetujui',
                                                'text-secondary': act.status === 'Menunggu', 'text-danger': act.status === 'Ditolak' }">{{act.status}}</span>
                                            </span>
                                            <span v-show="show" :id="'etitle'+act.id" class="text-job text-primary">Edit Kegiatan</span>
                                            <div class="float-right dropdown">
                                                <a v-show="show" :id="'bsave'+act.id" @click.prevent="bidper ? updateActBidPer(act) : updateAct(act)" class="mr-2"><i class="fas fa-save"></i></a>
                                                <a v-show="show" :id="'bclose'+act.id" @click.prevent="cancelEdit(act.id)" class="mr-1"><i class="fas fa-times"></i></a>
                                                <a v-show="!editmode" href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu dropdown-menu-center">
                                                <div class="dropdown-title">Options</div>
                                                <!-- <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a> -->
                                                <!-- <a href="#" class="dropdown-item has-icon"><i class="fas fa-list"></i> Detail</a> -->
                                                <a type="button" class="dropdown-item has-icon" @click="toggleEdit(act), loadRkks()"><i class="fas fa-pen-square"></i> Change</a>
                                                <a v-if="$gate.isAdmin()" href="#" class="dropdown-item has-icon" @click.prevent="ApproveAct(act)"><i class="fas fa-thumbs-up"></i> Approve</a>
                                                <a v-if="$gate.isAdmin()" href="#" class="dropdown-item has-icon" @click.prevent="DeclineAct(act)"><i class="fas fa-window-close"></i> Decline</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="#" class="dropdown-item has-icon text-danger" @click.prevent="deleteAct(act.id)"><i class="fas fa-trash-alt"></i> Hapus</a>
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
                                                <div class="col-12 col-sm-12 col-md-6 pt-0">
                                                    <v-text-field v-model="form.nama_pasien" label="Nama Pasien" type="text" prepend-icon="mdi-clipboard-account"
                                                    :error-messages="form.errors.errors.nama_pasien" :class="{ 'v-input--has-state error--text': form.errors.has('nama_pasien')}">
                                                    </v-text-field>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-6 pt-0">
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
                                <div class="text-center text-success my-2">
                                    <!-- <span aria-hidden="true" class="align-middle spinner-border" style="width: 3rem; height: 3rem;"></span> -->
                                </div>
                                <v-row v-if="loading" align="center" justify="center" no-gutters style="height: 350px;" >
                                    <v-progress-circular :size="70" :width="7" color="primary" indeterminate ></v-progress-circular>
                                </v-row>
                                <div v-if="empty" style="text-align: center" class="pl-5 pr-5">
                                    <h3><b>There is no Activity</b></h3>
                                    <br>
                                    <img :src="asset('img/setup.svg')" alt="empty" style="width: 70%; height: auto;">
                                </div>
                            </div>
                        </div>



                    </div>
                </section>
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
                test: '',
                plusAct: true,
                nickname: '',
                bidper: false,
                empty: false,
                loading: true,
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
                activities: [],
                rkks: [],
                fDate: new Form ({
                    date:'',
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
            checkDate(){
                var today = parseInt(moment(new Date()).format('DD'));
                var thismonth = parseInt(moment(new Date()).format('MM'));
                if((parseInt(this.fDate.date.substr(-2)) +1) < today){
                    this.plusAct = false;
                }else if((parseInt(this.fDate.date.substr(-2))) > today){
                    this.plusAct = false;
                }else if(parseInt(this.fDate.date.substr(-5, 2)) != thismonth){
                    this.plusAct = false;
                }else{
                    this.plusAct = true;
                }
            },
            toggleLoading(){
                this.loading = false;
                if(this.activities == ""){
                    this.empty = true;
                }
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
                this.form.fill(act);
                this.form.status = 'Disetujui';
                this.form.put("api/apprdecl/"+act.id).then(()=>{
                    this.loadActivityByDate();
                    Swal.fire({
                        icon: 'success',
                        title: 'Aprroved!',
                        // text: 'User berhasil dihapus',
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
            },
            DeclineAct(act){
                this.form.fill(act);
                this.form.status = 'Ditolak';
                this.form.put("api/apprdecl/"+act.id).then(()=>{
                    this.loadActivityByDate();
                    Swal.fire({
                        icon: 'success',
                        title: 'Ditolak!',
                        // text: 'User berhasil dihapus',
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
                this.form.tanggal = this.fDate.date;
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
                    this.loadActivityByDate();
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
            createActivityBidPer(){
                this.form.status = "Menunggu";
                this.form.id_user = this.$parent.userLogin.id;
                this.form.tanggal = this.fDate.date;
                this.$Progress.start();
                this.form.post("api/activitybidper")
                .then(()=>{
                    this.formAddAct = false;
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Kegiatan berhasil ditambah',
                            showConfirmButton: false,
                            timer: 1500,
                        })
                    this.loadActivityByDate();
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
                    this.loadActivityByDate();
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
                    this.loadActivityByDate();
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
                            this.loadActivityByDate();
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
            setToday () {
                this.fDate.date = moment(new Date()).format('YYYY-MM-DD');
            },
            loadRkks() {
                if(this.rkks.length === 0){
                    this.loadingtext = true;
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
            this.loadActivityToday();
            // if(this.$parent.userLogin.bagian === 'Bidang Keperawatan'){
            //     this.loadRkks();
            // }
        },
        mounted() {

        },
        updated(){
            if (this.$parent.userLogin.bagian == 'Bidang Keperawatan') {
                this.bidper = true;
            }
            this.nickname = this.$parent.userLogin.nickname;
            $(function() {
                $("body").getNiceScroll().resize();
                $("body").niceScroll();
                $('.scrollbar-macosx').scrollbar();
            });
        },
        watch: {
            activities : 'toggleLoading',
            'fDate.date' : 'checkDate',
            // users : 'filterTime',
            'rkks' (to, from){
                this.loadingtext = false;
            },
            // 'userLogin' (to, from){
            //     this.formUnit.id_unit = this.userLogin.id_unit;

            // }
        },
    }
</script>
<style>
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
</style>
