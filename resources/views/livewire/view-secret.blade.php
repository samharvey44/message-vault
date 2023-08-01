<x-slot name="scripts">
    <script src="{{ mix('build/js/livewire/view-secret.js') }}" type="text/javascript"></script>
</x-slot>

<div class="row">
    <div class="col-md-12">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <h2 class="fw-bolder">View Your Secret</h2>
                <h6>Your secret can be found below, including any files that were attached.</h6>
                <small class="fw-bolder">You'll only be able to see this once before it is deleted!</small>
            </div>  
        </div>

        <div class="row d-flex justify-content-center mt-3">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <textarea class="form-control" rows="10" id="secret-text" disabled readonly style="resize: none" wire:model="secretText"></textarea>

                <div class="d-flex mt-3">
                    <button class="btn btn-primary btn-sm ms-auto" id="copy-secret"><i class="bi bi-clipboard"></i> Copy Secret</button>
                </div>
            </div>
        </div>
    </div>
</div>