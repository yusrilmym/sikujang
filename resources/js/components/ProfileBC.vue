<style>
.widget-user-header {
    background-position: center center;
    background-size: cover;
}
</style>

<template>
    <div class="container">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 mt-3">

                    <!-- Widget: user widget style 1 -->
                    <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white" style="background-image:url('./img/user-cover.jpg'); height= 300px;">
                        <h3 class="widget-user-username text-right">{{this.form.name}}</h3>
                        <h5 class="widget-user-desc text-right">{{this.form.type}}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                            <h5 class="description-header">3,200</h5>
                            <span class="description-text">SALES</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                            <h5 class="description-header">13,000</h5>
                            <span class="description-text">FOLLOWERS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                            <h5 class="description-header">35</h5>
                            <span class="description-text">PRODUCTS</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    </div>
                    <!-- /.widget-user -->

                    <div class="card card-success card-outline">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                            <div class="tab-pane active" id="activity">
                                <!-- activity-->
                                <!-- Post -->
                                <div class="post clearfix">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="/img/anto.png" alt="User Image">
                                    <span class="username">
                                    <a href="#">Sarah Ross</a>
                                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                    </span>
                                    <span class="description">Sent you a message - 3 days ago</span>
                                </div>
                                <!-- /.user-block -->
                                <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                                    typographers and the like. Some people hate it and argue for
                                    its demise, but others ignore the hate as they create awesome
                                    tools to help create filler text for everyone from bacon lovers
                                    to Charlie Sheen fans.
                                </p>

                                <form class="form-horizontal">
                                    <div class="input-group input-group-sm mb-0">
                                    <input class="form-control form-control-sm" placeholder="Response">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-danger">Send</button>
                                    </div>
                                    </div>
                                </form>
                                </div>
                                <!-- /.post -->
                                
                            </div>

                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal needs-validation">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                        <input type="text" v-model="form.name" placeholder="Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name')}" >
                                        <has-error :form="form" field="name"></has-error>
                                        <div class="valid-feedback">        Looks good!      </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                        <input type="email" v-model="form.email" placeholder="Email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                        <has-error :form="form" field="email"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputBio" class="col-sm-2 col-form-label">Biodata</label>
                                        <div class="col-sm-10">
                                        <input type="text" v-model="form.bio" class="form-control" id="inputName2" placeholder="Bio">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group row">
                                        <label for="photo" class="col-sm-2 col-form-label">Photo</label>
                                        <div class="col-sm-10">
                                        <input class="note-image-input form-control-file note-form-control note-input" 
                                        type="file" @change="updatePhoto" name="photo" id="photo" accept="image/*">
                                        
                                        </div>
                                    </div> -->
                                    <div class="form-group row">
                                        <label for="photo" class="col-sm-2 col-form-label">Foto</label>
                                        <div class="col-sm-10">
                                            <div class="custom-file">
                                                <input type="file" @change="updatePhoto" name="photo" class="custom-file-input" id="photo" accept="image/*">
                                                <label class="custom-file-label" for="photo">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                   
                                   
                                    <!-- <div class="dropdown-divider"></div>
                                    <div>
                                        <strong>Rubah Password</strong> 
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="form-group row mt-1">
                                        <label for="inputSkills" class="col-sm-2 col-form-label">Password Baru</label>
                                        <div class="col-sm-10">
                                            <input v-model="form.password" type="password" name="password" placeholder="Kosongkan jika tidak ingin merubah password"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('password')}">
                                            <has-error :form="form" field="password"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputSkills" class="col-sm-2 col-form-label">Konfirmasi</label>
                                        <div class="col-sm-10">
                                            <input v-model="form.password_confirmation" type="password" name="password_confirmation" placeholder="Konfirmasi Password Baru"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation')}">
                                            <has-error :form="form" field="password_confirmation"></has-error>
                                        </div>
                                    </div> -->
                             
                                    <div class="mt-1">
                                        <button class="btn btn-secondary btn-block" type="button" data-toggle="collapse" data-target="#gantiPassword" aria-checked="false" aria-expanded="false" aria-controls="gantiPassword">
                                            Ganti Password
                                        </button>
                                    </div>
                                    <div class="collapse" id="gantiPassword">
                                    <br>
                                        <div class="form-group row mt-1">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Password Baru</label>
                                            <div class="col-sm-10">
                                                <input v-model="form.password" type="password" name="password" placeholder="Kosongkan jika tidak ingin merubah password"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password')}">
                                                <has-error :form="form" field="password"></has-error>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Konfirmasi</label>
                                            <div class="col-sm-10">
                                                <input v-model="form.password_confirmation" type="password" name="password_confirmation" placeholder="Konfirmasi Password Baru"
                                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation')}">
                                                <has-error :form="form" field="password_confirmation"></has-error>
                                            </div>
                                        </div>
                                    
                                    </div>
                                                                
                                    
                                    
                                    <div class="mt-3">
                                        <button @click.prevent="updateProfile" type="submit" class="btn btn-success btn-block">Update</button>
                                    </div>
                                    
                                        <!-- /.card-footer-->
                                </form>
                            </div>
                            
                            <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>


<script>
import Swal from 'sweetalert2';
    export default {
        data() {
            return {
                currentPhoto:"",
                form: new Form({
                    id: "",
                    name: "",
                    email: "",
                    password: "",
                    type: "",
                    bio: "",
                    photo: ""
                })
            };
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{

            loadProfile() {
                this.$Progress.start();
                axios.get("api/profile")
                .then(({ data }) => {
                    this.$Progress.finish();
                    this.currentPhoto = data.photo;
                    return this.form.fill(data);
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },

            getProfilePhoto(){
                let profilePhoto = (this.form.photo.match(/\//) ? this.currentPhoto : this.form.photo);
                return "img/profile/"+profilePhoto;
                },

            updateProfile(){
                this.$Progress.start();

                if(this.form.password == ""){
                    this.form.password = undefined;
                }

                this.form.put('api/profile')
                .then(() => {
                    Swal.fire({
                                title: 'Profile Berhasil Diupdate!',
                                // text :'Profile berhasil diupdate.',
                                icon : 'success',
                                showConfirmButton: false,
                                timer: 1500
                    })
                    this.loadProfile();
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
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

        // created() {
        //     axios.get("api/profile")
        //     .then(({data}) => (this.form.fill(data)));
        // }
        created() {
            this.$Progress.start();
            axios.get("api/profile")
            .then(({ data }) => {
                this.$Progress.finish();
                this.currentPhoto = data.photo;
                return this.form.fill(data);
            })
            .catch(() => {
                this.$Progress.fail();
            });
        }
    }
</script>
