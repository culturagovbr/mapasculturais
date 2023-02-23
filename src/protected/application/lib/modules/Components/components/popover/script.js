app.component('popover', {
    template: $TEMPLATES['popover'],
    emits: ['open', 'close'],

    setup(props, { slots }) {
        const hasSlot = name => !!slots[name]
        return { hasSlot }
    },

    data() {
        return {
            active: false,
        }
    },

    props: {
        classes: {
            type: Array,
            default: []
        },
        buttonLabel: {
            type: String,
            default: ''
        },
        buttonClasses: {
            type: Array,
            default: []
        },
        openside: {
            type: String,
            default: '',
        }
    },
    
    mounted() {
        document.addEventListener('mousedown', (event) => {
            let contained = false;
            const slotPopover = document.getElementsByClassName('v-popper__popper');

            for (let popover of slotPopover) {
                let buttonAriaDescribedby = event.target.getAttribute("aria-describedby") ?? (event.target.closest("a") ? event.target.closest("a").getAttribute("aria-describedby") : null);
                let popoverId = popover.getAttribute("id");

                if (buttonAriaDescribedby === popoverId || popover.contains(event.target)) {
                    contained = true;
                }
            };
            
            if (!contained) { 
                this.close();
            };
        }),
        document.addEventListener('keydown', (e) => {
            if((e.key=="27") || (e.key =="Escape")) {
                this.close();
            }            
        });
    },

    methods: {
        focus() {
            const inputs = this.$refs.content.getElementsByTagName('input');
            if (inputs.length) {
                setTimeout(() => {
                    if (inputs[0].getAttribute("type") == 'text') {
                        inputs[0].focus();
                    }
                }, 100);
            }
        },
        open() {
            this.active = true;
            this.$emit('open', this);
        },
        close() {
            this.active = false;
            this.$emit('close', this);
        },
        toggle() {
            this.active ? this.close() : this.open();
        },
    },
});
