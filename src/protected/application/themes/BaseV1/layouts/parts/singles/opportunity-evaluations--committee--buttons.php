<div id="evaluation-committee-buttons" class="clearfix" style="margin-bottom: 20px;">
    <?php if($entity->canUser('sendUserEvaluations')): ?>
        <a href="<?php echo $entity->sendEvaluationsUrl ?>" class="btn btn-primary alignright"><?php \MapasCulturais\i::_e('Enviar Avaliações'); ?></a>
    <?php elseif($entity->canUser('evaluateRegistrations')): ?>
        <a class="btn btn-primary disabled hltip alignright" title="<?php \MapasCulturais\i::esc_attr_e('É necessário avaliar todas as inscrições antes de enviar') ?>"><?php \MapasCulturais\i::_e('Enviar Avaliações'); ?></a>
    <?php endif; ?>
</div>