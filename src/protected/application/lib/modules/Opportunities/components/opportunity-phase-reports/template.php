<?php

/**
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 * @var MapasCulturais\App $app
 */

use MapasCulturais\i;

$this->import('
    mc-stepper-vertical
    v1-embed-tool
');
?>
<mc-stepper-vertical :items="newPhases" allow-multiple>
    <template #header-title="{index, item}">
        <div class="phase-stepper">
            <h2 v-if="index" class="phase-stepper__name">{{ item.label }}</h2>
            <h2 v-if="!index" class="phase-stepper__period">{{ item.label }}</h2>
            <p class="phase-stepper__type" v-if="item.__objectType == 'opportunity' && !item.isLastPhase">
                <label class="phase-stepper__type--name"><?= i::__('Tipo') ?></label>:
                <label class="phase-stepper__type--item"><?= i::__('Coleta de dados') ?></label>
            </p>
            <p v-if="item.__objectType == 'evaluationmethodconfiguration'" class="phase-stepper__type">
                <label class="phase-stepper__type--name"><?= i::__('Tipo') ?></label>: <label class="phase-stepper__type--item">{{ item.type }}</label>
            </p>
        </div>
    </template>
    <template #default="{index, item}">

        <template v-if="item.phases.length > 1">
            <mapas-card v-if="item.phases[0].opportunity && item.phases[0].opportunity.id">
                <v1-embed-tool route="reportmanager" :id="item.phases[0].opportunity.id"></v1-embed-tool>
            </mapas-card>
            <mapas-card v-if="item.phases[0] && item.phases[0].id">
                <v1-embed-tool route="reportmanager" :id="item.phases[0].id"></v1-embed-tool>
            </mapas-card>
        </template>

        <template v-else>
            <template v-if="item.phases[0] && item.phases[0].__objectType == 'evaluationmethodconfiguration'">
                <mapas-card v-if="item.phases[0].opportunity && item.phases[0].opportunity.id">
                    <v1-embed-tool route="reportmanager" :id="item.phases[0].opportunity.id"></v1-embed-tool>
                </mapas-card>
            </template>

            <template v-if="item.phases[0] && item.phases[0].__objectType == 'opportunity'">
                <mapas-card v-if="item.phases[0] && item.phases[0].id">
                    <v1-embed-tool route="reportmanager" :id="item.phases[0].id"></v1-embed-tool>
                </mapas-card>
            </template>
        </template>

    </template>
</mc-stepper-vertical>