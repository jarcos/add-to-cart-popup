document.querySelectorAll('.add_to_cart_button').forEach((button) => {
  button.addEventListener('click', (e) => {
    // AJAX Call to get Product info
    jQuery.ajax({
      url: ATCP_AJAX.ajaxUrl,
      type: 'post',
      data: {
        action: 'atcp_get_product_info',
        product_id: jQuery(button).data('product_id'),
      },
      success: function (response) {
        // Insert popup notification html into the DOM
        jQuery('body').append(`
        <div class="atcp-popup" style="${
          ATCP_AJAX.position === 'position-top' ? 'top: 1rem;' : 'bottom: 1rem;'
        }">
            ${
              ATCP_AJAX.layout === 'layout-bg'
                ? atcp_bg_image(response.data)
                : atcp_left_image(response.data)
            }
        </div>
        `);
      },
      fail: function (response) {
        console.log(response);
      },
    });
    // setTimeout(() => {
    //   jQuery('.atcp-popup').remove();
    // }, ATCP_AJAX.close * 1000);
  });
});

// Create popup HTML for Left Image
function atcp_left_image(product) {
  return `
  <div class="atcp-popup--content-left">
    <div class="atcp-popup--content-left__img">
        <img src="${product.image}" alt="${product.name}" />
    </div>
    <div class="atcp-popup--content-left__content">
        <h3>${product.name}</h3>
        <span>${product.price} ${product.currency}</span>
    </div>
    <div class="atcp-popup--content-left__actions">
        <a href="${product.permalink}">View Product</a>
    </div>
  </div>
  `;
}

// Create popup HTML for Backgorund Image
function atcp_bg_image(product) {
  return `
    <div class="atcp-popup--content-bg">
        <div class="atcp-popup--content-bg__img">
            <img src="${product.image}" />
        </div>
        <div class="atcp-popup--content-bg__content">
            <h3>${product.name}</h3>
            <span>${product.price} ${product.currency}</span>
        </div>
        <div class="atcp-popup--content-bg__actions">
            <a href="${product.permalink}">View Product</a>
        </div>
    </div>
    `;
}

/*
jQuery(document.body).on(
  'added_to_cart',
  function (fragments, cart_hash, thisbutton) {
    console.log(fragments, cart_hash, thisbutton);
    // Insert popup notification html into the DOM
    jQuery('body').append(`
    <div class="atcp-popup">
        ${cart_hash['div.widget_shopping_cart_content']}
    </div>`);
  },
);
*/
