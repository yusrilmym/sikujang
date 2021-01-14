export default class Gate{

    constructor(user){
        this.user = user;
    }

    isSysDev(){
        return this.user.role === 'sysdev';
    }

    isExecutive(){
        return this.user.role === 'executive';
    }

    isSuperAdminPlus(){
        return this.user.role === 'super-admin-plus';
    }

    isSuperAdmin(){
        return this.user.role === 'super-admin';
    }

    isAdmin(){
        return this.user.role === 'admin';
    }

    isUser(){
        return this.user.role === 'user';
    }

    isUP(){
        if(this.user.id_jafung === 13 || this.user.id_jafung === 124 || this.user.id_jafung === 130 || this.user.id_jafung === 151 || this.user.id_jafung === 177 || this.user.id_jafung === 178){
            return true;
        }
    }
    isKeuangan(){
        if(this.user.id_unit === 5 ){
            return true;
        }
    }
    // 2 user
    isEXEandSYS(){
        if(this.user.role === 'executive' || this.user.role === 'sysdev'){
            return true;
        }
    }
    isSAPandSYS(){
        if(this.user.role === 'super-admin-plus' || this.user.role === 'sysdev'){
            return true;
        }
    }
    isSAandSYS(){
        if(this.user.role === 'super-admin' || this.user.role === 'sysdev'){
            return true;
        }
    }
    isAandSYS(){
        if(this.user.role === 'admin' || this.user.role === 'sysdev'){
            return true;
        }
    }
    isUandSYS(){
        if(this.user.role === 'user' || this.user.role === 'sysdev'){
            return true;
        }
    }

    isAandSAandSYS(){
        if(this.user.role === 'admin' || this.user.role === 'super-admin' || this.user.role === 'sysdev'){
            return true;
        }
    }
    isSAandEXECandSYS(){
        if(this.user.role === 'executive' || this.user.role === 'super-admin' || this.user.role === 'sysdev'){
            return true;
        }
    }
    isAandSAandEXECandSYS(){
        if(this.user.role === 'admin' || this.user.role === 'super-admin' || this.user.role === 'sysdev' || this.user.role === 'executive' ){
            return true;
        }
    }

}
