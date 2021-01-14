module.exports = {
    methods: {
        asset(path){
            var base_path = window.asset || '';
            return base_path + path;
        }
    },
}
