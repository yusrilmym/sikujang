<template>
    <v-app class="bg-transparent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="$gate.isSAandSYS() || $gate.isUP()">
                <!-- shift Section -->
                <section class="section">
                    <div class="section-header">
                    <h1>Waktu Shift</h1>
                    </div>
                    <!-- <div class="section-tools">
                        <div class="row">
                            <div class="col-lg-8 col-md-12 col-sm-12 col-12 mb-2">
                                <div class="input-group">
                                    <select class="custom-select col-4" id="filter" v-model="filters.name.keys[0]" title="Filter By" @change="reset">
                                        <option value="nama">Nama Shift</option>
                                    </select>
                                    <input type="search" class="form-control" v-model="filters.name.value" placeholder="type to search">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12 col-12 mb-2 text-right">
                                <button class="btn btn-success" style="border-radius: 30px;" @click="addModal">
                                <i class="fas fa-plus fa-fw"></i>    Tambah Shift</button>
                            </div>
                        </div>
                    </div> -->
                    <!-- card -->
                    <!-- <div class="card"  style="height: auto">
                        <div class="card-body table-responsive table-invoice p-0" >
                            <v-table class="wrap table table-striped tableFixHead table-hover text-nowrap" id="table"
                            :data="shifts"
                            :currentPage.sync="currentPage"
                            :pageSize="pagination"
                            :filters="filters"
                            @totalItemsChanged="totalItem = $event"
                            @totalPagesChanged="totalPages = $event">
                            <thead slot="head">
                                <tr>
                                    <v-th sortKey="nama">Nama Shift</v-th>
                                    <v-th sortKey="in">In</v-th>
                                    <v-th sortKey="out">Out</v-th>
                                    <v-th sortKey="updated_at" defaultSort="desc">Action</v-th>
                                </tr>
                            </thead>
                            <tbody slot="body" slot-scope="{displayData}">
                                <tr role="row" class="b-table-busy-slot" v-if="loading === true">
                                    <td colspan="4" role="cell" class="">
                                        <div class="text-center text-success my-2">
                                            <span aria-hidden="true" class="align-middle spinner-border"></span>
                                            <strong>Loading...</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="b-table-busy-slot" v-if="totalItem === 0 && loading === false">
                                    <td colspan="4" role="cell" class="">
                                        <div class="text-center text-success my-2">
                                            <strong>Shift tidak ditemukan</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-for="row in displayData" :key="row.id">
                                <td>{{row.nama}}</td>
                                <td>{{row.in}}</td>
                                <td>{{row.out}}</td>
                                <td hidden>{{row.updated_at}}</td>
                                <td>
                                    <div class="btn-group btn-group">
                                        <a href="#" @click="editModal(row)" class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                        title="Edit"><i class="fas fa-pen"></i></a>

                                        <a href="#" @click="deleteshift(row.id)" class="btn btn-danger" data-toggle="tooltip" data-placement="top"
                                        title="Delete"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                            </v-table>
                        </div>
                        <div class="card-footer" style="padding: 10px 30px 10px 25px !important">
                            <div class="row">
                                <div class="col">
                                    <label for="pagination">show</label>
                                    <select class="form-control-sm" v-model.number="pagination" type="number" style="width: 60px" @change="scroll">
                                        <option>5</option>
                                        <option>50</option>
                                        <option :value="shifts.length">all</option>
                                    </select>
                                    from {{ totalItem }}
                                </div>
                                <smart-pagination :currentPage.sync="currentPage" :totalPages="totalPages" :maxPageLinks="4" />
                            </div>
                        </div>
                    </div> -->
                </section>
            </div>

            <div class="col-md-12" v-if="!$gate.isSAandSYS() && !$gate.isUP()">
                <not-found-page></not-found-page>
            </div>

        </div>
        <!-- table vuetify -->
        <template v-if="$gate.isSAandSYS() || $gate.isUP()">
            <v-data-table
                fixed-header

                :headers="[
                    {text: 'Nama Shift', value: 'nama'},
                    {text: 'Jam Masuk', value: 'in'},
                    {text: 'Jam Pulang', value: 'out'},
                    {text: 'Actions', value: 'actions', sortable: false},
                ]"
                :items="shifts"
                :search="search"
                sort-by="nama"
                class="elevation-1"
            >
                <template v-slot:top>
                <v-toolbar flat color="primary" dark height="auto">
                    <v-row>
                        <v-col cols="12" md="3" xs="12">
                            <v-toolbar-title>Shift</v-toolbar-title>
                        </v-col>
                        <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
                        <v-col cols="12" md="6" xs="12">
                            <v-text-field v-model="search" append-icon="mdi-magnify" label="Search"
                                single-line hide-details>
                            </v-text-field>
                        </v-col>
                        <!-- <v-divider class="mx-4" inset vertical></v-divider> -->
                        <v-col cols="12" md="3" xs="12">
                            <!-- <v-spacer></v-spacer> -->
                            <div class="text-right">
                                <v-btn outlined color="white" @click="addModal">
                                    Tambah shift
                                </v-btn>
                            </div>
                        </v-col>
                    </v-row>
                </v-toolbar>
                </template>
                <template v-slot:item.actions="row">
                    <v-btn icon color="success" @click="editModal(row.item)">
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-btn icon color="red" @click="deleteshift(row.item.id)">
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </template>
                <template v-slot:no-data>

                </template>
            </v-data-table>
        </template>

         <!-- Modal Add + Edit-->
        <div class="modal fade" tabindex="-1" id="formshift" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="exampleModalCenterTitle">Tambah Shift Baru</h5>
                        <h5 class="modal-title" v-show="editmode" id="exampleModalCenterTitle">Update Data Shift</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <v-app>
                    <form @submit.prevent ="editmode ? updateshift() : createShift()">
                    <div class="modal-body">
                        <v-row>
                            <v-col>
                                <v-text-field v-model="form.nama" label="Nama Shift" prepend-icon="mdi-form-textbox" required type="text"
                                    :error-messages="form.errors.errors.nama" :class="{ 'v-input--has-state error--text': form.errors.has('nama')}">
                                </v-text-field>
                                <v-menu ref="menu" v-model="date1" :close-on-content-click="false" required
                                    :return-value.sync="form.in" transition="slide-y-transition" offset-y max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="form.in" label="Jam Masuk" prepend-icon="mdi-clock-time-four-outline"
                                            readonly v-bind="attrs" v-on="on">
                                        </v-text-field>
                                    </template>
                                    <v-time-picker v-if="date1" v-model="form.in" full-width @click:minute="$refs.menu.save(form.in)" format="24hr"></v-time-picker>
                                </v-menu>
                                <v-menu ref="menu2" v-model="date2" :close-on-content-click="false" required
                                    :return-value.sync="form.out" transition="slide-y-transition" offset-y max-width="290px" min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="form.out" label="Jam Pulang" prepend-icon="mdi-clock-time-four-outline"
                                            readonly v-bind="attrs" v-on="on">
                                        </v-text-field>
                                    </template>
                                    <v-time-picker v-if="date2" v-model="form.out" full-width @click:minute="$refs.menu2.save(form.out)" format="24hr"></v-time-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <v-btn color="secondary" data-dismiss="modal" class="text-capitalize" @click="date1 = false, date2 = false">Batal</v-btn>
                            <v-btn v-show="editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false">Update</v-btn>
                            <v-btn v-show="!editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false">Simpan</v-btn>
                        </div>
                    </div>
                    </form>
                    </v-app>
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
                search: '',
                date1: false,
                date2: false,
                loading: true,
                editmode: false,
                units: [],
                shift: '',
                namaUnit: null,
                shifts : [],
                currentPage: 1,
                totalPages: 0,
                totalItem: 0,
                pagination: 5,
                filters: {
                    name: { value: '', keys: ['nama'] }
                },
                form: new Form ({
                    id:'',
                    nama : '',
                    in: '',
                    out: '',
                }),
                dataUnit(node) {
                    return {
                        id: node.nama_unit,
                        label: node.nama_unit,
                    }
                },
                // currentPhoto:"",
            }
        },
        methods:{
            loadUnit(){
                if(this.$gate.isSAandSYS() || this.$gate.isUP()){
                    axios.get("api/unit").then(( data ) => (this.units = data.data));
                }
            },
            toggleLoading() {
                this.loading = false;
            },
            namaShift(){
                this.form.nama = this.shift+'-'+this.namaUnit;
            },
            clock(){
                this.form.in = this.form.in.substr(0, 5);
                this.form.out = this.form.out.substr(0, 5);
            },
            reset(){
                this.filters.name.value = '';
            },
            scroll(){
                $('.card').css('height', 'auto');
                $(function() {
                    $("body").getNiceScroll().resize();
                    $("body").niceScroll();
                });
            },
            updateshift(){
                this.$Progress.start();
                this.form.put('api/shift/'+this.form.id)
                .then(() => {
                    this.loadShift();
                    $('#formshift').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Waktu shift berhasil diupdate',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
            },
            editModal(shifts){
                this.editmode = true;
                this.form.reset();
                this.form.errors.errors = {};
                $('#formshift').modal('show');
                this.form.fill(shifts);
                this.clock();
            },
            addModal(){
                this.editmode = false;
                this.form.reset();
                this.form.errors.errors = {};
                this.namaUnit = null;
                this.shift = '';
                $('#formshift').modal('show');
            },

            deleteshift(id){
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Waktu shift yang dihapus tidak dapat dikembalikan!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#39af21',
                    confirmButtonText: 'Ya, Hapus saja!'
                }).then((result) => {
                    //send request to the server
                    if (result.value) {
                        this.form.delete('api/shift/'+id).then(()=>{
                            this.loadShift();
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'Waktu shift berhasil dihapus',
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

            loadShift(){
                if(this.$gate.isSAandSYS() || this.$gate.isUP()){
                    this.$Progress.start();
                    axios.get("api/shift").then(( data ) => (this.shifts = data.data));
                    this.$Progress.finish();
                }
            },
            createShift(){
                this.$Progress.start();
                this.form.post('api/shift')
                .then(()=>{
                    this.loadShift();
                    $('#formshift').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Shift berhasil ditambah',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                })
                .catch(()=>{
                    this.$Progress.fail()
                })
                this.$Progress.finish();
            },

        }, //end methods
        created() {
            this.loadShift();
            this.loadUnit();
        },
        mounted() {

        },
        updated(){
            $(function() {
                    $("body").getNiceScroll().resize();
                    $("body").niceScroll();
                    $(".v-data-table__wrapper").getNiceScroll().resize();
                    $(".v-data-table__wrapper").niceScroll();
                });
        },
        watch: {
            shifts : 'toggleLoading',
            shift : 'namaShift',
            namaUnit : 'namaShift',
            // 'form.id_unit' (to, from){
            //     this.form.id_unit = parseInt(this.form.id_unit)
            //     this.form.id_jafung = parseInt(this.form.id_jafung)
            // }
            // filters : 'masaBaktiAktif',
        },

    }//end export default
</script>
