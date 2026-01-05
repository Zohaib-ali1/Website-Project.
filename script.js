// Mobile menu toggle
function initMobileMenu() {
  const menuToggle = document.getElementById("menuToggle");
  const navLinks = document.getElementById("navLinks");

  if (menuToggle && navLinks) {
    menuToggle.addEventListener("click", () => {
      navLinks.classList.toggle("show");
    });

    // Close menu when clicking a link (on mobile)
    navLinks.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        navLinks.classList.remove("show");
      });
    });
  }
}

// Cart functionality
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}

function updateCartCount() {
  const cartCount = document.getElementById("cartCount");
  if (cartCount) {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;
    cartCount.style.display = totalItems > 0 ? "flex" : "none";
  }
}

// Product image mapping
const productImages = {
  1: 'img/white.jpg',
  2: 'img/denim.jpg',
  3: 'img/pants.jpg',
  4: 'img/hoodie.jpg',
  5: 'img/sneakers.jpg',
  6: 'img/coat.jpg'
};

function addToCart(productId, productName, productPrice, productImage = null) {
  const existingItem = cart.find((item) => item.id === productId);
  const image = productImage || productImages[productId] || '';

  if (existingItem) {
    existingItem.quantity += 1;
  } else {
    cart.push({
      id: productId,
      name: productName,
      price: productPrice,
      quantity: 1,
      image: image,
    });
  }

  saveCart();
  updateCartCount();
  alert(`${productName} added to cart!`);
}

function removeFromCart(productId) {
  cart = cart.filter((item) => item.id !== productId);
  saveCart();
  updateCartCount();
  renderCart();
}

function updateQuantity(productId, change) {
  const item = cart.find((item) => item.id === productId);
  if (item) {
    item.quantity += change;
    if (item.quantity <= 0) {
      removeFromCart(productId);
      return;
    }
    saveCart();
    updateCartCount();
    renderCart();
  }
}

function renderCart() {
  const cartItemsContainer = document.getElementById("cartItems");
  const cartSummary = document.getElementById("cartSummary");

  if (!cartItemsContainer) return;

  if (cart.length === 0) {
    cartItemsContainer.innerHTML = `
      <div class="empty-cart">
        <p>Your cart is empty</p>
        <a href="products.php" class="btn btn-primary">Browse Products</a>
      </div>
    `;
    if (cartSummary) {
      cartSummary.innerHTML = "";
    }
    return;
  }

  let total = 0;
  cartItemsContainer.innerHTML = cart
    .map((item) => {
      const itemTotal = item.price * item.quantity;
      total += itemTotal;
      const imageSrc = item.image || '';
      return `
      <div class="cart-item">
        <div class="cart-item-image">
          ${imageSrc ? `<img src="${imageSrc}" alt="${item.name}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">` : ''}
        </div>
        <div class="cart-item-info">
          <h3>${item.name}</h3>
          <p>Price: $${item.price.toFixed(2)} each</p>
        </div>
        <div class="cart-item-price">$${itemTotal.toFixed(2)}</div>
        <div class="quantity-controls">
          <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
          <input type="number" class="quantity-input" value="${item.quantity}" min="1" 
                 onchange="setQuantity(${item.id}, this.value)">
          <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
          <button class="btn btn-danger" onclick="removeFromCart(${item.id})" style="margin-left: 0.5rem; padding: 0.4rem 0.8rem; font-size: 0.85rem;">Remove</button>
        </div>
      </div>
    `;
    })
    .join("");

  if (cartSummary) {
    const subtotal = total;
    const tax = subtotal * 0.1; // 10% tax
    const shipping = subtotal > 50 ? 0 : 5.99;
    const grandTotal = subtotal + tax + shipping;

    cartSummary.className = 'cart-summary';
    cartSummary.innerHTML = `
      <h3>Order Summary</h3>
      <div class="summary-row">
        <span>Subtotal:</span>
        <span>$${subtotal.toFixed(2)}</span>
      </div>
      <div class="summary-row">
        <span>Tax (10%):</span>
        <span>$${tax.toFixed(2)}</span>
      </div>
      <div class="summary-row">
        <span>Shipping:</span>
        <span>${shipping === 0 ? "Free" : "$" + shipping.toFixed(2)}</span>
      </div>
      <div class="summary-row total">
        <span>Total:</span>
        <span>$${grandTotal.toFixed(2)}</span>
      </div>
      <a href="checkout.php" class="btn btn-primary" style="width: 100%; margin-top: 1rem; display: block; text-align: center; text-decoration: none;">
        Proceed to Checkout
      </a>
    `;
  }
}

function setQuantity(productId, quantity) {
  const qty = parseInt(quantity);
  if (qty > 0) {
    const item = cart.find((item) => item.id === productId);
    if (item) {
      item.quantity = qty;
      saveCart();
      updateCartCount();
      renderCart();
    }
  }
}

// Initialize on page load
document.addEventListener("DOMContentLoaded", () => {
  initMobileMenu();
  updateCartCount();
  
  // Render cart if on cart page
  if (document.getElementById("cartItems")) {
    renderCart();
  }
});

// Make functions available globally
window.addToCart = addToCart;
window.removeFromCart = removeFromCart;
window.updateQuantity = updateQuantity;
window.setQuantity = setQuantity;

