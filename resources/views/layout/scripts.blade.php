<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.3.2.min.js"></script>
<!-- bootstrap -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- count down -->
<script src="{{ asset('assets/js/jquery.countdown.js') }}"></script>
<!-- isotope -->
<script src="{{ asset('assets/js/jquery.isotope-3.0.6.min.js') }}"></script>
<!-- waypoints -->
<script src="{{ asset('assets/js/waypoints.js') }}"></script>
<!-- owl carousel -->
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<!-- magnific popup -->
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<!-- mean menu -->
<script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
<!-- sticker js -->
<script src="{{ asset('assets/js/sticker.js') }}"></script>
<!-- main js -->
<script src="{{ asset('assets/js/main.js') }}"></script>
<!-- jqueryui js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- sweetalert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let frSearchUrl = "{{ url('/search-fruits') }}";
let selFrUrl = "{{ url('/details') }}";
let cartUrl = "{{ url('/cart') }}";
$(document).ready(function() {
    $("#prodSearch").autocomplete({
        source: function(request, response) {
            $.ajax({
                type: 'POST',
                data: {
                    keyword: $("#prodSearch").val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                url: frSearchUrl,
                success: function(data) {
                    if (Array.isArray(data) && data.length > 0) {
                        const fruitList = data.map(record => ({
                            label: record.name,
                            value: record.name,
                            id: record.fruit_id
                        }));
                        response(fruitList);
                    }
                },
                error: function(err) {
                    console.log('error:', err);
                }
            });
        },
        minLength: 2, // optional: wait until 2 chars typed
        delay: 1000, // optional: wait until 1 second
        select: function(event, ui) {
            // ui.item has {label, value, id}
            console.log("Search item selected:", ui.item);

            // Redirect to details page (example)
            window.location.href = selFrUrl + "/" + ui.item.id;
        }
    });

});
</script>