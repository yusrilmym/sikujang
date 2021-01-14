<template>
<v-app class="bg-transparent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12" v-if="$gate.isSAandSYS() || $gate.isUP()">
                <!-- User Section -->
                <section class="section">
                    <div class="section-header" id="header">
                    <h1>Manajemen Pegawai {{ new Date().getFullYear() }}</h1>
                    </div>
                    <div class="section-tools" style="z-index: 0;">
                        <div class="row">
                            <div class="col-lg-8 col-md-12 col-sm-12 col-12 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background-color: #39af21 !important"><i class="fas fa-filter" style="color: white"></i></span>
                                    </div>
                                    <select class="custom-select col-md-3 col-3" id="filter" v-model="filters.name.keys[0]" title="Filter By" @change="reset">
                                        <option value="fullname">Nama </option>
                                        <option value="nip">NIP</option>
                                        <option value="nama_unit">Unit</option>
                                        <option value="jabatan">Jabatan</option>
                                        <option value="status">Status</option>
                                        <option v-if="masabakti === false" value="tmt">TMT</option>
                                        <option v-if="masabakti === true" value="tmt">Masa Bakti</option>
                                    </select>
                                    <select v-if="filters.name.keys[0] === 'status'" class="custom-select" id="filter" v-model="filters.name.value" title="Filter By">
                                        <option value="aktif">Aktif</option>
                                        <option value="non-aktif">Non-Aktif</option>
                                    </select>
                                    <input v-if="filters.name.keys[0] !== 'status' && filters.name.keys[0] !== 'tmt'" type="text" class="form-control" v-model="filters.name.value" placeholder="type to search">
                                    <input v-if="filters.name.keys[0] === 'tmt' && masabakti === true" type="text" class="form-control" v-model="filters.name.value" placeholder="type to search">
                                    <input v-if="filters.name.keys[0] === 'tmt' && masabakti === false" type="date" class="form-control" v-model="filters.date.value.start" title="dari tanggal">
                                    <input v-if="filters.name.keys[0] === 'tmt' && masabakti === false" type="date" class="form-control" v-model="filters.date.value.end" title="hinggal tanggal">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-white" type="button" @click="reset"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12 col-12 mb-2 text-right">
                                <button class="btn btn-success mr-2" style="border-radius: 30px;" @click="addModal">
                                <i class="fas fa-plus fa-fw"></i>    Pegawai</button>
                                <button class="btn btn-success" style="border-radius: 30px;" @click="masaBakti" v-if="masabakti === false">
                                <i class="fas fa-plus fa-sync-alt"></i>    Masa Bakti</button>
                                <button class="btn btn-success" style="border-radius: 30px;" @click="loadUser" v-if="masabakti === true">
                                <i class="fas fa-plus fa-sync-alt"></i>    reset</button>
                            </div>
                        </div>
                    <!-- <v-date-picker mode='range' :masks="{ title: 'YYYY-MM-DD' }" v-model='filters.date.value' /> -->
                    </div>
                    <!-- card -->
                    <div class="card"  style="height: auto; max-height: 450px;">
                        <!-- card-body -->
                        <div class="card-body table-responsive table-invoice p-0 mb-0 scrollbar-macosx" id="table">
                            <!-- style="height: 450px" -->
                            <v-table class="wrap table table-striped tableFixHead table-hover text-nowrap" id="table"
                            :data="users"
                            :currentPage.sync="currentPage"
                            :pageSize="pagination"
                            :filters="filters"
                            :hideSortIcons="true"
                            @totalItemsChanged="totalItem = $event"
                            @totalPagesChanged="totalPages = $event">
                            <thead slot="head">
                                <tr>
                                    <v-th sortKey="fullname">Nama Lengkap</v-th>
                                    <v-th sortKey="nip">NIP</v-th>
                                    <v-th v-if="masabakti === false" sortKey="tmt">TMT</v-th>
                                    <v-th v-if="masabakti === true" sortKey="tmt">Masa Bakti</v-th>
                                    <v-th sortKey="status">Status</v-th>
                                    <v-th sortKey="jabatan">Jabatan</v-th>
                                    <v-th sortKey="nama_unit">Unit</v-th>
                                    <v-th sortKey="type" v-if="$gate.isSysDev()">Role</v-th>
                                    <v-th sortKey="created_at" style="position: -webkit-sticky; position: sticky; right: 0; z-index: 2 !important;">Action</v-th>
                                </tr>
                            </thead>
                            <tbody slot="body" slot-scope="{displayData}">
                                <tr role="row" class="b-table-busy-slot" v-if="loading === true">
                                    <td colspan="9" role="cell" class="">
                                        <div class="text-center text-success my-2">
                                            <span aria-hidden="true" class="align-middle spinner-border"></span>
                                            <strong>Loading...</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr role="row" class="b-table-busy-slot" v-if="totalItem === 0 && loading === false">
                                    <td colspan="9" role="cell" class="">
                                        <div class="text-center text-success my-2">
                                            <strong>Pegawai tidak ditemukan</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-for="row in displayData" :key="row.id">
                                <td>{{row.fullname}}</td>
                                <td>{{row.nip}}</td>
                                <td v-if="masabakti === false ">{{row.tmt | tanggal}}</td>
                                <td v-if="masabakti === true ">{{row.tmt}}</td>
                                <td v-if="row.status === 'aktif'"><div class="btn btn-success">{{row.status | uptext}}</div></td>
                                <td v-if="row.status !== 'aktif'"><div class="btn btn-danger">{{row.status | uptext}}</div></td>
                                <td>{{row.jabatan}}</td>
                                <td>{{row.nama_unit}}</td>
                                <td v-if="$gate.isSysDev()">{{row.role | uptext}}</td>
                                <td hidden>{{row.updated_at}}</td>
                                <td style="position: -webkit-sticky; position: sticky; right: 0; z-index: 1 !important; background-color: rgba(255, 255, 255, 0.85)" >
                                    <div class="btn-group btn-group">
                                        <a v-if="masabakti === false" @click.prevent="editModal(row)" class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                        title="Edit"><i class="fas fa-pen"></i></a>

                                        <a v-if="masabakti === true" @click.prevent="loadUser" class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                        title="Reset untuk edit"><i class="fas fa-sync-alt"></i></a>

                                        <router-link :to="{ path: '/detail',  query: { id : (row.id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="top"
                                        title="Detail"><i class="fas fa-list"></i></router-link>

                                        <a v-if="$gate.isSysDev() || $gate.isUP()" @click.prevent="deleteUser(row.id)" class="btn btn-danger" data-toggle="tooltip" data-placement="top"
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
                                        <option>25</option>
                                        <option>50</option>
                                        <option>100</option>
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
        <div class="modal fade" tabindex="-1" id="formUser" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!editmode" id="exampleModalCenterTitle">Tambah Pegawai Baru</h5>
                        <h5 class="modal-title" v-if="editmode" id="exampleModalCenterTitle">Update Data Pegawai</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <v-app>
                    <form @submit.prevent ="editmode ? updateUser() : createUser()">
                    <div class="modal-body">
                        <v-row class="p-0">
                            <v-col sm="12" md="12" lg="3" cols="12" class="pb-0 pt-2">
                                <v-text-field v-model="form.nickname" label="Nama Panggilan" outlined required type="text"
                                    :error-messages="form.errors.errors.nickname" :class="{ 'v-input--has-state error--text': form.errors.has('nickname')}">
                                </v-text-field>
                            </v-col>
                            <v-col sm="12" md="12" lg="5" cols="12" class="pb-0 pt-2">
                                <v-text-field v-model="form.fullname" label="Nama Lengkap" outlined required type="text"
                                    :error-messages="form.errors.errors.fullname" :class="{ 'v-input--has-state error--text': form.errors.has('fullname')}">
                                </v-text-field>
                            </v-col>
                            <v-col sm="12" md="12" lg="4" cols="12" class="pb-0 pt-2">
                                <v-text-field v-model="form.nip" label="NIP" outlined required type="number"
                                    :error-messages="form.errors.errors.nip" :class="{ 'v-input--has-state error--text': form.errors.has('nip')}">
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col sm="12" md="12" lg="3" cols="12" class="pb-0 pt-2">
                                <v-text-field v-model="form.nik" label="NIK" outlined type="number"
                                    :error-messages="form.errors.errors.nik" :class="{ 'v-input--has-state error--text': form.errors.has('nik')}">
                                </v-text-field>
                            </v-col>
                            <v-col class="pb-0 pt-2">
                                <v-select :items="['PNS', 'PTT', 'HONDA', 'APBD', 'BLUD']" v-model="form.jenis_peg" label="Jenis Pegawai" outlined required type="text" menu-props="auto"
                                    :error-messages="form.errors.errors.jenis_peg" :class="{ 'v-input--has-state error--text': form.errors.has('jenis_peg')}">
                                </v-select>
                            </v-col>
                            <v-col lg="3" cols="12" v-if="form.jenis_peg === 'PNS'" class="pb-0 pt-2">
                                <v-text-field v-model="form.gol" label="Golongan PNS" outlined required type="text"
                                    :error-messages="form.errors.errors.gol" :class="{ 'v-input--has-state error--text': form.errors.has('gol')}">
                                </v-text-field>
                            </v-col>
                            <v-col sm="12" md="12" lg="3" cols="12" class="pb-0 pt-2">
                                <v-menu ref="date1" v-model="date1" :close-on-content-click="false" left
                                    transition="slide-y-transition" offset-y min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="form.tmt" label="TMT" outlined readonly v-bind="attrs" v-on="on"
                                            :error-messages="form.errors.errors.tmt" :class="{ 'v-input--has-state error--text': form.errors.has('tmt')}">
                                        </v-text-field>
                                    </template>
                                    <v-date-picker ref="picker" v-model="form.tmt" locale="id" @input="date1 = false"></v-date-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-4 pb-0 pt-2">
                                <v-autocomplete v-model="form.id_unit" outlined required
                                    :items="units" item-text="nama_unit" item-value="id" label="Unit"
                                ></v-autocomplete>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-4 pb-0 pt-2">
                                <v-autocomplete v-model="form.id_jafung" outlined required
                                    :items="positions" item-text="jabatan" item-value="id" label="Jabatan (RSUD)"
                                ></v-autocomplete>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-4 pb-0 pt-2">
                                <v-autocomplete v-model="form.id_jabpns" outlined required
                                    :items="positions" item-text="jabatan" item-value="id" label="Jabatan (Permenpan)"
                                ></v-autocomplete>
                            </div>

                        </div>
                        <v-row>
                            <v-col sm="12" md="12" lg="2" cols="12" class="pb-0 pt-2">
                                 <v-select :items="['Laki-laki', 'Perempuan']" v-model="form.gender" label="Jenis Kelamin" outlined required type="text" menu-props="auto"
                                    :error-messages="form.errors.errors.gender" :class="{ 'v-input--has-state error--text': form.errors.has('gender')}">
                                </v-select>
                            </v-col>
                            <v-col sm="12" md="12" lg="2" cols="12" class="pb-0 pt-2">
                                 <v-select :items="['Islam', 'Katolik', 'Kristen Protestan', 'Hindu', 'Budha', 'Konghucu']" v-model="form.agama" label="Agama" outlined required type="text" menu-props="auto"
                                    :error-messages="form.errors.errors.agama" :class="{ 'v-input--has-state error--text': form.errors.has('agama')}">
                                </v-select>
                            </v-col>
                            <v-col sm="12" md="12" lg="4" cols="12" class="pb-0 pt-2">
                                <v-text-field v-model="form.tpt_lahir" label="Tempat Lahir" outlined type="text"
                                    :error-messages="form.errors.errors.tpt_lahir" :class="{ 'v-input--has-state error--text': form.errors.has('tpt_lahir')}">
                                </v-text-field>
                            </v-col>
                            <v-col sm="12" md="12" lg="4" cols="12" class="pb-0 pt-2">
                                <v-menu ref="date2" v-model="date2" :close-on-content-click="false" left
                                    transition="slide-y-transition" offset-y min-width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="form.tgl_lahir" label="Tanggal Lahir" outlined readonly v-bind="attrs" v-on="on"
                                            :error-messages="form.errors.errors.tgl_lahir" :class="{ 'v-input--has-state error--text': form.errors.has('tgl_lahir')}">
                                        </v-text-field>
                                    </template>
                                    <v-date-picker ref="picker" v-model="form.tgl_lahir" locale="id" @input="date2 = false"></v-date-picker>
                                </v-menu>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col sm="12" md="12" lg="10" cols="12" class="pb-0 pt-2">
                                <v-text-field v-model="form.email" label="email" outlined required type="email"
                                    :error-messages="form.errors.errors.email" :class="{ 'v-input--has-state error--text': form.errors.has('email')}">
                                </v-text-field>
                            </v-col>
                            <v-col sm="12" md="12" lg="2" cols="12" class="pb-0 pt-2">
                                <v-select :items="['aktif', 'non-aktif']" v-model="form.status" label="Status" outlined required type="text" menu-props="auto"
                                    :error-messages="form.errors.errors.status" :class="{ 'v-input--has-state error--text': form.errors.has('status')}">
                                </v-select>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col sm="12" md="12" lg="6" cols="12" class="pb-0 pt-2" v-if="!editmode || $gate.isSysDev()">
                                <v-text-field v-model="form.password" :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="show ? 'text' : 'password'" name="input-10-1" :label="!editmode ? 'Password' : 'Ubah Password'" :hint="!editmode ? 'At least 6 characters' : 'Kosongkan jika tidak ingin merubah password'"
                                    counter @click:append="show = !show" outlined
                                    :error-messages="form.errors.errors.password" :class="{ 'v-input--has-state error--text': form.errors.has('password')}"
                                ></v-text-field>
                            </v-col>
                            <v-col sm="12" md="12" lg="6" cols="12" class="pb-0 pt-2" v-if="!editmode || $gate.isSysDev()">
                                <v-text-field v-model="form.password_confirmation" :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="show ? 'text' : 'password'" name="input-10-1" label="Konfirmasi Password" hint="At least 6 characters"
                                    counter @click:append="show = !show" outlined
                                    :error-messages="form.errors.errors.password" :class="{ 'v-input--has-state error--text': form.errors.has('password')}"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col v-if="$gate.isSysDev()" class="pb-0 pt-2">
                                <v-select :items="['sysdev', 'super-admin', 'admin', 'user']" v-model="form.role" label="Role" outlined required type="text" menu-props="auto"
                                    :error-messages="form.errors.errors.role" :class="{ 'v-input--has-state error--text': form.errors.has('role')}">
                                </v-select>
                            </v-col>
                        </v-row>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <v-btn color="secondary" data-dismiss="modal" class="text-capitalize">Batal</v-btn>
                            <v-btn v-if="editmode" color="primary" type="submit" class="text-capitalize">Update</v-btn>
                            <v-btn v-if="!editmode" color="primary" type="submit" class="text-capitalize">Simpan</v-btn>
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
                date1: false,
                date2: false,
                show: false,
                allerror: '',
                // dialog: false,
                loading: true,
                perPage: 5,
                currentPage: 1,
                editmode: false,
                users : [],
                units : [],
                positions : [],
                emailblm : '',
                i : 0,
                currentPage: 1,
                totalPages: 0,
                totalItem: 0,
                pagination: 25,
                masabakti : false,
                filters: {
                    name: { value: '', keys: ['fullname'] },
                    date: { value: { start: null,  end: null }, custom: this.dateFilter },
                },
                filterValue : '',
                form: new Form ({
                    id:'',
                    nickname : '',
                    fullname : '',
                    email : '',
                    password : '',
                    role : '',
                    gol : '',
                    nip : '',
                    nik : '',
                    tmt : '',
                    jenis_peg : '',
                    id_unit : null,
                    id_jafung : null,
                    id_jabpns : null,
                    agama : '',
                    tpt_lahir : '',
                    tgl_lahir : '',
                    gender : '',
                    status : '',
                    bio : '',
                    photo : ''
                }),
                dataUnit(node) {
                    return {
                        id: node.id,
                        label: node.nama_unit,
                    }
                },
                dataJabatan(node) {
                    return {
                        id: node.id,
                        label: node.jabatan,
                    }
                },
            }
        },
        methods:{
            toggleLoading() {
                this.loading = false;
            },
            masaBakti(){
                this.reset();
                this.masabakti = true;
                this.filters.name.keys[0] = 'tmt';
                for (this.i = 0; this.i < this.users.length; this.i++) {
                    // this.masabakti[this.i].id = this.users[this.i].id;
                    this.users[this.i].tmt = moment(this.users[this.i].tmt).fromNow(true);
                }

            },
            jdEmail(){
                this.form.email = this.emailblm + '@rsudcibinong.com';
            },
            scroll(){
                $(function() {
                    $("body").getNiceScroll().resize();
                    $("body").niceScroll();
                    $("#cardtable").getNiceScroll().resize();
                    $(".card").niceScroll();
                });
            },
            dateFilter (filterValue, row) {
                if(this.filters.date.value.start !== null){
                     return row.tmt >= filterValue.start && row.tmt <= filterValue.end
                } else{
                    return row;
                }
            },
            updateUser(){
                this.$Progress.start();
                if(this.form.password == ""){
                    this.form.password = undefined;
                }
                if(this.form.type == ""){
                    this.form.type = "user";
                }
                this.form.put('api/user/'+this.form.id)
                .then(() => {
                    this.loadUser();

                    $('#formUser').modal('hide');
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
            reset(){
                this.item = {}
                this.filters.name.value = null;
                this.filters.date.value.start = null;
                this.filters.date.value.end = null ;
            },
            editModal(row){
                // this.$refs.sp.remove();
                this.form.errors.errors = {};
                this.form.reset();
                this.editmode = true;
                this.form.fill(row);
                this.form.password = '';
                $('#formUser').modal('show');
            },
            addModal(){
                // this.$refs.sp.remove();
                this.form.errors.errors = {};
                this.editmode = false;
                this.form.reset();
                $('#formUser').modal('show');
            },

            showDetail(id){
                this.$Progress.start();
                $('#Uman').hide();
                $('#Detail').show();
                axios.get('api/show/'+id).then(({ data }) => (this.profile.fill(data)));
                this.$Progress.finish();
            },

            deleteUser(id){
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
                        this.form.delete('api/user/'+id).then(()=>{
                            this.loadUser();
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
                if(this.$gate.isSysDev() || this.$gate.isUP()){
                    this.$Progress.start();
                    this.masabakti = false;
                    axios.get("api/user").then(( data ) => (this.users = data.data));
                    this.$Progress.finish();
                }else if(this.$gate.isSuperAdmin()){
                    this.$Progress.start();
                    this.masabakti = false;
                    axios.get("api/userbybagian").then(( data ) => (this.users = data.data));
                    this.$Progress.finish();
                }
            },
            loadPosition(){
                if(this.$gate.isSAandSYS() || this.$gate.isUP()){
                    axios.get("api/position").then(( data ) => (this.positions = data.data));
                }
            },
            loadUnit(){
                if(this.$gate.isSAandSYS() || this.$gate.isUP()){
                    axios.get("api/unit").then(( data ) => (this.units = data.data));
                }
            },
            createUser(){
                this.$Progress.start();
                if(this.form.type == ""){
                    this.form.type = "user";
                }
                if(this.form.email == "@rsudcibinong.com"){
                    this.form.email = "";
                }
                this.form.post('api/user')
                .then(()=>{
                    this.loadUser();
                    $('#formUser').modal('hide')
                    toast.fire({
                        icon: 'success',
                        title: 'User Berhasil Dibuat'
                    })
                })
                .catch(()=>{
                    this.$Progress.fail()
                })
                this.$Progress.finish();
            },

        }, //end methods
        created() {
            this.loadUser();
            this.loadPosition();
            this.loadUnit();
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
            date1(val){
                val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
            },
            date2(val){
                val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
            },
            users : 'toggleLoading',
            dialog (val) {
                if (!val) return
                setTimeout(() => (this.dialog = false), 4000)
            },
            // 'form.id_unit' (to, from){
        //     this.form.id_unit = parseInt(this.form.id_unit)
            //     this.form.id_jafung = parseInt(this.form.id_jafung)
            // }
            // filters : 'masaBaktiAktif',
        },

    }//end export default
</script>
