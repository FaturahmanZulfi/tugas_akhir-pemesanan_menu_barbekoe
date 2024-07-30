<div>
    <div class="card col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-sm-12">
        <div class="card-body">
            <h5 class="card-title">Scan QR Code Dulu</h5>
            <div style="width: 100%" id="reader"></div>
            {{-- <a href="/login" class="btn btn-primary mt-3 col-12">Saya Pihak Barbekoe</a> --}}
        </div>
    </div>

    @assets  
    <script src="/assets/js/html5-qrcode.min.js"></script>
    @endassets
    <script>
    var html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });

    function onScanSuccess(decodedText, decodedResult) {
        // console.log(`Scan result: ${decodedText}`, decodedResult);
        if (decodedText == "BarbeKoeCoffeAndResto123") {
            html5QrcodeScanner.clear();
            @this.scanned();
        }
    }

    html5QrcodeScanner.render(onScanSuccess);
    </script>
</div>
