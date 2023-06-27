app.component('support-actions', {
    template: $TEMPLATES['support-actions'],

    props: {
        registration: {
            type: Entity,
            required: true
        },
    },

    mounted() {
        window.addEventListener("message", (event) => {
            if (event.data.type == 'registration.update') {
                for (let key in event.data.data) {
                    this.registration[key] = event.data.data[key];
                }
            }
        });
    },
    
    methods: {
        async save() {
            const iframe = document.getElementById('support-form');
            const registration = this.registration;
            if (iframe) {
                const promise = new Promise((resolve, reject) => {
                    Promise.all([
                        registration.save(false),
                    ]).then((values) => {
                        resolve(values[0]);
                    });
                });
                return promise;

            } else {
                return registration.save(false);
            }
        },

        exit() {
            this.registration.save().then(() => {
                if (window.history.length > 2) {
                    window.history.back();
                } else {
                    window.location.href = $MAPAS.baseURL+'panel';
                }
            });
        },
    },
});
