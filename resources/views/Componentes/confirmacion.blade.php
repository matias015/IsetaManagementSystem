<style>
    .confirmacion-popup{
        z-index: 9999999;
        position: fixed;
        
        left: 40vw;
        top: 40vh;
    }
</style>

<div class="flex-col items-center none confirmacion-popup bg-gray-300 p-2 gap-3 rounded">
    <p>¿SEGURO DE QUE DESEA REALIZAR ESTA ACCION?</p>
    <button class="p-2 bg-green-500 rounded" id="cancel-button">CANCELAR</button>
    <div class="flex w-100p just-start gap-4">
        <p class="font-3 pointer red-500 rounded" id="confirm-button">Confimar eliminación.</p>
    </div>
</div>