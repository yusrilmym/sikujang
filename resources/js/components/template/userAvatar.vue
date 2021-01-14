<template>
<span>
    <span v-if="loading">
        <v-progress-circular :size="25" color="white" indeterminate ></v-progress-circular>
    </span>
    <span v-if="!loading">
        <img  alt="image" :src="getAvatar()" class="rounded-circle" style="width: 35px; margin-right: 5px">
        <div class="d-sm-none d-lg-inline-block mr-2"> Hi, {{ $parent.userLogin.nickname }}</div>
        <!-- <i class="far fa-user-circle" style="font-size: 18pt; margin-right: 5px;"></i> -->
    </span>
</span>
</template>

<script>
    export default {
        data() {
            return {
                loading: true,
            }
        },
        methods: {
            getAvatar(){
                // let profilePhoto = (this.profile.photo.match(/\//) ? this.currentPhoto : this.profile.photo);
                let avatar = this.$parent.userLogin.photo;
                let asset = this.$asset.asset;
                return asset+"img/avatar/"+avatar;
            },
        },
        created() {
            this.getAvatar();
            Fire.$on('refreshAvatar', () => {
                this.getAvatar();
            });
        },
        mounted() {
            // console.log('Component mounted.')
        },
        updated() {

        },
        watch: {
            '$parent.userLogin' (to, from){
                this.loading = false;
            }
        },
    }
</script>
