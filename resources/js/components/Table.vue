<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <section class="section">
                    <div class="section-header">
                    <h1>Package Management</h1>
                    </div>
                    <div class="section-body">
                    <h2 class="section-title">User Table</h2>
                    <p class="section-lead">Daftar Pegawai bala bala</p>
                    <div class="card-header-action">
                        <a class="btn btn-success">Add <i class="fas fa-plus"></i></a>
                        <a class="btn btn-success">Add <i class="fas fa-plus"></i></a>
                        <a class="btn btn-success">Add <i class="fas fa-plus"></i></a>
                    </div>
                    </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Users <span v-if="total">({{ total }})</span></h4>
                                <div class="card-header-action">
                                    <a class="btn btn-success">Add <i class="fas fa-plus"></i></a>
                                    <a class="btn btn-success">Add <i class="fas fa-plus"></i></a>
                                    <a class="btn btn-success">Add <i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-invoice" >
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Reg. Date</th>
                                                <th></th>
                                            </tr>
                                            <tr >
                                                <td>name</td>
                                                <td>email</td>
                                                <td>created at</td>
                                                <td class="text-right">
                                                    <button  @click="deleteUser(user.id, index)" class="btn btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                    <a  class="btn btn-success">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div  class="text-center p-3 text-muted">
                                        <h5>No Results</h5>
                                        <p>Looks like you have not added any users yet!</p>
                                    </div>
                                </div>
                                <div class="text-center p-4 text-muted">
                                    <h5>Loading</h5>
                                    <p>Please wait, data is being loaded...</p>
                                </div>
                            </div>
                        </div>

                    
                </section>
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
