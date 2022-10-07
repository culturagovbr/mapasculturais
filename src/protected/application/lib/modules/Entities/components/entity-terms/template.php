<?php

use MapasCulturais\i;

$this->import('popover mc-tag-list mc-multiselect')
?>
<div v-if="editable || entity.terms?.[taxonomy].length > 0" :class="['entity-terms', classes]">

    <h4 class="entity-terms__title" v-if="title == ''"> {{taxonomy}} </h4>
    <h4 class="entity-terms__title" v-else> {{title}} </h4>

    <popover v-if="allowInsert && editable" openside="down-right" @close="this.filter = ''" @open="loadTerms()">
        <template #button="popover">
            <button @click="popover.toggle()" class="button button--rounded button--sm button--icon button--primary" v-if="editable">
                <?php i::_e("Adicionar nova") ?>
                <mc-icon name="add"></mc-icon>
            </button>
        </template>

        <!-- Modo Tags -->
        <template #default="popover">
            <div class="entity-terms__tags">
                <form class="entity-terms__tags--form" @submit="addTerm(filter, popover)">
                    <input type="text" v-model="filter" class="input" placeholder="<?= i::__('Adicione uma nova tag') ?>">
                    <button class="button button--primary button--icon entity-terms__tags--form-addBtn" type="submit">
                        <mc-icon name="add"></mc-icon>
                    </button>
                </form>
                <ul class="entity-terms__tags--list" v-if="filteredTerms.length > 0">
                    <li class="entity-terms__tags--list-item" @click="addTerm(term, popover)" v-for="term in filteredTerms">
                        <span v-html="highlightedTerm(term)"></span>
                    </li>
                </ul>
            </div>
        </template>
    </popover>

    <mc-multiselect v-if="!allowInsert && editable" :model="entityTerms" :items="terms" @open="loadTerms()" #default="{popover}">
        <button @click="popover.toggle()" class="button button--rounded button--sm button--icon button--primary">
            <?php i::_e("Adicionar nova") ?>
            <mc-icon name="add"></mc-icon>
        </button>
    </mc-multiselect>
    <mc-tag-list :editable="editable" :classes="entity.__objectType+'__background'" :tags="entityTerms" @remove="remove($event)"></mc-tag-list>
</div>