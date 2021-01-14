<template>
<v-app class="bg-transparent">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <section class="section">
                    <div class="section-header">
                        <div v-if="!grsetting" class="section-header-back">
                            <a @click="back" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
                        </div>
                        <h1>Settings</h1>
                        <!-- <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                        <div class="breadcrumb-item">Settings</div>
                        </div> -->
                    </div>

                    <div class="section-body">
                        <h2 class="section-title">Overview</h2>
                        <p class="section-lead">
                        Organize and adjust all settings about this site.
                        </p>
                        <!-- Group Setting -->
                        <div class="row" v-if="grsetting">
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="card-body">
                                <h4>General Information</h4>
                                <p>Pengaturan tentang informasi data diri dan sebagainya.</p>
                                <a @click="goto('general'), fillGen()" class="card-cta">Change Setting <i class="fas fa-chevron-right"></i></a>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-portrait"></i>
                            </div>
                            <div class="card-body">
                                <h4>Photo Profile</h4>
                                <p>Security settings such as change password, and others.</p>
                                <a @click="goto('photo')" class="card-cta">Change Setting <i class="fas fa-chevron-right"></i></a>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="card-body">
                                <h4>Security</h4>
                                <p>Security settings such as firewalls, server accounts and others.</p>
                                <a @click="goto('security')" class="card-cta">Change Setting <i class="fas fa-chevron-right"></i></a>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div class="card-body">
                                <h4>Alamat</h4>
                                <p>Email SMTP settings, notifications and others related to email.</p>
                                <a @click="goto('alamat')" class="card-cta">Change Setting <i class="fas fa-chevron-right"></i></a>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="card-body">
                                <h4>Pendidikan</h4>
                                <p>PHP version settings, time zones and other environments.</p>
                                <a @click="goto('pendidikan')" class="card-cta">Change Setting <i class="fas fa-chevron-right"></i></a>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card card-large-icons">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="card-body">
                                <h4>Dokumen Pegawai</h4>
                                <p>PHP version settings, time zones and other environments.</p>
                                <a @click="goto('dokumen')" class="card-cta">Change Setting <i class="fas fa-chevron-right"></i></a>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- Setting Detail -->
                        <div class="row" v-if="detail">
                            <div class="col-md-4 order-sm-1 order-2">
                                <div class="card">
                                <div class="card-header">
                                    <h4>Jump To</h4>
                                </div>
                                <div class="card-body pl-0">
                                    <ul class="nav nav-pills flex-column">
                                    <li class="nav-item"><a @click="jumpTo('general'), fillGen()" class="nav-link" :class="{'active': setting == 'general'}" >General</a></li>
                                    <li class="nav-item"><a @click="jumpTo('photo'), fillGen()" class="nav-link" :class="{'active': setting == 'photo'}" >Photo Profile</a></li>
                                    <li class="nav-item"><a @click="jumpTo('security')" class="nav-link" :class="{'active': setting == 'security'}" >Security</a></li>
                                    <li class="nav-item"><a @click="jumpTo('alamat')" class="nav-link" :class="{'active': setting == 'alamat'}" >Alamat</a></li>
                                    <li class="nav-item"><a @click="jumpTo('pendidikan')" class="nav-link" :class="{'active': setting == 'pendidikan'}" >Pendidikan</a></li>
                                    <li class="nav-item"><a @click="jumpTo('dokumen')" class="nav-link" :class="{'active': setting == 'dokumen'}" >Dokumen Pegawai</a></li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <!-- General -->
                            <div class="col-md-8 order-sm-2 order-1" v-if="setting == 'general'">
                                <form id="setting-form" @submit.prevent="saveGeneral()">
                                <div class="card" id="settings-card">
                                    <div class="card-header">
                                    <h4>General Information</h4>
                                    </div>
                                    <div class="card-body pr-10">
                                    <!-- <p class="text-muted mb-0">General settings such as, site title, site description, address and so on.</p> -->
                                    <div class="form-group row align-items-center mb-0">
                                        <label for="site-description" class="form-control-label col-sm-3 text-md-right pt-0 mt-0">Nama Panggilan</label>
                                        <div class="col-sm-6 col-md-9 pt-0">
                                        <v-text-field v-model="formGeneral.nickname" label="Nama panggilan" single-line class="pt-0"
                                        :error-messages="formGeneral.errors.errors.nickname" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('nickname')}">
                                        </v-text-field>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-0">
                                        <label for="site-description" class="form-control-label col-sm-3 text-md-right pt-0 mt-0">Nama Lengkap</label>
                                        <div class="col-sm-6 col-md-9 pt-0">
                                        <v-text-field v-model="formGeneral.fullname" label="Nama lengkap beserta gelar" single-line class="pt-0"
                                        :error-messages="formGeneral.errors.errors.fullname" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('fullname')}">
                                        </v-text-field>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-0">
                                        <label for="site-description" class="form-control-label col-sm-3 text-md-right pt-0 mt-0">NIP</label>
                                        <div class="col-sm-6 col-md-9 pt-0">
                                        <v-text-field v-model="formGeneral.nip" label="Nomor Induk Pegawai" type="number" single-line readonly class="pt-0"
                                        :error-messages="formGeneral.errors.errors.nip" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('nip')}">
                                        </v-text-field>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-0">
                                        <label for="site-description" class="form-control-label col-sm-3 text-md-right pt-0 mt-0">NIK</label>
                                        <div class="col-sm-6 col-md-9 pt-0">
                                        <v-text-field v-model="formGeneral.nik" label="Nomor Induk Kependudukan" type="number" single-line class="pt-0"
                                        :error-messages="formGeneral.errors.errors.nik" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('nik')}">
                                        </v-text-field>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-0">
                                        <label for="site-description" class="form-control-label col-sm-3 text-md-right pt-0 mt-0">Jenis Pegawai</label>
                                        <div class="pt-0" :class="{'col-md-6': formGeneral.jenis_peg === 'PNS', 'col-md-9': formGeneral.jenis_peg !== 'PNS'}">
                                            <v-text-field v-model="formGeneral.jenis_peg" label="Jenis Pegawai" single-line readonly class="pt-0"
                                            :error-messages="formGeneral.errors.errors.jenis_peg" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('jenis_peg')}">
                                            </v-text-field>
                                            </div>
                                        <div class="pt-0 col-md-3" v-if="formGeneral.jenis_peg === 'PNS'">
                                            <v-text-field v-model="formGeneral.gol" label="Golongan" single-line readonly class="pt-0"
                                            :error-messages="formGeneral.errors.errors.gol" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('gol')}">
                                            </v-text-field>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-0">
                                        <label for="site-description" class="form-control-label col-sm-3 text-md-right pt-0 mt-0">Jabatan & Unit</label>
                                        <div class="col-sm-3 col-md-5 pt-0">
                                            <v-text-field v-model="formGeneral.jabatan" label="Jenis Pegawai" single-line readonly class="pt-0"
                                            :error-messages="formGeneral.errors.errors.jabatan" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('jabatan')}">
                                            </v-text-field>
                                            </div>
                                        <div class="col-sm-3 col-md-4 pt-0">
                                            <v-text-field v-model="formGeneral.unit" label="Golongan" single-line readonly class="pt-0"
                                            :error-messages="formGeneral.errors.errors.unit" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('unit')}">
                                            </v-text-field>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-0">
                                        <label for="site-description" class="form-control-label col-sm-3 text-md-right pt-0 mt-0">E-mail</label>
                                        <div class="col-sm-6 col-md-9 pt-0">
                                            <v-text-field v-model="formGeneral.email" label="E-mail" type="email" single-line class="pt-0"
                                            :error-messages="formGeneral.errors.errors.email" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('email')}">
                                            </v-text-field>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-0">
                                        <label for="site-description" class="form-control-label col-sm-3 text-md-right pt-0 mt-0">Agama</label>
                                        <div class="col-sm-6 col-md-9 pt-0">
                                            <v-select :items="['Islam', 'Katolik', 'Protestan', 'Hindu', 'Budha', 'Konghucu']" v-model="formGeneral.agama" class="pt-0" label="Agama" menu-props="auto" single-line
                                                :error-messages="formGeneral.errors.errors.agama" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('agama')}">
                                            </v-select>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-0">
                                        <label for="site-description" class="form-control-label col-sm-3 text-md-right pt-0 mt-0">Tempat & <br> Tanggal Lahir</label>
                                        <div class="col-sm-6 col-md-4 pt-0">
                                            <v-text-field v-model="formGeneral.tpt_lahir" label="Tempat Lahir" type="text" single-line class="pt-0"
                                            :error-messages="formGeneral.errors.errors.tpt_lahir" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('tpt_lahir')}">
                                            </v-text-field>
                                        </div>
                                        <div class="col-sm-6 col-md-5 pt-0">
                                            <v-text-field v-model="formGeneral.tgl_lahir" label="Tanggal Lahir" type="date" single-line class="pt-0"
                                            :error-messages="formGeneral.errors.errors.tgl_lahir" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('tgl_lahir')}">
                                            </v-text-field>
                                        </div>
                                    </div>
                                    <div class="form-group row align-items-center mb-0">
                                        <label for="site-description" class="form-control-label col-sm-3 text-md-right pt-0 mt-0">Jenis Kelamin</label>
                                        <div class="col-sm-6 col-md-9 pt-0">
                                            <v-select :items="['Laki-laki', 'Perempuan']" v-model="formGeneral.gender" class="pt-0" label="Jenis Kelamin" menu-props="auto" single-line
                                                :error-messages="formGeneral.errors.errors.gender" :class="{ 'v-input--has-state error--text': formGeneral.errors.has('gender')}">
                                            </v-select>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="card-footer bg-whitesmoke text-md-right">
                                        <v-btn color="secondary" class="text-capitalize mr-2" @click="back"> Cancel</v-btn>
                                        <v-btn color="primary" class="text-capitalize" type="submit"> Save Changes</v-btn>
                                    </div>
                                </div>
                                </form>
                            </div>

                            <!-- photo -->
                            <div class="col-md-8 order-sm-2 order-1" v-if="setting == 'photo'">
                                <form id="setting-form" @submit.prevent="postPhoto()">
                                <div class="card" id="settings-card">
                                    <div class="card-header">
                                    <h4>Photo Profile</h4>
                                    </div>
                                    <div class="card-body" style="padding-right: 35px; padding-left: 35px">
                                    <!-- <p class="text-muted mb-0">General settings such as, site title, site description, address and so on.</p> -->
                                        <div class="form-group row align-items-center mb-0">
                                            <div class="col dropbox">
                                            <input v-if="fileinput" type="file" name="photo" @change="selectPhoto"
                                                    class="input-file">
                                                <p v-if="!selected"> Drag your photo(s) here to upload<br> or click to browse </p>
                                                <p v-if="selected"> {{ selected.name }} </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-whitesmoke text-md-right">
                                        <v-btn color="secondary" class="text-capitalize mr-2" @click="back"> Cancel</v-btn>
                                        <v-btn color="primary" :loading="btnload" :disabled="btnload" class="text-capitalize" type="submit"> Save Changes</v-btn>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- Security -->
                            <div class="col-md-8 order-sm-2 order-1" v-if="setting == 'security'">
                                <form @submit.prevent="changePwd()">
                                <div class="card" id="settings-card">
                                    <div class="card-header">
                                    <h4>Security</h4>
                                    </div>
                                    <div class="card-body pr-10">
                                    <!-- <p class="text-muted">Pendidikan such as, site title, site description, address and so on.</p> -->
                                        <div class="form-group row align-items-center mb-0">
                                            <label for="site-description" class="form-control-label col-sm-3 text-md-right">Password Lama</label>
                                            <div class="col-sm-6 col-md-9">
                                                <v-text-field v-model="formPass.oldpassword" label="Password Lama" single-line
                                                :append-icon="showpwd ? 'mdi-eye' : 'mdi-eye-off'" @click:append="showpwd = !showpwd" :type="showpwd ? 'text' : 'password'"
                                                :error-messages="formPass.errors.errors.oldpassword" :class="{ 'v-input--has-state error--text': formPass.errors.has('oldpassword')}">
                                                </v-text-field>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center mb-0">
                                            <label for="site-description" class="form-control-label col-sm-3 text-md-right">Password Baru</label>
                                            <div class="col-sm-6 col-md-9">
                                                <v-text-field v-model="formPass.newpassword" label="Password minimal 6 karakter" single-line counter
                                                :append-icon="showpwdn ? 'mdi-eye' : 'mdi-eye-off'" @click:append="showpwdn = !showpwdn" :type="showpwdn ? 'text' : 'password'"
                                                :error-messages="formPass.errors.errors.newpassword" :class="{ 'v-input--has-state error--text': formPass.errors.has('newpassword')}">
                                                </v-text-field>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center mb-0">
                                            <label for="site-description" class="form-control-label col-sm-3 text-md-right">Konfirmasi Password</label>
                                            <div class="col-sm-6 col-md-9">
                                                <v-text-field v-model="formPass.confirm" label="Konfimasi password baru" single-line counter
                                                :append-icon="showpwdc ? 'mdi-eye' : 'mdi-eye-off'" @click:append="showpwdc = !showpwdc" :type="showpwdc ? 'text' : 'password'"
                                                :error-messages="formPass.errors.errors.confirm" :class="{ 'v-input--has-state error--text': formPass.errors.has('confirm')}">
                                                </v-text-field>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-whitesmoke text-md-right">
                                        <v-btn color="secondary" class="text-capitalize mr-2" @click="back"> Cancel</v-btn>
                                        <v-btn color="primary" class="text-capitalize" type="submit"> Save Changes</v-btn>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- Alamat -->
                            <div class="col-md-8 order-sm-2 order-1" v-if="setting == 'alamat'">
                                <form id="setting-form">
                                <div class="card" id="settings-card">
                                    <div class="card-header">
                                    <h4>Alamat</h4>
                                    </div>
                                    <div class="card-body">
                                    <!-- <p class="text-muted">Pendidikan such as, site title, site description, address and so on.</p> -->
                                    <div class="row text-center">
                                        <div class="col">
                                            <h2>Opps, we are not ready ...</h2>
                                            <img :src="asset('img/design_team.svg')" alt="still developing" style="height: 400px; width: 100%">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="card-footer bg-whitesmoke text-md-right">
                                        <!-- <v-btn color="secondary" class="text-capitalize mr-2" @click="back"> Cancel</v-btn>
                                        <v-btn color="primary" class="text-capitalize" type="submit"> Save Changes</v-btn> -->
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- Pendidikan -->
                            <div class="col-md-8 order-sm-2 order-1" v-if="setting == 'pendidikan'">
                                <form id="setting-form">
                                <div class="card" id="settings-card">
                                    <div class="card-header">
                                    <h4>Pendidikan</h4>
                                    </div>
                                    <div class="card-body">
                                    <!-- <p class="text-muted">Pendidikan such as, site title, site description, address and so on.</p> -->
                                    <div class="row text-center">
                                        <div class="col">
                                            <h2>Opps, we are not ready ...</h2>
                                            <img :src="asset('img/design_team.svg')" alt="still developing" style="height: 400px; width: 100%">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="card-footer bg-whitesmoke text-md-right">
                                        <!-- <v-btn color="secondary" class="text-capitalize mr-2" @click="back"> Cancel</v-btn>
                                        <v-btn color="primary" class="text-capitalize" type="submit"> Save Changes</v-btn> -->
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- Dokument -->
                            <div class="col-md-8 order-sm-2 order-1" v-if="setting == 'dokumen'">
                                <form id="setting-form">
                                <div class="card" id="settings-card">
                                    <div class="card-header">
                                    <h4>Dokumen Pegawai</h4>
                                    </div>
                                    <div class="card-body">
                                    <!-- <p class="text-muted">Pendidikan such as, site title, site description, address and so on.</p> -->
                                    <div class="row text-center">
                                        <div class="col">
                                            <h2>Opps, we are not ready ...</h2>
                                            <img :src="asset('img/design_team.svg')" alt="still developing" style="height: 400px; width: 100%">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="card-footer bg-whitesmoke text-md-right">
                                        <!-- <v-btn color="secondary" class="text-capitalize mr-2" @click="back"> Cancel</v-btn>
                                        <v-btn color="primary" class="text-capitalize" type="submit"> Save Changes</v-btn> -->
                                    </div>
                                </div>
                                </form>
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
    export default {
        data(){
            return{
                btnload: false,
                grsetting: true,
                detail: false,
                profile: {},
                setting: '',
                showpwd: false,
                showpwdn: false,
                showpwdc: false,
                fileinput: true,
                //photostuff
                selected: '',
                formPhoto: new Form({
                    fullname : '',
                    photo : '',
                }),
                formPass: new Form({
                    oldpassword: '',
                    newpassword: '',
                    confirm: '',
                }),
                formGeneral: new Form({
                    id: '',
                    nickname: '',
                    fullname: '',
                    nip: '',
                    nik: '',
                    gol: '',
                    email: '',
                    jenis_peg: '',
                    agama: '',
                    tpt_lahir: '',
                    tgl_lahir: '',
                    gender: '',
                    jabatan: '',
                    unit: '',
                }),
            }
        },
        methods: {
            goto(a){
                this.grsetting = false;
                this.detail = true;
                this.setting = a;
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth',
                });
            },
            jumpTo(a){
                this.setting = a;
                this.selected = null;
                this.formGeneral.reset();
                this.formPass.reset();
                this.formPhoto.reset();
                this.formGeneral.errors.errors = {};
                this.formPhoto.errors.errors = {};
                this.formPass.errors.errors = {};
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth',
                });
            },
            back(){
                this.formGeneral.reset();
                this.formPhoto.reset();
                this.formPass.reset();
                this.formGeneral.errors.errors = {};
                this.formPhoto.errors.errors = {};
                this.formPass.errors.errors = {};
                this.selected = null;
                this.grsetting = true;
                this.detail = false;
                window.scrollTo(0,0);
            },
            fillGen(){
                this.formGeneral.fill(this.profile);
            },
            selectPhoto(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                this.selected = e.target.files[0];
                if(file['type'] === 'image/jpeg' || file['type'] === 'image/png' ||
                    file['type'] === 'image/gif' || file['type'] === 'image/bmp'){
                    reader.onloadend = (file) =>{
                        this.formPhoto.photo = reader.result;
                    }
                    reader.readAsDataURL(file);
                }else{
                    this.selected = '';
                    this.fileinput = false;
                    this.$nextTick(() => {
                        this.fileinput = true;
                    })
                    Swal.fire(
                        'Oopss..',
                        'Tipe file harus jpg, png, gif, atau bmp',
                        'error'
                    )
                }
            },
            postPhoto(){
                this.$Progress.start();
                this.btnload = true;
                this.formPhoto.fullname = this.profile.fullname;
                this.formPhoto.put('api/photo/'+this.profile.id)
                .then(() => {
                    Fire.$emit('refreshUser');
                    Swal.fire({
                        title: 'Foto Berhasil Diupdate!',
                        // text :'Profile berhasil diupdate.',
                        icon : 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.selected = null;
                    this.formPhoto.reset();
                    this.fileinput = false;
                    this.$nextTick(() => {
                        this.fileinput = true;
                    })
                    this.back();
                    this.btnload = false;
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                    this.btnload = false;
                    Swal.fire({
                        title: 'Pilih foto terlebih dahulu!',
                        icon : 'error',
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
            },
            changePwd(){
                this.formPass.put("api/user/changepwd/"+this.profile.id)
                .then(() => {
                    this.formPass.reset();
                    this.back();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Password berhasil dirubah',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
            },
            saveGeneral(){
                this.$Progress.start();
                this.formGeneral.put("api/user/"+this.formGeneral.id)
                .then(() => {
                    this.loadProfile();
                    this.back();
                    Fire.$emit('refreshUser');
                    Swal.fire({
                        icon: 'success',
                        title: 'Disimpan!',
                        text: 'Perubahan berhasil disimpan',
                        showConfirmButton: false,
                        timer: 1500,
                    })
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
            },
            loadProfile(){
                this.$Progress.start();
                // axios.get("api/profile").then((data) => (this.formGeneral.fill(data.data[0])));
                axios.get("api/profile").then(( data ) => (this.profile = data.data[0]));
                this.$Progress.finish();
            },
        },
        created() {
            this.loadProfile();
        },
        mounted() {
            $(function() {
                $("body").getNiceScroll().resize();
                $("body").niceScroll();
                $('.scrollbar-macosx').scrollbar();
            });
            // console.log('Component mounted.')
        },
        updated() {
            $(function() {
                $("body").getNiceScroll().resize();
                $("body").niceScroll();
                $('.scrollbar-macosx').scrollbar();
            });
        },
    }
</script>
<style>
.dropbox {
    outline: 2px dashed #39af21; /* the dash box */
    outline-offset: -10px;
    /* background: lightcyan; */
    color: #39af21;
    /* padding: 10px 10px; */
    height: 300px; /* minimum height */
    position: relative;
    cursor: pointer;
}

.input-file {
    opacity: 0; /* invisible but it's there! */
    width: 97%;
    height: 280px;
    position: absolute;
    cursor: pointer;
    outline: none;
}

.dropbox:hover {
    background: #f6fff7; /* when mouse over to the drop zone, change color */
}

.dropbox p {
    font-size: 1.2em;
    text-align: center;
    padding: 100px 0;
}
</style>
