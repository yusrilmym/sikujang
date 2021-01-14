<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <section class="section" id="Detail">
                    <div class="section-header">
                        <h1>Profil Pegawai</h1>
                    </div>

                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <h4 class="card-header" style="margin-bottom: -10px; color: #39af21 !important">
                                {{ profile.fullname }}
                            </h4>
                            <div class="avatar-item">
                                <img alt="image" :src="getProfilePhoto()" class=" profile-widget-picture border">
                                <!-- <div class="avatar-badge" @click="editPhoto(form)" title="" data-toggle="tooltip" data-original-title="Change Picture"><i class="fas fa-camera"></i></div> -->
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="row">
                                <div class="col-md-3 col-12" >
                                    <div><span class="fas fa-home"></span>  Unit : {{ profile.unit }}</div>
                                    <div><span class="fas fa-home"></span>  Jabatan : {{ profile.jabatan }}</div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div><span class="fas fa-home"></span>  Jenis Karyawan : {{ profile.jenis_peg }}<span v-if="profile.jenis_peg == 'PNS'"> - </span>{{ profile.gol }}</div>
                                    <div><span class="fas fa-home"></span>  Masa Bakti : {{ profile.tmt | masabakti }}</div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-primary">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Terlambat</h4>
                                    </div>
                                    <div class="card-body">
                                        1
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-danger">
                                    <i class="far fa-newspaper"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Sakit</h4>
                                    </div>
                                    <div class="card-body">
                                        0
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-warning">
                                <i class="far fa-file"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Izin</h4>
                                    </div>
                                    <div class="card-body">
                                        0
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Alpa</h4>
                                    </div>
                                    <div class="card-body">
                                        0
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <!-- Data Pribadi -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Pribadi</h4>
                                <div class="card-header-action">
                                    <a @click="editProfile(form)" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pen"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="summary">
                                    <!-- <div class="summary-info">
                                        <h4>$1,053</h4>
                                        <div class="text-muted">Sold 3 items on 2 customers</div>
                                        <div class="d-block mt-2">
                                            <a href="#">View All</a>
                                        </div>
                                    </div> -->
                                    <div class="summary-item">
                                        <!-- <h6><span class="fas fa-home"></span>Alamat</h6> -->
                                        <ul class="list-unstyled list-unstyled-border">
                                            <li class="media">
                                                <div class="media-body">
                                                    <!-- <div class="media-right">$405</div> -->
                                                    <div class="media-title"> <span class="fas fa-home"></span>  Alamat</div>
                                                    <div class="text-left">Jl. KSR Dadi Kusmayadi No.27</div>
                                                    <div class="text-muted text-medium">Tengah, Cibinong, Bogor, Jawa Barat<div class="bullet"></div> 16914</div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <div class="media-body">
                                                    <!-- <div class="media-right">$405</div> -->
                                                    <div class="media-title"> <span class="fas fa-birthday-cake"></span>  T T L</div>
                                                    <div class="text-left">Jakarta, 30 Februari 1000</div>
                                                    <!-- <div class="text-muted text-medium">Jl. Blablabla skjflksjlfksldkflskdflskdjflskdjflksjdflksjdflksjdflkj <div class="bullet"></div> Sunday</div> -->
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="col-lg-6 col-md-6 col-12">
                        <!-- Data absen -->
                        <div class="card">
                            <div class="card-header">
                                <h4>Absensi</h4>
                                <div class="card-header-action">
                                    <a href="#" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Lihat detail"><i class="fas fa-eye"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="summary">
                                    <div class="summary-item">
                                        <ul class="list-unstyled list-unstyled-border">
                                            <li class="media">
                                                <div class="media-body">
                                                    <div class="media-right"><div class="btn btn-success">Tepat</div></div>
                                                    <div class="media-title"> <span class="fas fa-calendar-alt mr-2"></span>Senin, 31 januari 2020</div>
                                                    <div class="text-medium" style="margin-left: 20px">
                                                       <span data-toggle="tooltip" data-placement="bottom" title="Jam masuk">07.45</span>
                                                        <div class="bullet"></div>
                                                       <span data-toggle="tooltip" data-placement="bottom" title="Jam Pulang">17.45</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <div class="media-body">
                                                    <div class="media-right"><div class="btn btn-danger">Terlambat</div></div>
                                                    <div class="media-title"> <span class="fas fa-calendar-alt"></span>  Senin, 31 januari 2020</div>
                                                    <div class="text-medium" style="margin-left: 20px">
                                                       <span data-toggle="tooltip" data-placement="bottom" title="Jam masuk">08.45</span>
                                                        <div class="bullet"></div>
                                                       <span data-toggle="tooltip" data-placement="bottom" title="Jam Pulang">17.45</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="media">
                                                <div class="media-body">
                                                    <div class="media-right"><div class="btn btn-success">Tepat</div></div>
                                                    <div class="media-title"> <span class="fas fa-calendar-alt"></span>  Senin, 31 januari 2020</div>
                                                    <div class="text-medium" style="margin-left: 20px">
                                                       <span data-toggle="tooltip" data-placement="bottom" title="Jam masuk">07.45</span>
                                                        <div class="bullet"></div>
                                                       <span data-toggle="tooltip" data-placement="bottom" title="Jam Pulang">17.45</span>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Profile-->
        <div class="modal fade" id="formProfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Data User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <form @submit.prevent ="updateProfile()">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input v-model="form.name" type="text" name="name" placeholder="Nama Anda"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name')}">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input v-model="form.email" type="email" name="email" placeholder="Alamat Email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email')}">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Biodata</label>
                        <div class="col-sm-10">
                            <textarea v-model="form.bio" name="bio" id="bio" placeholder="Biodata"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('bio')}">
                            </textarea>
                            <has-error :form="form" field="bio"></has-error>
                        </div>
                    </div>

                    <div class="form-group row" v-if="$gate.isSuperAdmin()">
                        <label class="col-sm-2 col-form-label">Tipe</label>
                        <div class="col-sm-10">
                            <select name="type" v-model="form.type" id="type" class="form-control"
                            :class="{'is-invalid': form.errors.has('type') }">
                            <option value="">Pilih Tipe User</option>
                            <option value="super-admin">Super Admin</option>
                            <option value="admin">Admin</option>
                            <option value="user">Standar User</option>
                            </select>
                        </div>
                        <has-error :form="form" field="type"></has-error>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>

                </div>
            </div>
        </div>

         <!-- Modal Password-->
        <div class="modal fade" id="formPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Ubah Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent ="updateProfile()">
                <div class="modal-body">
                <div class="form-group">
                    <input v-model="form.password" type="password" name="password" placeholder="Password Baru"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password')}">
                    <has-error :form="form" field="password"></has-error>
                </div>
                <div class="form-group">
                    <input v-model="form.password_confirmation" type="password" name="password_confirmation" placeholder="Konfirmasi password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation')}">
                    <has-error :form="form" field="password_confirmation"></has-error>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>

                </div>
            </div>
        </div>

         <!-- Modal Photo-->
        <!-- <div class="modal fade" id="formPhoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Ubah Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent ="postPhoto()">
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <b-form-file v-model="formPhoto.photo" :state="Boolean(formPhoto.photo)" placeholder="Choose a file or drop it here..."
                                drop-placeholder="Drop file here..."  @change="updatePhoto" size="lg" id="photo" accept="image/*" :file-name-formatter="formatNames" aria-required="true" multiple>
                                </b-form-file>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <b-button v-if="load === true" variant="dark" disabled>
                            <b-spinner small></b-spinner>
                            Uploading...
                        </b-button>
                        <button v-if="load === false" type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
                </div>
            </div>
        </div> -->

    </div>
</template>

<script>
import Swal from 'sweetalert2';
    export default {
        data() {
            return {
                currentPhoto:"",
                profile: [],
                form: new Form({
                    id: "",
                    name: "",
                    email: "",
                    password: "",
                    type: "",
                    bio: "",
                    photo: ""
                }),
            };
        },
        methods:{
            // editModal(form){
            //   this.form.reset();
            //   $('#formProfil').modal('show');

            //   this.form.fill(this.profile);
            // },

            // editPass(form){
            //   this.form.reset();
            //   $('#formPassword').modal('show');
            //   this.form.fill(user);
            // },

            // editPhoto(form){
            //   this.form.reset();
            //   $('#formPhoto').modal('show');
            //   this.form.fill(user);
            // },

            loadProfile(){
                this.$Progress.start();
                // axios.get("api/profile").then(({ data }) => (this.profile.fill(data)));
                axios.get("api/profile").then(( data ) => (this.profile = data.data[0]));
                this.$Progress.finish();
            },

            getProfilePhoto(){
                // let profilePhoto = (this.profile.photo.match(/\//) ? this.currentPhoto : this.profile.photo);
                let profilePhoto = this.profile.photo;
                let asset = this.$asset.asset;
                return asset+"img/photo/"+profilePhoto;
            },
            updatePhoto(e){
                //console.log('Uploading')
                let file = e.target.files[0];
                console.log(file);
                let reader = new FileReader();
                if(file['size'] < 2111775){
                    reader.onloadend = (file) =>{
                        //console.log('RESULT', reader.result)
                        this.form.photo = reader.result;
                    }
                    reader.readAsDataURL(file);
                }else{
                    Swal.fire(
                        'Oopss..',
                        'Ukuran file melebihi 2MB',
                        'error'
                    )
                }
            }
        },
        created() {
            this.loadProfile();
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
    }
</script>
