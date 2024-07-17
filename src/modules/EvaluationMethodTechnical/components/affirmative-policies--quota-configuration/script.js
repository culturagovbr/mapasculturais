
app.component('affirmative-policies--quota-configuration', {
    template: $TEMPLATES['affirmative-policies--quota-configuration'],

    props: {
        phase: {
            type: Entity,
            required: true
        }
    },

    setup() {
        // os textos estão localizados no arquivo texts.php deste componente 
        const messages = useMessages();
        const text = Utils.getTexts('affirmative-policies--quota-configuration')
        return { text, messages }
    },

    updated () {
        this.autoSave();
        this.autoSaveTime = 3000;
    },

    mounted() {
        if(this.phase.quotaConfiguration && this.phase.quotaConfiguration.rules.length > 0) {
            if(this.totalVacancies > 0) {
                this.phase.quotaConfiguration.rules.forEach((quota, index) => {
                    this.updateRuleQuotaPercentage(quota, true);
                });
            } else {
                this.distributeQuotas(false, true);
            }
        }
    },

    data() {
        const firstPhase = this.phase.opportunity.parent ?? this.phase.opportunity;
        return {
            autoSaveTime: 3000,
            firstPhase,
            totalVacancies: firstPhase.vacancies ?? 0,
            totalQuota: this.phase.quotaConfiguration ? this.phase.quotaConfiguration.vacancies : 0,
            totalPercentage: 0,
            fields: $MAPAS.config.affirmativePoliciesQuotaConfiguration.fields[this.phase.opportunity.id]
        }
    },

    computed: {
        isActive() {
            return this.phase?.quotaConfiguration?.rules.length > 0;
        },
    },

    methods: {
        skeleton() {
            const rules = {
                fieldName: '',
                eligibleValues: []
            }
            return rules;
        },

        getField(quota) {
            const fieldName = quota.fieldName;
            const field = this.fields.find((field) => field.fieldName == fieldName);
            return field;
        },

        getFieldType(quota) {
            const field = this.getField(quota);
            return field?.fieldType;
        },

        getFieldOptions(quota) {
            const field = this.getField(quota);
            return field?.fieldOptions;
        },

        addConfig() {
            if (!this.phase.quotaConfiguration) {
                this.phase.quotaConfiguration = {
                    rules: [{
                        title: '',
                        vacancies: 0,
                        fields: [this.skeleton()]
                    }]
                };
            } else {
                this.phase.quotaConfiguration.rules.push({
                    vacancies: 0,
                    fields: [this.skeleton()]
                });
            }
        },

        addField(index) {
            this.phase.quotaConfiguration.rules[index].fields.push(this.skeleton());
        },

        removeConfig(item) {
            this.phase.quotaConfiguration.rules = this.phase.quotaConfiguration.rules.filter(function(value, key) {
                return item != key;
            });
            this.distributeQuotas(true);
        },

        removeField(ruleIndex, fieldIndex) {
            this.autoSaveTime = 200;
            this.phase.quotaConfiguration.rules[ruleIndex].fields = this.phase.quotaConfiguration.rules[ruleIndex].fields.filter(function(value, key) {
                return fieldIndex != key;
            });
            if(this.phase.quotaConfiguration.rules[ruleIndex].fields.length === 0) {
                this.removeConfig(ruleIndex);
            } else {
                this.distributeQuotas(true);
            }
        },
        
        updateTotalQuotas() {
            this.totalQuota = ((this.totalVacancies * this.totalPercentage) / 100).toFixed(2);
        },

        updateQuotaPercentage() {
            this.totalPercentage = ((this.totalQuota * 100) / this.totalVacancies).toFixed(2);
        },

        updateRuleQuotas(quota) {
            quota.vacancies = (this.totalVacancies * quota.percentage ) / 100;
            this.distributeQuotas();
        },

        updateRuleQuotaPercentage(quota, load = false) {
            quota.percentage = (quota.vacancies * 100) / this.totalVacancies;
            this.distributeQuotas(false, load);
        },

        distributeQuotas(deleteQuota = false, load = false) {
            let countVacancies = 0;
            let removeQuota = deleteQuota;

            if(this.phase.quotaConfiguration && this.phase.quotaConfiguration.rules.length > 0 || removeQuota) {
                this.phase.quotaConfiguration.rules.forEach((quota, index) => {
                    countVacancies += quota.vacancies;
                });
                this.totalQuota = countVacancies;

                this.updateQuotaPercentage();
                if(!load) {
                    this.autoSave();
                }

                if(removeQuota) {
                    this.autoSave(true);                    
                }
            }
        },

        optionValue(option) {
            let _option = option.split(':');
            return _option[0];
        },

        optionLabel(option) {
            let _option = option.split(':');
            return _option.length > 1 ? _option[1] : _option[0];
        },

        autoSave(updated = false) {
            const filled = Object.values(this.phase.quotaConfiguration.rules).filter(
                quotaConfiguration => {
                    return quotaConfiguration.title !== undefined 
                        && quotaConfiguration.title 
                        && quotaConfiguration.vacancies !== undefined
                        && quotaConfiguration.vacancies > 0
                        && quotaConfiguration.fields.some(field => 
                            field.eligibleValues !== undefined && field.eligibleValues.length > 0
                            && field.fieldName !== undefined && field.fieldName
                        );
                }
            );
            
            if(filled.length || updated) {
                this.phase.save(this.autoSaveTime)            
            }
        },
    },
});
