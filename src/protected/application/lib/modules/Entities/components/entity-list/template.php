<?php

use MapasCulturais\i;

$this->import('entities mc-link');
?>
<div v-if="this.ids.length>0" class="entity-list">
    <div class="entity-list__owner grid-12">
        <div class="col-12__owner--title">
            <h4>{{title}}</h4>
        </div>
        <entities  select="id,name,files.avatar" order="name ASC" :type="type" :query="query" #default="{entities}">
            <li class="col-12 entity-list__owner--content" v-for="entity in entities">
                <mc-link :entity="entity">
                    <div class="entity-list__owner--content-name">
                       <a class="entity-list__owner--content-name-label">{{entity.name}}</a>
                    </div>
                    <img v-if="entity.files.avatar?.transformations?.avatarSmall?.url" class="entity-list__owner--content-img" :src="entity.files.avatar?.transformations?.avatarSmall?.url">
                    <div v-else class="entity-list__owner--content-placeholder">
                        <div class="background">
                            <mc-icon name="agent-1"></mc-icon>
                        </div>
                    </div>
                </mc-link>
            </li>
        </entities>
    </div>
</div>