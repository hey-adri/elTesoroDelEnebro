<script>
    {{-- Adding Confirmation to delete Buttons --}}
    document.addEventListener('DOMContentLoaded',()=>{
        $('.deleteUserButton').on('click',askForUserDeleteConfirmation)
    })
    const askForUserDeleteConfirmation = ()=>{
        event.preventDefault()
        const form = $(event.target).closest('form')
        showAccountDeleteDialog(
            `{{__('Soy consciente de que eliminando la cuenta ')}} "${$(event.target).closest('button').attr(`data-username`)}", se eliminarán todas sus Búsquedas del Tesoro y Pistas.`,
            `{{__('¿Estás Seguro?')}}`,
            `{{__('Eliminar Cuenta y todos sus recursos')}}`,
            `{{__('Marca la casilla para eliminar ésta cuenta')}}`,
            ()=>{
                showLoading(`{{__("¡Hasta Pronto!")}}`,`{{__("Eliminando Cuenta...")}}`)
                form.submit()
            })
    }
</script>
