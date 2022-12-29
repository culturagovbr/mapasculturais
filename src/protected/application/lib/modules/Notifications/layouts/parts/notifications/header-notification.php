<?php
/** @var MapasCulturais\Theme $this */
use MapasCulturais\App;
use MapasCulturais\i;
$app = App::i();

$this->import('
    notification-modal
');
?>

<?php if (!$app->user->is('guest')): ?>
    <notification-modal v-if="$media('<?=  $media_query ?>')" #default="{modal}">
        <a @click="modal.open"><?= i::__('Notificações') ?></a>
    </notification-modal>
<?php endif; ?>