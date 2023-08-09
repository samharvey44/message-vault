<x-slot name="scripts">
    <script src="{{ mix('build/js/livewire/view-secret.js') }}" type="text/javascript"></script>
</x-slot>

<div class="row">
    <div class="col-md-12">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <h2 class="fw-bolder">View Your Secret</h2>
                <h6 class="fst-italic">Your secret can be found below, including any files that were attached.</h6>
                <small class="fw-bolder">You'll only be able to see this once before it is deleted!</small>
            </div>  
        </div>

        <div class="row d-flex justify-content-center mt-3">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <textarea class="form-control" rows="10" id="secret-text" disabled readonly style="resize: none" wire:model="secretText"></textarea>

                <div class="d-flex mt-3">
                    @if(isset($files) && $files->count() && !$filesDownloaded)
                        <button class="btn btn-secondary btn-sm ms-auto" id="download-files" type="button" wire:click="downloadFiles"><i class="bi bi-cloud-arrow-down"></i> Download Files</button>
                    @endif

                    <button 
                        @class(["btn btn-primary btn-sm ms-1", "ms-auto" => !isset($files) || !$files->count() || $filesDownloaded]) 
                        id="copy-secret" 
                        type="button"
                    >
                        <i class="bi bi-clipboard"></i> Copy Secret
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>