new Vue({
    el: '#login-form',
    data: {
        loading: false,
        username: '',
        password: '',
        errors: { }
    },
    methods: {
        submitForm() {
            this.errors = { };
            this.loading = true;

            jQuery.ajax({
                method: 'POST',
                url: '/login-check',
                dataType: 'json',
                data: { username: this.username, password: this.password }
            }).done((response) => {
                if (response.success) {
                    document.location.href = '/';
                }
            }).fail((jqXHR, textStatus) => {
                const json = jqXHR.responseJSON;
                this.errors = json.errors || { };

                if (json.redirect) {
                    document.location.href = json.redirect;
                }
            }).always(() => {
                this.loading = false;
            });
        }
    }
});
