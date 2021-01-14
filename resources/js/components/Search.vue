<template>
    <div class="search-result" id="search">
        <div class="search-header">
            Pegawai
        </div>
        <div class="search-item" id="please">
            <a style="color: #fff00 !important" class="rldis">Please fill search Form</a>
        </div>
        <div class="container" id="loading">
            <div class="spinner-border text-success" role="status" id="loading">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="search-item rldis" id="empty">
            <a style="color: #fff00 !important">User tidak ada</a>
        </div>
        <div id="item">
            <div class="search-item" v-for="user in userSearch" :key="user.id">
                <router-link :to="{ path: '/detail',  query: { id : (user.id) }}" class="rldis" style="color: #000000 !important;">{{user.fullname}}</router-link>
                <!-- <a class="search-close"><i class="fas fa-times rldis"></i></a> -->
            </div>
        </div>
    <div class="mt-1"></div>
    </div>
</template>

<script>
    export default {
        mounted() {
            // console.log('Component mounted.');
            $('#history').hide();
            $('#empty').hide();
            $('#loading').hide();
        },
        data() {
          return {
                userSearch : {},
            }
        },
        methods: {
            hideloader: _.debounce(() => {
                $('#loading').hide();
            }, 1000),
            // loadSearch(){
            //     axios.get("api/user").then(({ data }) => (this.users = data.data));
            // },
            // showDetail(id){
            //     // axios.get('api/show/'+id).then(({ data }) => (this.profileSearch.fill(data)));
            //     this.iduser = id;
            // },
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                if(this.$parent.search == ""){
                    query = "gaadapokoknya";
                    $('#item').hide();
                    $('#please').show();
                }else{
                    $('#please').hide();
                    $('#loading').show();
                    axios.get('api/findUser?q=' + query).then(({data}) => (this.userSearch = data.data));
                    this.hideloader();
                    $('#item').show();
                }
            })
        },
    }
</script>
