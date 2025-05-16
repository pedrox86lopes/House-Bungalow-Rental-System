<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Catálogo de Casas de Férias</h1>

    <?php $__currentLoopData = $bens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card mb-3">
            <div class="card-header">
                <strong><?php echo e($bem->modelo); ?></strong> — <?php echo e($bem->marca->nome); ?> (<?php echo e($bem->marca->tipoBem->nome); ?>)
            </div>
            <div class="card-body">
                <p><strong>Localização:</strong> <?php echo e($bem->localizacao->cidade); ?> - <?php echo e($bem->localizacao->filial); ?> (<?php echo e($bem->localizacao->posicao); ?>)</p>
                <p><strong>Capacidade:</strong> <?php echo e($bem->numero_hospedes); ?> hóspedes | <?php echo e($bem->numero_quartos); ?> quartos | <?php echo e($bem->numero_casas_banho); ?> WC</p>
                <p><strong>Preço por noite:</strong> €<?php echo e(number_format($bem->preco_diario, 2)); ?></p>
                <p><strong>Características:</strong> <?php echo e($bem->caracteristicas->pluck('nome')->implode(', ')); ?></p>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/pedrox86/Desktop/SoftwareDev/Projeto Laravel - Integracao Sistemas/reserva_casa/Reservas/resources/views/catalogo/index.blade.php ENDPATH**/ ?>