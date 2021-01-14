<template>
<v-app class="bg-transparent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="$gate.isSAandSYS() || $gate.isUP()">
                <!-- Position Section -->
                <section class="section">
                    <div class="section-header">
                    <h1>Master Data Jabatan</h1>
                    </div>
                    <div class="section-tools">
                        <div class="row">
                            <div class="col-lg-8 col-md-12 col-sm-12 col-12 mb-2">
                                <div class="input-group">
                                    <select class="custom-select col-4" id="filter" v-model="filters.name.keys[0]" title="Filter By" @change="reset">
                                        <option value="jabatan">Jabatan</option>
                                        <option value="kategori">Kategori</option>
                                    </select>
                                    <input type="text" class="form-control" v-model="filters.name.value" placeholder="type to search">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12 col-12 mb-2 text-right">
                                <button class="btn btn-success" style="border-radius: 30px;" @click="addModal"
                                v-shortkey="['alt', 'a']" @shortkey="addModal()">
                                <i class="fas fa-plus fa-fw"></i>    Tambah Jabatan</button>
                            </div>
                        </div>
                    </div>
                    <div class="card"  style="height: auto">
                        <!-- card-body -->
                        <div class="card-body table-responsive table-invoice p-0 mb-0" >
                            <!-- style="height: 450px" -->

                            <v-table class="wrap table table-striped tableFixHead table-hover text-nowrap" id="table"
                            :data="positions"
                            :currentPage.sync="currentPage"
                            :pageSize="pagination"
                            :filters="filters"
                            @totalItemsChanged="totalItem = $event"
                            @totalPagesChanged="totalPages = $event">
                            <thead slot="head">
                                <tr>
                                    <v-th sortKey="jabatan">Jabatan</v-th>
                                    <v-th sortKey="kategori">Kategori</v-th>
                                    <v-th sortKey="shifting">Shifting</v-th>
                                    <v-th sortKey="jenis_jabatan">Jenis Jabatan</v-th>
                                    <v-th sortKey="updated_at" defaultSort="desc">Action</v-th>
                                </tr>
                            </thead>
                            <tbody slot="body" slot-scope="{displayData}">
                                <tr role="row" class="b-table-busy-slot" v-if="loading === true">
                                    <td colspan="5" role="cell" class="">
                                        <div class="text-center text-success my-2">
                                            <span aria-hidden="true" class="align-middle spinner-border"></span>
                                            <strong>Loading...</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="b-table-busy-slot" v-if="totalItem === 0 && loading === false">
                                    <td colspan="5" role="cell" class="">
                                        <div class="text-center text-success my-2">
                                            <strong>Jabatan tidak ditemukan</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-for="row in displayData" :key="row.id">
                                <td>{{row.jabatan}}</td>
                                <td>{{row.kategori}}</td>
                                <td>{{row.shifting}}</td>
                                <td>{{row.jenis_jabatan}}</td>
                                <td hidden>{{row.updated_at}}</td>
                                <td>
                                    <div class="btn-group btn-group">
                                        <a href="#" @click="editModal(row)" class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                        title="Edit"><i class="fas fa-pen"></i></a>

                                        <a href="#" @click="deletePosition(row.id)" class="btn btn-danger" data-toggle="tooltip" data-placement="top"
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
                                        <option :value="positions.length">all</option>
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
        <div class="modal fade" tabindex="-1" id="formPosition" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="exampleModalCenterTitle">Tambah Jabatan Baru</h5>
                        <h5 class="modal-title" v-show="editmode" id="exampleModalCenterTitle">Update Data Jabatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent ="editmode ? updatePosition() : createPosition()">
                    <div class="modal-body">
                        <v-row>
                            <v-col>
                                <v-text-field ref="jabatan" v-model="form.jabatan" label="Nama Jabatan" prepend-icon="mdi-form-textbox" required type="text"
                                    :error-messages="form.errors.errors.jabatan" :class="{ 'v-input--has-state error--text': form.errors.has('jabatan')}">
                                </v-text-field>
                                <v-select v-model="form.kategori" label="Kategori Jabatan" prepend-icon="mdi-group" required menu-props="auto"
                                :items="['Tenaga Kesehatan', 'Non-Nakes' ]" :class="{ 'v-input--has-state error--text': form.errors.has('kategori')}"
                                :error-messages="form.errors.errors.kategori"
                                ></v-select>
                                <v-select :items="['non-shift', 'shift']" v-model="form.shifting" prepend-icon="mdi-timer" label="Shifting" menu-props="auto"
                                    :error-messages="form.errors.errors.shifting" :class="{ 'v-input--has-state error--text': form.errors.has('shifting')}">
                                </v-select>
                                <v-select :items="['JFU', 'JFT', 'Internal']" v-model="form.jenis_jabatan" prepend-icon="mdi-content-duplicate" label="Jenis Jabatan" menu-props="auto"
                                    :error-messages="form.errors.errors.jenis_jabatan" :class="{ 'v-input--has-state error--text': form.errors.has('jenis_jabatan')}">
                                </v-select>
                            </v-col>
                        </v-row>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <v-btn color="secondary" data-dismiss="modal" class="text-capitalize" @click="date1 = false, date2 = false">Batal</v-btn>
                            <v-btn v-show="editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false"
                            v-shortkey.focus="['ctrl', 'enter']" @shortkey="updatePosition()">Update</v-btn>
                            <v-btn v-show="!editmode" color="primary" type="submit" class="text-capitalize" @click="date1 = false, date2 = false"
                            v-shortkey.focus="['ctrl', 'enter']" @shortkey="createPosition()">Simpan</v-btn>
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
                editmode: false,
                loading: true,
                positions : [],
                currentPage: 1,
                totalPages: 0,
                totalItem: 0,
                pagination: 5,
                filters: {
                    name: { value: '', keys: ['jabatan'] }
                },
                form: new Form ({
                    id:'',
                    jabatan : '',
                    kategori : '',
                    shifting : '',
                    jenis_jabatan : '',
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
                $('.card').css('height', 'auto');
                $(function() {
                    $("body").getNiceScroll().resize();
                    $("body").niceScroll();
                });
            },
            updatePosition(){
                this.$Progress.start();
                this.form.put('api/position/'+this.form.id)
                .then(() => {
                    this.loadPosition();
                    $('#formPosition').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: 'Jabatan berhasil diupdate',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
            },
            editModal(positions){
                this.editmode = true;
                this.form.errors.errors = {};
                this.form.reset();
                $('#formPosition').modal('show');
                this.form.fill(positions);
            },
            addModal(){
                this.editmode = false;
                this.form.errors.errors = {};
                this.form.reset();
                $('#formPosition').modal('show');
            },

            deletePosition(id){
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: "Jabatan yang dihapus tidak dapat dikembalikan!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#39af21',
                    confirmButtonText: 'Ya, Hapus saja!'
                }).then((result) => {
                    //send request to the server
                    if (result.value) {
                        this.form.delete('api/position/'+id).then(()=>{
                            this.loadPosition();
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: 'Jabatan berhasil diupdate',
                                showConfirmButton: false,
                                timer: 1500,
                            })
                        }).catch(()=>{
                            Swal.fire({
                                icon: 'warning',
                                title: 'Gagal!',
                                text: 'Jabatan ini terkait dengan pegawai, silahkan ubah jabatan pegawai terkait terlebih dahulu',
                            })
                        });
                    }
                })
            },

            loadPosition(){
                if(this.$gate.isSAandSYS() || this.$gate.isUP()){
                    this.$Progress.start();
                    axios.get("api/position").then(( data ) => (this.positions = data.data));
                    this.$Progress.finish();
                }
            },
            createPosition(){
                this.$Progress.start();
                this.form.post('api/position')
                .then(()=>{
                    this.loadPosition();
                    $('#formPosition').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Jabatan berhasil ditambah',
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
            this.loadPosition();
        },
        mounted() {

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
            positions : 'toggleLoading',
        },


    }//end export default
</script>
