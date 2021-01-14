<template>
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand shadow bg-dark">
            <a class="text-white"> <img :src="asset('img/logo-rsud.png')" style="height: 35px !important" alt="RSUD Logo"> SIKUJANG DEV</a>
        </div>

        <div class="sidebar-brand sidebar-brand-sm shadow">
            <img :src="asset('img/logo-rsud.png')" style="height: 40px !important" alt="RSUD Logo">
        </div>

        <ul class="sidebar-menu mt-2">
            <li class="menu-header">User Menu</li>
            <li>
                <router-link to="/home" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </router-link>
            </li>
            <li v-if="$parent.userLogin.shifting === 'shift' || $gate.isSysDev() || ($gate.isAdmin() && $parent.userLogin.karu === 'Kepala Ruangan') || ($gate.isSuperAdmin() && $parent.userLogin.bagian === 'Bidang Keperawatan')">
                <router-link to="/jadwalshift" class="nav-link">
                    <i class="far fa-calendar-check"></i>
                    <span>Jadwal Shift</span>
                </router-link>
            </li>
            <li>
                <router-link to="/Laporan-bulanan" class="nav-link">
                    <i class="fas fa-list"></i>
                    <span>Laporan Bulanan</span>
                </router-link>
            </li>
            <!-- <li>
                <router-link to="/skp-tahunan" class="nav-link">
                    <i class="fas fa-clipboard-list"></i>
                    <span>SKP</span>
                </router-link>
            </li> -->
        </ul>
        <ul class="sidebar-menu mt-2">
            <li class="menu-header">Admin Menu</li>
            <li v-if="$gate.isSAandSYS() || $gate.isUP()">
                <router-link to="/pegawai" class="nav-link">
                    <i class="fas fa-user-tie"></i>
                    <span>Pegawai</span>
                </router-link>
            </li>
            <li v-if="$gate.isAandSAandSYS() || $gate.isExecutive() || $gate.isUP()">
                <router-link to="/user-activities" class="nav-link">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Kegiatan Pegawai</span>
                </router-link>
            </li>
            <li v-if="$parent.userLogin.bagian === 'Keuangan' || $gate.isSysDev()">
                <router-link to="/laporan-pegawai-keuangan" class="nav-link">
                    <i class="fas fa-tasks"></i>
                    <span>Laporan Pegawai</span>
                </router-link>
            </li>
            <!-- <li>
                <router-link to="/skp-tahunan" class="nav-link">
                    <i class="fas fa-clipboard-list"></i>
                    <span>SKP Pegawai</span>
                </router-link>
            </li> -->
        </ul>
        <ul class="sidebar-menu mt-2" v-if="$gate.isSysDev() || $gate.isExecutive()">
            <li class="menu-header">Executive</li>
            <li>
                <router-link to="/laporan-pegawai" class="nav-link">
                    <i class="fas fa-tasks"></i>
                    <span>Laporan Pegawai</span>
                </router-link>
            </li>
        </ul>

        <ul class="sidebar-menu" v-if="$gate.isSAandSYS() || $gate.isUP()">
            <li class="menu-header">Setting</li>
        </ul>

        <ul class="sidebar-menu" v-if="$gate.isSysDev() || $gate.isUP()">
            <li class="nav-item dropdown">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-server"></i> <span>Master Data</span></a>
            <ul class="dropdown-menu">
                <li>
                    <router-link to="/unit" class="nav-link ddmenu">
                        <i class="fas fa-building"></i>
                        <span>Unit Kerja</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/tupoksi-jfu" class="nav-link ddmenu">
                        <i class="fas fa-stethoscope"></i>
                        <span>Tupoksi JFU</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/tupoksi-jft" class="nav-link ddmenu">
                        <i class="fas fa-hospital-user"></i>
                        <span>Tupoksi JFT</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/position" class="nav-link ddmenu">
                        <i class="fas fa-briefcase"></i>
                        <span>Jabatan</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/shift" class="nav-link ddmenu">
                        <i class="fas fa-clock"></i>
                        <span>Waktu Shift</span>
                    </router-link>
                </li>
            </ul>
            </li>
        </ul>

        <ul class="sidebar-menu">
            <li v-if="$gate.isSysDev()">
                <router-link to="/passport" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Laravel Passport</span>
                </router-link>
            </li>
        </ul>
        <br>
    </aside>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
