<div class="container-fluid">
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
                        <div class="mb-3">
                            <textarea class="form-control" name="secret" rows="10" style="resize: none" placeholder="Enter your secret..." wire:model.live="secret"></textarea>
                            @error('secret')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @else
                                <div class="form-text">Never store sensitive data in a chat log again.</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input name="expiry">
                        </div>

                        <div class="d-flex">
                            <button @disabled($errors->isNotEmpty() || !$secret) class="btn btn-primary ms-auto" type="submit"><i class="bi bi-plus-circle"></i> Generate Secret</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>