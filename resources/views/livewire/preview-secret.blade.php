<div class="row">
    <div class="col-md-12">
        <div class="row d-flex justify-content-center text-center">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <h2 class="fw-bolder">Your secret was generated successfully!</h2>
                <h6>Send the link below to your desired recipient. The secret will be deleted after viewing, or when it expires.</h6>
                <small class="fw-bolder">You'll only see this link once!</small>
            </div>  
        </div>

        <div class="row d-flex justify-content-center mt-3">
            <div class="col-sm-12 col-md-8 col-lg-6">
                <input class="form-control" id="secretUrl" disabled readonly value={{ $generatedUrl }}>
            </div>
        </div>
    </div>
</div>