<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="section">
                    <div class="section-header"><h1>Dashboard</h1></div>

                </div>
                <!-- <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="hero text-white hero-bg-image hero-bg-parallax" style="background-image: url('public/img/taman_gedung_vip2.jpg');">
                        <div class="hero-inner">
                            <h2>Welcome, {{ $parent.userLogin.nickname}}!</h2>
                            <p class="lead">You almost arrived, complete the information about your account to complete registration.</p>
                            <div class="mt-4">
                                <router-link to="/settings" >
                                    <a href="#" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="far fa-user"></i> Setup Account</a>
                                </router-link>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
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
