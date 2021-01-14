<template>
<v-app class="bg-transparent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="$gate.isSAandSYS() || $gate.isUP()">
                <!-- Position Section -->
                <section class="section">
                    <div class="section-header">
                        <h1>Master Data Tupoksi JFU</h1>
                    </div>
                    <template>
                        <div class="row">
                        <div class="col-12">
                            <div class="card mb-0">
                            <div class="card-body">
                                <form @submit.prevent="filterJabatan()">
                                <div class="row">
                                    <div class="col pt-0 pb-0 pr-0">
                                        <v-autocomplete v-model="formJabatan.id_jabatan" clearable outlined dense hide-details
                                            :items="positions" label="Pilih Jabatan" item-text="jabatan" item-value="id" hide-selected
                                            :error-messages="formJabatan.errors.errors.id_jabatan" :class="{ 'v-input--has-state error--text': formJabatan.errors.has('id_jabatan')}"
                                        ></v-autocomplete>
                                    </div>
                                    <div class="col-auto pt-0 pb-0">
                                        <v-btn color="primary" type="submit" height="40px"> <v-icon>mdi-send</v-icon> </v-btn>
                                    </div>
                                </div>
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>
                    </template>

                    <transition name="slide-fade">
                        <div class="row">
                        <div v-if="first" style="text-align: center" class="col pl-5 pr-5">
                            <h3><b>Silahkan Pilih Jabatan</b></h3>
                            <br>
                            <img :src="asset('img/selecting.svg')" alt="still developing" style="height: 300px; width: 100%">
                        </div>
                        </div>
                    </transition>

                    <transition name="slide-fade">
                    <div v-if="!loading && !first">
                        <div class="section-tools">
                            <h2 class="section-title mb-2">{{ tupoksijfus.jabatan }}</h2>
                            <div class="row">
                                <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                                    <div class="input-group">
                                        <select class="custom-select col-4" id="filter" v-model="filters.name.keys[0]" title="Filter By" @change="reset">
                                            <option value="uraian_tugas">Uraian Tugas</option>
                                        </select>
                                        <input type="text" class="form-control" v-model="filters.name.value" placeholder="type to search">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 text-right">
                                    <button class="btn btn-success" @click="addModal"
                                    v-shortkey="['alt', 'a']" @shortkey="addModal()">
                                    <i class="fas fa-plus fa-fw"></i>    Tambah Tupoksi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </transition>
                    <transition name="slide-fade">
                        <div v-if="!loading && !first">
                        <div class="card" style="height: auto">
                            <!-- card-body -->
                            <div class="card-body table-responsive table-bordered table-invoice p-0 mb-0 scrollbar-macosx" >
                                <!-- style="height: 450px" -->

                                <v-table class="table table-striped tableFixHead table-hover" id="table"
                                :data="tupoksijfus.tupoksi"
                                :currentPage.sync="currentPage"
                                :pageSize="pagination"
                                :filters="filters"
                                @totalItemsChanged="totalItem = $event"
                                @totalPagesChanged="totalPages = $event">
                                <thead slot="head" class="text-nowrap">
                                    <tr>
                                        <v-th sortKey="butir_kegiatan">Butir Kegiatan</v-th>
                                        <v-th sortKey="angka_kredit">Angka Kredit</v-th>
                                        <v-th sortKey="satuan_hasil">Satuan Hasil</v-th>
                                        <v-th sortKey="qty">Kuantiti</v-th>
                                        <v-th sortKey="disable">Action</v-th>
                                    </tr>
                                </thead>
                                <tbody slot="body" slot-scope="{displayData}">
                                    <tr role="row" class="b-table-busy-slot" v-if="totalItem === 0 && loading === false">
                                        <td colspan="11" role="cell" class="">
                                            <div class="text-center text-success my-2">
                                                <strong>Tupoksi masih kosong</strong>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-for="row in displayData" :key="row.id">
                                    <td style="max-width: 70%;">{{row.butir_kegiatan}}</td>
                                    <td>{{row.angka_kredit}}</td>
                                    <td>{{row.satuan_hasil}}</td>
                                    <td>{{row.qty}}</td>
                                    <td>
                                        <v-btn-toggle>
                                            <v-btn @click="editModal(row)" small data-toggle="tooltip" title="Edit">
                                                <v-icon>mdi-pencil</v-icon>
                                            </v-btn>
                                            <v-btn @click="deleteTupoksi(row.id)" small data-toggle="tooltip" title="Hapus">
                                                <v-icon>mdi-trash-can-outline</v-icon>
                                            </v-btn>
                                        </v-btn-toggle>
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
                                            <option :value="tupoksijfus.tupoksi.length">all</option>
                                        </select>
                                        from {{ totalItem }}
                                    </div>
                                    <div class="col-md-auto col-12 float-center p-0" @click="scroll">
                                        <smart-pagination :currentPage.sync="currentPage" :totalPages="totalPages" :maxPageLinks="4"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                        </div>
                    </transition>

                    <transition name="slide-fade">
                        <v-row v-if="loading" align="center" justify="center" no-gutters style="height: 500px;" >
                            <v-progress-circular :size="70" :width="7" color="primary" indeterminate ></v-progress-circular>
                        </v-row>
                    </transition>
                </section>

            </div>

            <div class="col-md-12" v-if="!$gate.isSAandSYS() && !$gate.isUP()">
                <not-found-page></not-found-page>
            </div>

        </div>

        <!-- Modal Add + Edit-->
        <!-- <div class="modal fade" tabindex="-1" id="formTupoksi" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!editmode" id="exampleModalCenterTitle">Tambah Tupoksi JFU Baru</h5>
                        <h5 class="modal-title" v-if="editmode" id="exampleModalCenterTitle">Update Tupoksi JFU</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent ="editmode ? updateTupoksiJFU() : createTupoksiJFU()">
                    <div class="modal-body">
                        <v-row>
                            <v-col class="pb-0 pt-0">
                                <v-textarea clearable clear-icon="mdi-close-circle" prepend-icon="mdi-form-textbox" label="Uraian Tugas" v-model="form.uraian_tugas" rows="1" auto-grow
                                :error-messages="form.errors.errors.uraian_tugas" :class="{ 'v-input--has-state error--text': form.errors.has('uraian_tugas')}"></v-textarea>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col class="pb-0 pt-0">
                                <v-text-field v-model="form.satuan_hasil" label="Satuan Hasil" prepend-icon="mdi-form-textbox" type="text"
                                    :error-messages="form.errors.errors.satuan_hasil" :class="{ 'v-input--has-state error--text': form.errors.has('satuan_hasil')}">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col class="pt-0">
                                <v-text-field v-model="form.waktu_penyelesaian" label="Waktu Penyelesaian" prepend-icon="mdi-form-textbox" type="number" step=".0001"
                                    :error-messages="form.errors.errors.waktu_penyelesaian" :class="{ 'v-input--has-state error--text': form.errors.has('waktu_penyelesaian')}">
                                </v-text-field>
                                <v-text-field v-model="form.waktu_efektif" label="Waktu Efektif" prepend-icon="mdi-form-textbox" type="number" step=".0001"
                                    :error-messages="form.errors.errors.waktu_efektif" :class="{ 'v-input--has-state error--text': form.errors.has('waktu_efektif')}">
                                </v-text-field>
                            </v-col>
                            <v-col class="pt-0">
                                <v-text-field v-model="form.beban_kerja" label="Beban Kerja" prepend-icon="mdi-form-textbox" type="number" step=".0001"
                                    :error-messages="form.errors.errors.beban_kerja" :class="{ 'v-input--has-state error--text': form.errors.has('beban_kerja')}">
                                </v-text-field>
                                <v-text-field v-model="form.pegawai_dibutuhkan" label="Pegawai Dibutuhkan" prepend-icon="mdi-form-textbox" type="number" step=".0001"
                                    :error-messages="form.errors.errors.pegawai_dibutuhkan" :class="{ 'v-input--has-state error--text': form.errors.has('pegawai_dibutuhkan')}">
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <v-btn color="secondary" data-dismiss="modal" class="text-capitalize" @click="date1 = false, date2 = false">Batal</v-btn>
                            <v-btn v-if="editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false"
                            :loading="btnload" :disabled="btnload" v-shortkey.focus="['ctrl', 'enter']" @shortkey="updateTupoksiJFU()">Update</v-btn>
                            <v-btn v-if="!editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false"
                            :loading="btnload" :disabled="btnload" v-shortkey.focus="['ctrl', 'enter']" @shortkey="createTupoksiJFU()">Simpan</v-btn>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div> -->
        <div class="modal fade" tabindex="-1" id="formTupoksi" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!editmode" id="exampleModalCenterTitle">Tambah Tupoksi JFU Baru</h5>
                        <h5 class="modal-title" v-if="editmode" id="exampleModalCenterTitle">Update Tupoksi JFU</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent ="editmode ? updateTupoksiJFU() : createTupoksiJFU()">
                    <div class="modal-body">
                        <v-row>
                            <v-col class="pb-0 pt-0">
                                <v-textarea clearable clear-icon="mdi-close-circle" prepend-icon="mdi-form-textbox" label="Butir Kegiatan" v-model="form.butir_kegiatan" rows="1" auto-grow
                                :error-messages="form.errors.errors.butir_kegiatan" :class="{ 'v-input--has-state error--text': form.errors.has('butir_kegiatan')}"></v-textarea>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col class="pt-0 pb-0">
                                <v-text-field v-model="form.angka_kredit" label="Angka Kredit" prepend-icon="mdi-form-textbox" type="number" step=".0001"
                                    :error-messages="form.errors.errors.angka_kredit" :class="{ 'v-input--has-state error--text': form.errors.has('angka_kredit'), }">
                                </v-text-field>
                            </v-col>
                            <v-col class="pt-0 pb-0">
                                <v-text-field v-model="form.qty" label="Kuantiti" prepend-icon="mdi-form-textbox" type="number" step=".0001"
                                    :error-messages="form.errors.errors.qty" :class="{ 'v-input--has-state error--text': form.errors.has('qty')}">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col class="pt-0">
                                <v-text-field v-model="form.satuan_hasil" label="Satuan Hasil" prepend-icon="mdi-form-textbox" type="text"
                                    :error-messages="form.errors.errors.satuan_hasil" :class="{ 'v-input--has-state error--text': form.errors.has('satuan_hasil')}">
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <v-btn color="secondary" data-dismiss="modal" class="text-capitalize" @click="date1 = false, date2 = false">Batal</v-btn>
                            <v-btn v-if="editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false"
                            :loading="btnload" :disabled="btnload" v-shortkey.focus="['ctrl', 'enter']" @shortkey="updateTupoksiJFU()">Update</v-btn>
                            <v-btn v-if="!editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false"
                            :loading="btnload" :disabled="btnload" v-shortkey.focus="['ctrl', 'enter']" @shortkey="createTupoksiJFU()">Simpan</v-btn>
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
                btnload: false,
                first: true,
                editmode: false,
                loading: false,
                tupoksijfus : [],
                positions : [],
                currentPage: 1,
                totalPages: 0,
                totalItem: 0,
                pagination: 5,
                filters: {
                    name: { value: '', keys: ['uraian_tugas'] }
                },
                formJabatan: new Form ({
                    id_jabatan : '',
                }),
                form: new Form ({
                    id:'',
                    id_jabatan: '',
                    butir_kegiatan: '',
                    angka_kredit: '',
                    satuan_hasil: '',
                    qty: '',
                })
                // currentPhoto:"",
            }
        },
        methods:{
            filterJabatan(){
                if (this.formJabatan.id_jabatan === "" || this.formJabatan.id_jabatan === undefined) {
                    this.first = true;
                    this.loading = false;
                }else{
                    this.first = false;
                    this.loading = true;
                }
                this.formJabatan.post('api/tupoksi-jabatan')
                .then(( data ) => (this.tupoksijfus = data.data));
            },
            toggleLoading() {
                this.loading = false;
                if(this.formJabatan.id_jabatan === undefined){
                    this.first = true;
                }
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
            updateTupoksiJFU(){
                this.$Progress.start();
                this.btnload = true;
                this.form.put('api/tupoksi/'+this.form.id)
                .then(() => {
                    this.loadTupoksi();
                    $('#formTupoksi').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Tupoksi berhasil diupdate',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.$Progress.finish();
                    this.btnload = false;
                })
                .catch(() => {
                    this.$Progress.fail();
                    this.btnload = false;
                })
            },
            editModal(tupoksijfus){
                this.editmode = true;
                this.form.reset();
                this.form.errors.errors = {};
                $('#formTupoksi').modal('show');
                this.form.fill(tupoksijfus);
            },
            addModal(){
                this.editmode = false;
                this.form.errors.errors = {};
                this.form.reset();
                $('#formTupoksi').modal('show');
            },

            deleteTupoksi(id){
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Tupoksi yang dihapus tidak dapat dikembalikan!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#39af21',
                    confirmButtonText: 'Ya, Hapus saja!'
                }).then((result) => {
                    //send request to the server
                    if (result.value) {
                        this.form.delete('api/tupoksi/'+id).then(()=>{
                            this.loadTupoksi();
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'Tupoksi berhasil dihapus',
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

            loadTupoksi(){
                if(this.$gate.isSAandSYS() || this.$gate.isUP()){
                    this.$Progress.start();
                    axios.get("api/tupoksibyid/"+this.tupoksijfus.id).then(( data ) => (this.tupoksijfus = data.data));
                    this.$Progress.finish();
                }
            },
            loadPosition(){
                if(this.$gate.isSAandSYS() || this.$gate.isUP()){
                    axios.get("api/jabatan-jfu").then(( data ) => (this.positions = data.data));
                }
            },

            createTupoksiJFU(){
                this.$Progress.start();
                this.btnload = true;
                this.form.id_jabatan = this.tupoksijfus.id;
                this.form.post('api/tupoksi')
                .then(()=>{
                    this.loadTupoksi();
                    $('#formTupoksi').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Tupoksi berhasil ditambah',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.btnload = false;
                })
                .catch(()=>{
                    this.$Progress.fail();
                    this.btnload = false;
                })
                this.$Progress.finish();
            },

        }, //end methods
        created() {
            this.loadPosition();
        },
        mounted() {

        },
        updated(){
            $(function() {
                    $("body").getNiceScroll().resize();
                    $("body").niceScroll();
                    $('.scrollbar-macosx').scrollbar();
                });
        },
        watch: {
            tupoksijfus : 'toggleLoading',
        },


    }//end export default
</script>
