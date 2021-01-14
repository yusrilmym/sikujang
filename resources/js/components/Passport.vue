<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="section">
                    <div class="section-header"><h1>Laravel Passport</h1></div>
                </div>

                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
                
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
