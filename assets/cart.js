const $ = require('jquery');

// Événement lors de l'incrémentation de la quantité
$(document).on('click', '.checkout-cart-item-plus', function() {
    let itemId = $(this).closest('tr').data('id');
    let quantity = $(this).closest('tr').attr('data-quantity');
    changeQuantity(itemId, parseInt(quantity) + 1 );
});

// Événement lors de la décrémentation de la quantité
$(document).on('click', '.checkout-cart-item-minus', function() {
    let itemId = $(this).closest('tr').data('id');
    let quantity = $(this).closest('tr').attr('data-quantity');
    if (quantity > 1){
        changeQuantity(itemId, parseInt(quantity) - 1 );
    }
});

// Événement lors de la décrémentation de la quantité
$(document).on('click', '.checkout-cart-item-remove', function() {
    let itemId = $(this).closest('tr').data('id');
    $.ajax({
        type: "delete",
        dataType: 'json',
        url : 'item/' + itemId,
        error : function (data) {
            console.error(data);
        },
        success: function (data) {
            $('#cart-item-row-' +itemId).fadeOut();
            $('#cart-order-sous-total-ht').text(data.sousTotalHT);
            $('#cart-order-reduction').text(data.reduction);
            $('#cart-order-total-shipment').text(data.totalShipment);
            $('#cart-order-total-ht').text(data.totalHT);
            $('#cart-order-total-tax').text(data.totalTax);
            $('#cart-order-total-ttc').text(data.totalTTC);
        }
    });
});

function changeQuantity(itemId, quantity){
    $.ajax({
        type: "post",
        dataType: 'json',
        data: {
            'quantity': quantity,
        },
        url : 'item/' + itemId,
        beforeSend: function () {
            $('#cart-item-row-' + itemId).find('.cart-item-quantity').html('<i class="fas fa-spinner fa-spin"></i>');
        },
        error : function (data) {
            $('#cart-item-row-' + itemId).find('.cart-item-quantity').html('<i class="fas fa-exclamation-triangle"></i>');
            console.error(data);
        },
        success: function (data) {
            $('#cart-item-row-' + itemId).attr('data-quantity', data.quantity);
            // Mise à jour du formulaire
            $('#cart-item-quantity-input-' + itemId).val(data.quantity);
            // Mise à jour de l'interface
            $('#cart-count-items').text(data.order.countItems);
            $('#cart-item-row-' + itemId).find('.cart-item-quantity').text(data.quantity);
            $('#cart-item-row-' + itemId).find('.cart-item-shipment').text(data.totalShipment);
            $('#cart-order-sous-total-ht').text(data.order.sousTotalHT);
            $('#cart-order-reduction').text(data.order.reduction);
            $('#cart-order-total-shipment').text(data.order.totalShipment);
            $('#cart-order-total-ht').text(data.order.totalHT);
            $('#cart-order-total-tax').text(data.order.totalTax);
            $('#cart-order-total-ttc').text(data.order.totalTTC);
        }
    });
}