new Vue({
    el: '#edit-form',
    data: {
        loading: false,
        id: '',
        username: '',
        email: '',
        description: '',
        status: '',
        errors: { }
    },
    methods: {
        submitForm() {
            this.errors = { };
            this.loading = true;

            let data = {
                username: this.username,
                email: this.email,
                description: this.description,
                status: this.status,
                id: this.id
            };

            jQuery.ajax({
                method: 'POST',
                url: this.$refs.form.getAttribute('action'),
                dataType: 'json',
                data: data
            }).done((response) => {
                if (response.success) {
                    document.location.href = '/';
                }
            }).fail((jqXHR) => {
                const json = jqXHR.responseJSON;
                this.errors = json.errors || { };

                if (json.redirect) {
                    document.location.href = json.redirect;
                }
            }).always(() => {
                this.loading = false;
            });
        }
    },
    mounted() {
        let attr;

        for (let name in this.$refs) {
            if ((attr = this.$refs[name].attributes['data-value'])) {
                this[name] = attr.value;
            }
        }

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        this.id = urlParams.get('id');
    }
});
