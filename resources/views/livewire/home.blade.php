<div class="row">
    <div class="col-md-12">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <h2 class="fw-bolder">Share a New Secret</h2>
                <h6>Simply type or paste the content of your desired secret below, and we'll do the rest!</h6>
            </div>  
        </div>

        <div class="row d-flex justify-content-center mt-3">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <form wire:submit="save">
                    <div class="mb-5">
                        <textarea class="form-control mt-1" id="secret" name="secret" rows="10" style="resize: none" placeholder="Type or paste your secret..." wire:model.blur="secret"></textarea>

                        @error('secret')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @else
                            <div class="form-text">Never store sensitive data in a chat log again.</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="expiry">Choose an expiry time</label>
                        <input class="form-control mt-1" id="expiry" name="expiry" readonly wire:model.live="expiry">

                        @error('expiry')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @else
                            <div class="form-text">The link to your secret will be invalid after this time.</div>
                        @enderror
                    </div>

                    <div class="d-flex">
                        <button @disabled($errors->isNotEmpty()) class="btn btn-primary ms-auto" type="submit"><i class="bi bi-plus-circle"></i> Generate Secret</button>
                    </div>
                </form>

                <input type="hidden" id="default-expiry" value={{ now()->addHour()->toISOString() }}>
            </div>
        </div>
    </div>
</div>