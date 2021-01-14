<template>
    <div class="mb-5 pb-3">
        <h1 class="mb-2 display-4 font-weight-bold" style="text-shadow: 2px 2px 15px #000000;">{{ greet }}</h1>
        <h5 class="font-weight-normal text-muted-transparent">Gedung Poliklinik - RSUD Cibinong</h5>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                greet : '',
            }
        },
        methods: {
            greeting(){
                var ndate = new Date();
                var hr = ndate.getHours();
                if(hr < 11){
                    this.greet = 'Good Morning';
                }else if( hr >= 11 && hr <=16 ){
                    this.greet = 'Good Afternoon';
                }else{
                    this.greet = 'Good Evening'
                }
            }
        },
        created() {
            this.greeting();
        },
        mounted() {

        }
    }
</script>
