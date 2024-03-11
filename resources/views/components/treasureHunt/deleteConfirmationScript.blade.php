<script>
    {{-- Adding Confirmation to delete Buttons --}}
    document.addEventListener('DOMContentLoaded',()=>{
        $('.deleteTreasureHuntButton').on('click',askForDeleteConfirmation)
    })
    const askForDeleteConfirmation = ()=>{
        event.preventDefault()
        const form = $(event.target).closest('form');
        showDeleteDialog(
            `{{__('Vas a eliminar')}} "${$(event.target).closest('button').attr(`data-treasureHuntTitle`)}". {{__('¡Se eliminarán todas las pistas asociadas!')}}`,
            `{{__('¿Estás Seguro?')}}`,
            `{{__('Sí, eliminar')}}`,
            `{{__('No, cancelar')}}`,
            ()=>{
                showLoading(`{{__("Sólo será un momentito.")}}`,`{{__("Eliminando Búsqueda...")}}`)
                form.submit()
            }
        )
    }
</script>
