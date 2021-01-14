<template>
<v-app class="bg-transparent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="$parent.userLogin.bagian === 'Keuangan' || $gate.isSysDev()">
                <section class="section">
                    <div class="section-header">
                        <h1>Laporan Bulanan Pegawai</h1>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <v-menu v-model="datepicker" :close-on-content-click="false" :nudge-right="40"
                                transition="scroll-y-transition" offset-y min-width="290px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-toolbar-title style="font-weight: bold" v-bind="attrs" v-on="on">
                                        <v-btn icon color="primary" tile>
                                            <v-icon dark> mdi-calendar </v-icon>
                                        </v-btn>
                                        {{ formReport.date | bulanTahun }}
                                    </v-toolbar-title>
                                </template>
                                <v-date-picker no-title type="month" v-model="formReport.date" locale="id" @input="datepicker = false" @change="loadUser(), resetReport()"></v-date-picker>
                            </v-menu>
                        </div>
                        <div class="col text-right" v-if="allMReports.length !== 0">
                                <v-btn color="primary" :icon="$vuetify.breakpoint.width <= 600" :tile="$vuetify.breakpoint.width <= 600">
                                    <download-excel :data="allMReports" :name="filexl" :fields="kolom">
                                    <v-icon :left="$vuetify.breakpoint.width >= 600" class="fas fa-file-excel"></v-icon>
                                        <span v-if="$vuetify.breakpoint.width >= 600"> Export </span>
                                        <!-- <span v-if="$vuetify.breakpoint.width <= 600"> </span> -->
                                    </download-excel>
                                </v-btn>
                        </div>
                    </div>
                    <template>
                        <div class="row">
                        <div class="col-12">
                            <div class="card mb-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col pt-0 pb-0 pr-0">
                                        <v-autocomplete v-model="formReport.id_user" clearable outlined dense hide-details :loading="loadingtext" :disabled="loadingtext"
                                            :items="users" label="Pilih Pegawai" item-text="fullname" item-value="id_user" hide-selected @change="LoadReportByUserDate()"
                                            :error-messages="formReport.errors.errors.id_user" :class="{ 'v-input--has-state error--text': formReport.errors.has('id_user')}"
                                        ></v-autocomplete>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </template>
                    <div class="row">
                    <div class="col pt-0" style="min-height: 400px">
                    <transition name="fade">
                        <v-row v-if="loading" align="center" justify="center" no-gutters style="height: 500px;" class="absolute-center">
                            <v-progress-circular :size="70" :width="7" color="primary" indeterminate ></v-progress-circular>
                        </v-row>
                    </transition>
                    <template v-if="!loading && !first">
                        <transition name="slide-fade">
                            <v-card  class="mt-5 pl-4 pr-4" flat style="border-bottom: solid 4px #39af21">
                                <v-card-text class="h6 text-right pb-0">
                                    {{reports[0].created_at | tanggal}}
                                </v-card-text>
                                <v-card-title style="font-weight: bold">Plan</v-card-title>
                                <v-card-text class="h6 text-justify">
                                    {{reports[0].plan}}
                                </v-card-text>
                                <v-divider class="mx-4 mt-0 mb-0"></v-divider>
                                <v-card-title style="font-weight: bold">Do</v-card-title>
                                <v-card-text v-cloak class="h6 text-justify">
                                    {{reports[0].do}}
                                </v-card-text>
                                <v-divider class="mx-4 mt-0 mb-0"></v-divider>
                                <v-card-title style="font-weight: bold">Check</v-card-title>
                                <v-card-text v-cloak class="h6 text-justify">
                                    {{reports[0].check}}
                                </v-card-text>
                                <v-divider class="mx-4 mt-0 mb-0"></v-divider>
                                <v-card-title style="font-weight: bold">Action</v-card-title>
                                <v-card-text v-cloak class="h6 text-justify">
                                    {{reports[0].action}}
                                </v-card-text>
                            </v-card>
                        </transition>
                        <br>
                        <transition name="slide-fade">
                            <div class="row">
                                <div class="col">
                                    <div class="card-body pt-0" v-if="reports[0].catatan !== null && reports[0].catatan !== ''">
                                        <h2 class="section-title mt-0 mb-3">Catatan</h2>
                                        <p class="text-justify">{{reports[0].catatan}}</p>
                                    </div>
                                </div>
                                <div class="col col-4 text-center h6" v-if="reports[0].status !== 'Menunggu'">
                                    <p>Cibinong, {{reports[0].checkdate | dmy}} <br> Direktur RSUD Cibinong, Kabupaten Bogor </p>
                                    <img :src="asset('img/ttd-direktur.svg')" alt="tanda tangan" style="height: 100px; width: 100%">
                                    <p><b> dr. Wahyu Eko Widiharso, Sp.OT., MARS </b><br>NIP. 19640211 199001 1001</p>
                                </div>
                            </div>
                        </transition>
                    </template>

                    <transition name="slide-fade">
                    <div v-if="first" style="text-align: center" class="pl-5 pr-5">
                        <h3 style="margin-bottom: 50px; margin-top: 50px"><b>Silahkan Pilih Pegawai</b></h3>
                        <img :src="asset('img/undraw_pos.svg')" alt="empty" style="width: 50%; height: auto;">
                    </div>
                    </transition>

                    </div>
                    </div>
                </section>

            </div>

            <div class="col-md-12" v-cloak v-if="$parent.userLogin.bagian !== 'Keuangan' && !$gate.isSysDev()">
                <not-found-page></not-found-page>
            </div>

        </div>

        <!-- Modal Add + Edit-->
        <div class="modal fade" tabindex="-1" id="formReport" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="exampleModalCenterTitle">Setujui Laporan {{form.fullname}} </h5>
                        <h5 class="modal-title" v-show="editmode" id="exampleModalCenterTitle">Edit Catatan Laporan {{form.fullname}} </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent ="editmode ? editApproveReport() : approveReport()">
                    <div class="modal-body">
                        <v-row>
                            <v-col>
                                <v-textarea clearable clear-icon="mdi-close-circle" rows="1" auto-grow v-model="form.catatan" label="Catatan" prepend-icon="mdi-note" type="text"
                                    :error-messages="form.errors.errors.catatan" :class="{ 'v-input--has-state error--text': form.errors.has('catatan')}">
                                </v-textarea>
                            </v-col>
                        </v-row>
                    </div>
                    <div class="modal-footer" style="display: flow-root; padding-left: 1.75rem; padding-right: 1.75rem;">
                        <div>
                            <div class="text-right">
                            <v-btn color="secondary" data-dismiss="modal" class="text-capitalize" @click="date1 = false, date2 = false">Batal</v-btn>
                            <v-btn v-show="editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false"
                            v-shortkey.focus="['ctrl', 'enter']" @shortkey="editApproveReport()">Update</v-btn>
                            <v-btn v-show="!editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false"
                            v-shortkey.focus="['ctrl', 'enter']" @shortkey="approveReport()">Setujui</v-btn>
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
        data() {
          return {
                datepicker: false,
                filexl: '',
                edit: false,
                first: true,
                bulan: null,
                menu1: false,
                users: [],
                reports: [],
                allMReports: [],
                kolom:{
                    "Nama" : "fullname",
                    "tanggal dibuat" : "created_at",
                    "tanggal disetujui" : "checkdate"
                },
                editmode: false,
                pnsmode: false,
                loadingtext : false,
                loading: false,
                currentPage: 1,
                totalPages: 0,
                totalItem: 0,
                pagination: 5,
                filters: {
                    name: { value: '', keys: ['jabatan'] }
                },
                formReport: new Form({
                    date: '',
                    id_user: '',
                    filter: 'filter',
                }),
                form: new Form ({
                    id:'',
                    id_user : '',
                    plan : '',
                    do : '',
                    check : '',
                    action : '',
                    date : '',
                    catatan:'',
                    checkdate: '',
                    fullname: '',
                    status: '',
                    created_at: '',
                })
                // currentPhoto:"",
            }
        },
        methods:{
            namaFIle(){
                this.filexl = 'Laporan Bulan '+moment(this.formReport.date).format('MMMM YYYY');
            },
            setMonthFirst(){
                this.formReport.date = moment(new Date()).format('YYYY-MM');
            },
            showMonth(){
                this.bulan = moment(this.form.date).format('MMMM YYYY');
            },
            setMonth(){
                this.form.date = moment(this.form.date).format('YYYY-MM-DD');
            },
            toggleLoading(){
                this.loading = false;
            },
            toggleLoadingText(){
                this.loadingtext = false;
            },
            reset(){
                this.filters.name.value = '';
            },
            scroll(){
                $(function() {
                    $("body").getNiceScroll().resize();
                    $("body").niceScroll();
                });
            },
            editModal(reports){
                this.editmode = true;
                this.form.errors.errors = {};
                this.form.reset();
                $('#formReport').modal('show');
                this.form.fill(reports);
            },
            addModal(reports){
                this.editmode = false;
                this.form.errors.errors = {};
                this.form.reset();
                $('#formReport').modal('show');
                this.form.fill(reports);
            },
            approveReport(){
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Laporan yang telah disetujui tidak dapat dirubah!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#39af21',
                    confirmButtonText: 'Ya, Setujui!'
                }).then((result) => {
                    $('#formReport').modal('hide');
                    if (result.value) {
                        this.$Progress.start();
                        this.$Progress.start();
                        this.form.status = 'Disetujui';
                        this.form.checkdate = moment(new Date()).format('YYYY-MM-DD');
                        this.form.put('api/report/'+this.form.id)
                        .then(()=>{
                            this.LoadReportByUserDate();
                            $('#formReport').modal('hide')
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Laporan berhasil disetujui',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        })
                        .catch(()=>{
                            this.$Progress.fail()
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps!',
                                text: 'Sepertinya ada yang salah',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        })
                        this.$Progress.finish();
                    }
                })
            },
            editApproveReport(){
                this.$Progress.start();
                this.form.status = 'Disetujui';
                this.form.put('api/report/'+this.form.id)
                .then(()=>{
                    this.LoadReportByUserDate();
                    $('#formReport').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Laporan berhasil disetujui',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                })
                .catch(()=>{
                    this.$Progress.fail()
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps!',
                        text: 'Sepertinya ada yang salah',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                })
                this.$Progress.finish();
            },
            deleteReport(){
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Laporan yang dihapus tidak dapat dikembalikan!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#39af21',
                    confirmButtonText: 'Ya, Hapus saja!'
                }).then((result) => {
                    $('#formReport').modal('hide');
                    if (result.value) {
                        this.$Progress.start();
                        this.form.delete('api/report/'+this.form.id).then(()=>{
                            this.LoadReportByUserDate();
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'Laporan berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                            this.$Progress.finish();
                        }).catch(()=>{
                            this.$Progress.fail();
                            Swal.fire({
                                icon: 'warning',
                                title: 'Gagal!',
                                text: 'Sepertinya ada yang salah, silahkan coba lagi',
                                showConfirmButton: true,
                            })
                        });
                    }
                })
            },
            resetReport(){
                this.formReport.id_user = undefined;
                this.reports = [];
                this.first = true;
            },
            LoadReportByUserDate(){
                if (this.formReport.id_user === undefined) {
                    this.reports = [];
                    this.loading = false;
                    this.first = true;
                }else{
                    this.first = false;
                    this.loading = true;
                    this.formReport.post("api/report/exec/getbyuserdate").then(( data ) => (this.reports = data.data));
                }
            },
            LoadReportByDate(){
                this.loadingtext = false;
                if(this.users.length !== 0){
                    this.formReport.post("api/report/exec/getallbydate").then(( data ) => (this.allMReports = data.data));
                }
            },
            loadUser(){
                this.loadingtext = true;
                this.formReport.post("api/report/exec/usersudah").then((data) => (this.users = data.data));
            }


        }, //end methods
        created(){
            $('#formReport').modal('hide');
            window.scrollTo(0,0);
            this.setMonthFirst();
            this.loadUser();
            // this.loadReport();
        },
        mounted(){

        },
        updated(){
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
            users : 'LoadReportByDate',
            reports : 'toggleLoading',
            'form.date' (to, from){
                this.showMonth();
            },
            'formReport.date' (to, from){
                this.namaFIle();
            },
        },


    }//end export default
</script>
<style>
.absolute-center{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.absolute-icon{
    position: absolute;
    top: 50%;
    left: 22%;
    transform: translate(-50%, -50%);
}
.text-justify{
    text-align: justify;
    text-justify: inter-word;
}
</style>
