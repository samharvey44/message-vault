<x-slot name="scripts">
    <script src="{{ mix('build/js/livewire/home.js') }}" type="text/javascript"></script>
</x-slot>

<x-slot name="styles">
    <link href="{{ mix('build/css/livewire/home.css') }}" rel="stylesheet" type="text/css" />
</x-slot>

<div class="row">
    <div class="col-md-12">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <h2 class="fw-bolder">Share a New Secret</h2>
                <h6 class="fst-italic">Simply type or paste the content of your desired secret below, and we'll do the rest!</h6>
            </div>  
        </div>

        <div class="row d-flex justify-content-center mt-3">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <form wire:submit="save">
                    <div class="mb-5">
                        <textarea class="form-control mt-1" id="secret" name="secret" rows="10" style="resize: none" placeholder="Type or paste your secret..." wire:model="secret"></textarea>

                        @error('secret')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @else
                            <div class="form-text">Never store sensitive data in a chat log again.</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="expiry">Choose an expiry time</label>
                        <input class="form-control mt-1" id="expiry" name="expiry" readonly wire:model="expiry">

                        @error('expiry')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @else
                            <div class="form-text">The link to your secret will be invalid after this time.</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="files{{ $filesUploadIteration }}">Upload files with your secret</label><br />
                        <input type="file" class="form-control mt-1" name="files" id="files{{ $filesUploadIteration }}" wire:model="files" multiple>

                        @error('files')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @else
                            @error('files.*')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @else
                                <div class="form-text">Share up to 5 files securely.</div>
                            @enderror
                        @enderror
                        
                        <button class="btn btn-sm btn-outline-secondary mt-2" type="button" wire:click="clearFiles"><i class="bi bi-x-circle"></i> Clear Files</button>
                    </div>


                    <div class="d-flex">
                        <button class="btn btn-primary ms-auto" type="submit"><i class="bi bi-plus-circle"></i> Generate Secret</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>