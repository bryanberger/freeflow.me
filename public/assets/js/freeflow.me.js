$(function () {
  var shippingRate = 26.0
  var fadeTime = 125
  var total
  var coupon = {
    value: 0,
    code: '',
  }
  //var discount = 0;

  function updateQuantityIcon(val) {
    if (val == 0) {
      $('.cart-quantity').hide()
      return
    }

    $('.cart-quantity').fadeOut(250, function () {
      $(this).fadeIn(250)
      $('.cart-quantity').text(val)
    })
  }

  function shake($highlightElem, $element) {
    // highlight error
    $highlightElem.addClass('highlight')

    // error
    $element.addClass('animated shake')
    setTimeout(function () {
      $element.removeClass('animated shake')
    }, 1000)
  }

  // coupons
  $('#applycoupon').on('click', function () {
    $coupon = $('#coupon')

    $.ajax({
      url: '/buy/validate',
      type: 'post',
      data: { coupon: $coupon.val() },
      success: function (data) {
        json = JSON.parse(data)

        if (typeof json.success !== 'undefined' && $.isNumeric(json.success)) {
          coupon.value = json.success
          coupon.id = $coupon.val()
          $coupon.removeClass('highlight')

          recalculateCart()
        } else {
          coupon.value = 0
          shake($coupon, $coupon)
          recalculateCart()
        }
      },
      error: function (data) {
        coupon.value = 0
        shake($coupon, $coupon)
        recalculateCart()
      },
    }) // end ajax call
  })

  // Trigger animation on Add to Cart button click
  function addtocartclick() {
    $(this).addClass('active')
    $('.addtocart').off('click')

    $.ajax({
      url: 'buy/' + $(this).data('id'),
      type: 'post',
      data: { size: $(this).data('size') },
      success: function (data) {
        json = JSON.parse(data)

        if (typeof json.success !== 'undefined' && $.isNumeric(json.success)) {
          //console.log("Item Added!");
          updateQuantityIcon(json.success)
        } else {
          //console.log("Item Failed");
        }
      },
      error: function (data) {
        //console.log("Ajax Error!");
      },
    }) // end ajax call

    setTimeout(function () {
      $('.addtocart').removeClass('active')
      $('.addtocart').on('click', addtocartclick)
    }, 1000)
  }
  $('.addtocart').on('click', addtocartclick)

  // Checkout click handler
  $('.checkout').on('click', function () {
    if ($('.country').val() == '--') {
      shake($('.country'), $('.checkout'))
      return
    }

    $('.country').removeClass('highlight')

    var desc
    var handler = StripeCheckout.configure({
      key: stripeToken,
      shippingAddress: true,
      billingAddress: false,
      allowRememberMe: true,
      zipCode: true,
      image: '//freeflow.me/assets/imgs/secure.png',
      token: function (token, args) {
        $.ajax({
          url: '/buy/checkout',
          type: 'post',
          data: {
            token: token.id,
            email: token.email,
            card: token.card,
            coupon_id: coupon.id,
            coupon_value: coupon.value,
          },
          success: function (data) {
            json = JSON.parse(data)

            if (typeof json.success !== 'undefined') {
              ga('send', 'event', 'buy', 'checkout', 'complete')
              $('.shopping-cart').html(
                '<h3><span>Success!</span> Check your email for your order confirmation.</h3><p>We use a 3rd party printing company to produce the freeflows. Typically orders will take 5-10 business days for a complete turnaround.</p><p>The smaller 12x12" prints ship flat. The larger 24x24" prints ship in a heavy duty tube. We will send you an email with your tracking number once it has shipped!</p>',
              )
              removeAllItems()
            } else {
              ga('send', 'event', 'buy', 'checkout', 'error')
              //console.log("Success Error...");
            }
          },
          error: function (data) {
            ga('send', 'event', 'buy', 'checkout', 'error')
            //console.log("Ajax Error...");
          },
        })
      },
    })

    // call buy service
    handler.open({
      name: 'Freeflow.me',
      description: $('.cart-quantity').text() + ' print(s) ($' + total + ')',
      amount: total * 100,
    })

    return false
  })

  /* Assign actions */
  $('#coupon').keyup(function () {
    $(this).removeClass('highlight')
  })

  $('.product-quantity input').change(function () {
    updateQuantity(this)
  })

  $('.product-quantity input').keyup(function () {
    updateQuantity(this)
  })

  $('.product-removal button').click(function () {
    removeItem(this)
  })

  $('select.country').change(function () {
    if ($(this).val() != '--') {
      $('.country').removeClass('highlight')
    } else {
      $('.country').addClass('highlight')
    }

    recalculateCart()
  })

  /* Recalculate cart */
  function recalculateCart() {
    var subtotal = 0

    /* Sum up row totals */
    $('.product').each(function () {
      subtotal += parseFloat($(this).children('.product-line-price').text())
    })

    // calc shipping
    country = $('.country').val()
    if (country === 'US') {
      shippingRate = 7.0
    } else if (country === 'CA') {
      shippingRate = 15.0
    } else if (country === '--') {
      shippingRate = 0.0
    } else {
      shippingRate = 26.0
    }

    /* Calculate totals */
    // var tax = subtotal * taxRate;
    var shipping = subtotal > 0 ? shippingRate : 0
    //var total = subtotal + tax + shipping;
    var discountValue = subtotal * (coupon.value / 100)
    total = subtotal - discountValue + shipping

    /* Update totals display */
    $('.totals-value').fadeOut(fadeTime, function () {
      $('#cart-subtotal').html(subtotal.toFixed(2))
      $('#cart-discount').html('-' + discountValue.toFixed(2))
      $('#cart-shipping').html(shipping.toFixed(2))
      $('#cart-total').html(total.toFixed(2))
      if (total == 0) {
        $('.checkout').fadeOut(fadeTime)
      } else {
        $('.checkout').fadeIn(fadeTime)
      }
      $('.totals-value').fadeIn(fadeTime)
    })
  }

  /* Update quantity */
  function updateQuantity(quantityInput) {
    /* Calculate line price */
    var productRow = $(quantityInput).parent().parent()
    var price = parseFloat(productRow.children('.product-price').text())
    var quantity = $(quantityInput).val()
    var linePrice = price * quantity

    /* Update line price display and recalc cart totals */
    productRow.children('.product-line-price').each(function () {
      $(this).fadeOut(fadeTime, function () {
        $(this).text(linePrice.toFixed(2))
        recalculateCart()
        $(this).fadeIn(fadeTime)
      })
    })

    // update service
    $.ajax({
      url: '/buy/update/' + productRow.data('id'),
      type: 'post',
      data: { qty: quantity },
      success: function (data) {
        json = JSON.parse(data)

        if (typeof json.success !== 'undefined' && $.isNumeric(json.success)) {
          //console.log("Item Quantity updated!");
          updateQuantityIcon(json.success)
        } else {
          //console.log("Item Quantity Error...");
        }
      },
      error: function (data) {
        //console.log("Ajax Error!");
      },
    })
  }

  /* Remove item from cart */
  function removeItem(removeButton) {
    /* Remove row from DOM and recalc cart total */
    var productRow = $(removeButton).parent().parent()
    productRow.slideUp(fadeTime, function () {
      productRow.remove()
      recalculateCart()
    })

    // remove single item
    $.ajax({
      url: '/buy/remove/' + productRow.data('id'),
      type: 'post',
      success: function (data) {
        json = JSON.parse(data)

        if (typeof json.success !== 'undefined' && $.isNumeric(json.success)) {
          //console.log("Item Removed!");
          updateQuantityIcon(json.success)
        } else {
          //console.log("Item Removed Error...");
        }
      },
      error: function (data) {
        //console.log("Ajax Error!");
      },
    })
  }

  function removeAllItems() {
    // destroy cart
    $.ajax({
      url: '/buy/destroy/',
      type: 'post',
      success: function (data) {
        json = JSON.parse(data)

        if (typeof json.success !== 'undefined' && $.isNumeric(json.success)) {
          //console.log("Items Removed!");
          $('.product').each(function () {
            $(this).remove()
          })
          updateQuantityIcon(json.success)
        } else {
          //console.log("Items Removed Error...");
        }
      },
      error: function (data) {
        //console.log("Ajax Error!");
      },
    })
  }

  recalculateCart()
}) // events
$(function () {
  $('.download').on('click', function () {
    var postName = $(this).data('name')
    ga('send', 'event', 'button', 'download', postName)
  })

  $('.next a').on('click', function () {
    ga('send', 'event', 'button', 'click', 'next')
  })

  $('.prev a').on('click', function () {
    ga('send', 'event', 'button', 'click', 'prev')
  })

  $('.extras a').on('click', function () {
    ga('send', 'event', 'button', 'click', 'extras')
  })

  $('.checkout').on('click', function () {
    ga('send', 'event', 'button', 'click', 'checkout')
  })

  $('.addtocart').on('click', function () {
    ga(
      'send',
      'event',
      'button',
      'addtocart',
      $(this).data('id') + '_' + $(this).data('size'),
    )
  })

  $('.remove-product').on('click', function () {
    ga('send', 'event', 'button', 'click', 'remove')
  })
})
