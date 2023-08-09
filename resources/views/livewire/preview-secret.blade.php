<x-slot name="scripts">
    <script src="{{ mix('build/js/livewire/preview-secret.js') }}" type="text/javascript"></script>
</x-slot>

<div class="row">
    <div class="col-md-12">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <h2 class="fw-bolder">Your Secret Was Generated Successfully!</h2>
                <h6 class="fst-italic">Send the link below to your desired recipient. The secret will be deleted after viewing, or when it expires.</h6>
                <small class="fw-bolder">You'll only see this link once!</small>
            </div>  
        </div>

        <div class="row d-flex justify-content-center mt-3">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <div class="input-group">
                    <input class="form-control" id="secret-url" disabled readonly wire:model="generatedUrl">
                    <span role="button" class="input-group-text" id="copy-secret"><i class="bi bi-clipboard"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>