'use strict';

/**
 * Provides interface for communicating to ProductAPI.
 *
 * @param {string} method The type of request.
 * @param {string} url The request URL.
 * @param {object|null} body Body to send with request. Optional.
 * @return {Promise<object>} Request results.
 */
const productAPI = async function(method, url, body = null) {
  const options = {
    method: method || 'GET',
    headers: {
      'content-type': 'application/json',
      Authorization: "Basic: It's a secret to everybody",
      'X-Api-Key': '12345password'
    }
  };

  if (body) {
    options.body = JSON.stringify(body);
  }

  const response = await fetch(url, options);
  if (!response.ok) {
    window.console.log(`Response was not ok: ${response.message}`);
  }

  // If the status is 204 (no content), just return the value of ok.
  if (response.status === 204) {
    return response.ok;
  }

  return await response.json();
};

/**
 * Map fetch produt button to lookup product, set name in input.
 */
function initButtons() {
  const fetchProductButton = document.getElementById('fetch-product-button');
  const productNameDisplay = document.getElementById('product-name-display');

  // Fetch Product.
  fetchProductButton.on('click', function(e) {
    e.preventDefault();
    const productInput = document.getElementById('product-input-field');

    if (!productInput.value || !productInput.value.length) {
      alert('You must enter a Product ID');
    } else {
      const response = productAPI('GET', 'https://example.com/api/', { id: productInput.value });
      if (reponse.data && response.data.name) {
        productNameDisplay.value = response.data.name;
      }
    }
  });
}

document.addEventListener('DOMContentLoaded', initButtons);
