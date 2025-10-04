$(document).ready(function () {
    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();

        var $btn = $(this);
        var id = $btn.data('id');
        var name = $btn.data('name');
        var price = parseFloat($btn.data('price'));
        var refreshPage = $btn.data('refresh-page') === true || $btn.data('refresh-page') === 'true';

        $.ajax({
            url: '/api/cart.json',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                id: id,
                name: name,
                unitPrice: price,
                quantity: 1
            }),
            success: function (data) {
                if (refreshPage) {
                    location.reload();
                    return;
                }

                if (data.response.message) {
                    alert(data.response.message);
                }

                $('.cart-total').text(data.total + ' €');
                $('.cart-count').text('(' + data.count + ' položiek)');
            },
            error: function (xhr, status, error) {
                alert('Chyba pri pridávaní do košíka: ' + error);
            }
        });
    });
});
