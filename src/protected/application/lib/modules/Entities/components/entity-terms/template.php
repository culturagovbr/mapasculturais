<?php
/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    mc-multiselect
    mc-popover 
    mc-tag-list 
');
?>
<div v-if="editable || entity.terms?.[taxonomy].length > 0" :class="['entity-terms', classes]">
    <h4 class="entity-terms__title bold" v-if="title == ''"> {{taxonomy}} </h4>
    <h4 class="entity-terms__title bold" v-else> {{title}} </h4>

    <mc-popover v-if="allowInsert && editable" openside="down-right"  @open="loadTerms()" :title="popoverTitle">
        <template #button="popover">
            <button @click="popover.toggle()" class="button button--rounded button--sm button--icon button--primary" v-if="editable">
                <?php i::_e("Adicionar nova") ?>
                <mc-icon name="add"></mc-icon>
            </button>
        </template>

        <!-- Modo Tags -->
        <template #default="{toggle}">
            <div class="entity-terms__tags">
                <form class="entity-terms__tags--form" @submit.prevent="insertTag(toggle)">
                    <input type="text"  class="input" placeholder="<?= i::__('Adicione uma nova tag') ?>" v-model="filter">
                    <button class="button button--primary button--icon entity-terms__tags--form-addBtn" type="submit">
                        <mc-icon name="add"></mc-icon>
                    </button>
                </form>
                <ul class="entity-terms__tags--list" v-if="filteredTerms.length > 0">
                    <li class="entity-terms__tags--list-item" @click="addTerm(term)" v-for="term in filteredTerms">
                        <span v-html="highlightedTerm(term)"></span>
                    </li>
                </ul>
            </div>
        </template>
    </mc-popover>

    <mc-multiselect v-if="!allowInsert && editable" :model="entity.terms[this.taxonomy]" :title="title" :items="terms" @open="loadTerms()" #default="{popover}">
        <button class="button button--rounded button--sm button--icon button--primary" @click="popover.toggle()" >
            <?php i::_e("Adicionar nova") ?>
            <mc-icon name="add"></mc-icon>
        </button>
    </mc-multiselect>
    <mc-tag-list :editable="editable" :classes="entity.__objectType+'__background'" :tags="entity.terms[this.taxonomy]"></mc-tag-list>
</div>