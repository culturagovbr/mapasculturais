<?php
use MapasCulturais\i;
$this->import('
    confirm-button
    mc-icon
    select-entity
');
?>

<div :class="classes" v-if="entity.seals.length > 0 || editable" class="entity-seals">
    <h4 class="entity-seals__title"> {{title}} </h4>

    <div class="entity-seals__seals">
        
        <div class="entity-seals__seals--seal" v-for="seal in entity.seals">
            <div v-if="seal.files?.avatar" class="image">
                <img :src="seal.files.avatar?.transformations?.avatarSmall?.url">
            </div>
            <div v-if="editable" class="icon">
                <confirm-button @confirm="removeSeal(seal)">
                    <template #button="modal">
                        <mc-icon @click="modal.open()" name="delete"></mc-icon>
                    </template> 
                    <template #message="message">
                        <?php i::_e('Remover selo?') ?>
                    </template> 
                </confirm-button>
            </div>
        </div>  
        
        <select-entity v-if="editable" type="seal" @select="addSeal($event)" :query="query" openside="down-right">    
            <template #button="{ toggle }">
                <div class="entity-seals__seals--addSeal" @click="toggle()">
                    <mc-icon name="add"></mc-icon>
                </div>
            </template>
        </select-entity>
    </div>   
</div>