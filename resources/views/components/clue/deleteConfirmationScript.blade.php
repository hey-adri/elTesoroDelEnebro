<script>
    {{-- Adding Confirmation to delete Buttons --}}
    document.addEventListener('DOMContentLoaded',()=>{
        $('.deleteClueButton').on('click',askForClueDeleteConfirmation)
    })
    const askForClueDeleteConfirmation = ()=>{
        event.preventDefault()
        const form = $(event.target).closest('form');
        showDeleteDialog(
            `{{__('Vas a eliminar la pista con código')}} "${$(event.target).attr(`data-clueKey`)}".`,
            `{{__('¿Estás Seguro?')}}`,
            `{{__('Sí, eliminar')}}`,
            `{{__('No, cancelar')}}`,
            ()=>{
                showLoading(`{{__("Sólo será un momentito.")}}`,`{{__("Eliminando Pista...")}}`)
                form.submit()
            }
        )
    }
</script>
