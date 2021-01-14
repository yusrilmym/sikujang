<template>
    <v-app class="bg-transparent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="$gate.isSAandSYS() || $gate.isUP()">
                <!-- Unit Section -->
                <section class="section">
                    <div class="section-header">
                    <h1>Master Data Unit</h1>
                    </div>
                    <div class="section-tools">
                        <div class="row">
                            <div class="col-lg-8 col-md-12 col-sm-12 col-12 mb-2">
                                <div class="input-group">
                                    <select class="custom-select col-4" id="filter" v-model="filters.name.keys[0]" title="Filter By" @change="reset">
                                        <option value="nama_unit">Unit</option>
                                        <option value="bagian">Bagian</option>
                                    </select>
                                    <input v-if="filters.name.keys[0] === 'nama_unit'" type="text" class="form-control" v-model="filters.name.value" placeholder="type to search">
                                    <select v-if="filters.name.keys[0] === 'bagian'" name="bagian" v-model="filters.name.value" class="custom-select">
                                        <option>Keuangan</option>
                                        <option>Tata Usaha</option>
                                        <option>Bidang Medik</option>
                                        <option>Bidang Keperawatan</option>
                                        <option>Instalasi</option>
                                        <option>Fungsional</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12 col-12 mb-2 text-right">
                                <button class="btn btn-success float-right" style="border-radius: 30px;" @click="addModal"
                                v-shortkey="['alt', 'a']" @shortkey="addModal()">
                                <i class="fas fa-plus fa-fw"></i>    Tambah unit</button>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-6">
                    <h2 class="section-title">Table unit</h2>
                    <p class="section-lead">Daftar Pegawai bala bala</p>
                    </div> -->
                    <!-- card -->
                    <div class="card"  style="height: auto">
                        <!-- card-body -->
                        <div class="card-body table-responsive table-invoice p-0 mb-0" >
                            <!-- style="height: 450px" -->

                            <v-table class="wrap table table-striped tableFixHead table-hover text-nowrap" id="table"
                            :data="units"
                            :currentPage.sync="currentPage"
                            :pageSize="pagination"
                            :filters="filters"
                            @totalItemsChanged="totalItem = $event"
                            @totalPagesChanged="totalPages = $event">
                            <thead slot="head">
                                <tr>
                                    <v-th sortKey="nama_unit">Unit</v-th>
                                    <v-th sortKey="bagian">Bagian</v-th>
                                    <v-th sortKey="updated_at" defaultSort="desc">Action</v-th>
                                </tr>
                            </thead>
                            <tbody slot="body" slot-scope="{displayData}">
                                <tr role="row" class="b-table-busy-slot" v-if="loading === true">
                                    <td colspan="3" role="cell" class="">
                                        <div class="text-center text-success my-2">
                                            <span aria-hidden="true" class="align-middle spinner-border"></span>
                                            <strong>Loading...</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="b-table-busy-slot" v-if="totalItem === 0 && loading === false">
                                    <td colspan="3" role="cell" class="">
                                        <div class="text-center text-success my-2">
                                            <strong>Unit tidak ditemukan</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-for="row in displayData" :key="row.id">
                                    <td>{{row.nama_unit}}</td>
                                    <td>{{row.bagian}}</td>
                                    <td hidden>{{row.updated_at}}</td>
                                <td>
                                    <div class="btn-group btn-group">
                                        <a href="#" @click="editModal(row)" class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                        title="Edit"><i class="fas fa-pen"></i></a>

                                        <a href="#" @click="deleteUnit(row.id)" class="btn btn-danger" data-toggle="tooltip" data-placement="top"
                                        title="Delete"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                                </tr>
                            </tbody>
                            </v-table>
                        </div>
                        <div class="card-footer" style="padding: 10px 30px 10px 25px !important">
                            <div class="row justify-content-between">
                                <div class="col-md-auto col-12 text-center pb-0 pt-0 pl-3">
                                    <label for="pagination">show</label>
                                    <select class="form-control-sm" v-model.number="pagination" type="number" style="width: 60px; border: 2px solid #39af21"  @change="scroll">
                                        <option>5</option>
                                        <option>50</option>
                                        <option :value="units.length">all</option>
                                    </select>
                                    from {{ totalItem }}
                                </div>
                                <div class="col-md-auto col-12 float-center p-0">
                                    <smart-pagination :currentPage.sync="currentPage" :totalPages="totalPages" :maxPageLinks="4"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

            <div class="col-md-12" v-if="!$gate.isSAandSYS() && !$gate.isUP()">
                <not-found-page></not-found-page>
            </div>

        </div>

        <!-- Modal Add + Edit-->
        <div class="modal fade" tabindex="-1" id="formUnit" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="exampleModalCenterTitle">Tambah unit Baru</h5>
                        <h5 class="modal-title" v-show="editmode" id="exampleModalCenterTitle">Update Data unit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent ="editmode ? updateUnit() : createUnit()">
                    <div class="modal-body">
                        <v-row>
                            <v-col>
                                <v-text-field v-model="form.nama_unit" label="Nama Unit" prepend-icon="mdi-form-textbox" required type="text"
                                    :error-messages="form.errors.errors.nama_unit" :class="{ 'v-input--has-state error--text': form.errors.has('nama_unit')}">
                                </v-text-field>
                                <v-select v-model="form.bagian" label="Bagian Unit" prepend-icon="mdi-group" required menu-props="auto"
                                :items="['Keuangan', 'Tata Usaha', 'Bidang Medik', 'Bidang Keperawatan', 'Instalasi', 'Direksi', 'Komite']" :class="{ 'v-input--has-state error--text': form.errors.has('bagian')}"
                                :error-messages="form.errors.errors.bagian"
                                ></v-select>
                            </v-col>
                        </v-row>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <v-btn color="secondary" data-dismiss="modal" class="text-capitalize" @click="date1 = false, date2 = false">Batal</v-btn>
                            <v-btn v-show="editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false"
                            v-shortkey.focus="['ctrl', 'enter']" @shortkey="updateUnit()">Update</v-btn>
                            <v-btn v-show="!editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false"
                            v-shortkey.focus="['ctrl', 'enter']" @shortkey="createUnit()">Simpan</v-btn>
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
                title: 'Unit',
                loading: true,
                editmode: false,
                units : [],
                currentPage: 1,
                totalPages: 0,
                pagination: 5,
                totalItem: 0,
                filters: {
                    name: { value: '', keys: ['nama_unit'] }
                },
                form: new Form ({
                    id:'',
                    nama_unit : '',
                    bagian : '',
                })
                // currentPhoto:"",
            }
        },
        methods:{
            toggleLoading() {
                this.loading = false;
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
            updateUnit(){
                this.$Progress.start();
                this.form.put('api/unit/'+this.form.id)
                .then(() => {
                    this.loadUnit();
                    $('#formUnit').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Unit berhasil diupdate',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
            },
            editModal(units){
                this.form.reset();
                this.editmode = true;
                this.form.errors.errors = {};
                this.form.fill(units);
                $('#formUnit').modal('show');
            },
            addModal(){
                this.form.errors.errors = {};
                this.form.reset();
                this.editmode = false;
                $('#formUnit').modal('show');
            },

            deleteUnit(id){
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "unit yang dihapus tidak dapat dikembalikan!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#39af21',
                    confirmButtonText: 'Ya, Hapus saja!'
                }).then((result) => {
                    //send request to the server
                    if (result.value) {
                        this.form.delete('api/unit/'+id).then(()=>{
                            this.loadUnit();
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'Unit berhasil dihapus',
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

            loadUnit(){
                if(this.$gate.isSAandSYS() || this.$gate.isUP()){
                    this.$Progress.start();
                    axios.get("api/unit").then(( data ) => (this.units = data.data));
                    this.$Progress.finish();
                }

            },

            createUnit(){
                this.$Progress.start();
                this.form.post('api/unit')
                .then(()=>{
                    this.loadUnit();
                    $('#formUnit').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Unit berhasil ditambah',
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
            this.loadUnit();
        },
        mounted() {
            // $('.card').css('height', 'auto');
        },
        updated(){
            $(function() {
                    $("body").getNiceScroll().resize();
                    $("body").niceScroll();
                });
        },
        watch: {
            units : 'toggleLoading',
        },
    }//end export default
</script>
