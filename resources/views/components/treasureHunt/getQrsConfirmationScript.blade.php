<script>
    {{-- Adding Confirmation to GetQr Buttons --}}
    document.addEventListener('DOMContentLoaded',()=>{
        $('.getTreasureHuntQRsButton').on('click',showQrGetLoading)
    })
    const showQrGetLoading = ()=>{
        event.preventDefault()
        const form = $(event.target).closest('form');
        showLoading(`{{__('Recibirás los códigos QR en tu correo')}} {{auth()->user()->email}}. {{__("Ten paciencia por favor, no cierres esta ventana, puede tomar un minuto.")}}`,`{{__("Generando Códigos...")}}`)
        window.setTimeout(()=>{
            form.submit()
        },500)
    }
</script>
