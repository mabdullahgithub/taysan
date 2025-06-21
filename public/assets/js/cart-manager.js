$(document).ready(function () {
    // A simple in-memory store for cart items.
    // Key = product ID, Value = { name, price, image, quantity }
    const cart = {};

    // Update the mini-cart UI in the navbar
    function updateCartDisplay() {
        // Grab the relevant elements in your navbar’s mini-cart
        const $cartCount          = $(".cart-count");
        const $miniCartItems      = $(".mini-cart-items");
        const $miniCheckoutPrice  = $(".mini-checkout-price span");

        // Clear out existing content in .mini-cart-items
        $miniCartItems.empty();

        let totalQuantity = 0;
        let totalPrice = 0;

        // Build mini-cart items from our `cart` object
        for (const productId in cart) {
            const item = cart[productId];
            const itemTotal = item.price * item.quantity;

            totalQuantity += item.quantity;
            totalPrice += itemTotal;

            // Create a mini-cart entry with increment/decrement/remove
            // Feel free to style or structure this HTML differently
            $miniCartItems.append(`
                <div class="mini-cart-item clearfix">
                    <div class="mini-cart-item-image">
                        <a href="#"><img src="${item.image}" alt="${item.name}" width="50"></a>
                    </div>
                    <div class="mini-cart-item-des">
                        <a href="#">${item.name}</a>
                        <span class="mini-cart-item-price">
                            $${itemTotal.toFixed(2)} 
                            <small>(${item.quantity}x)</small>
                        </span>
                        <div class="cart-qty-controls">
                            <button class="decrement-btn" data-id="${productId}">-</button>
                            <button class="increment-btn" data-id="${productId}">+</button>
                            <button class="remove-item" data-id="${productId}">
                                <i class="ti-close"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `);
        }

        // Update cart count and subtotal
        $cartCount.text(totalQuantity);
        $miniCheckoutPrice.text(`$${totalPrice.toFixed(2)}`);
    }

    // Add a product to the cart (or increment if it already exists)
    function addToCart(productId, productDetails) {
        if (cart[productId]) {
            cart[productId].quantity++;
        } else {
            cart[productId] = {
                name: productDetails.name,
                price: productDetails.price,
                image: productDetails.image,
                quantity: 1,
            };
        }
        updateCartDisplay();
    }

    // Increment an item’s quantity
    function incrementItem(productId) {
        if (cart[productId]) {
            cart[productId].quantity++;
            updateCartDisplay();
        }
    }

    // Decrement an item’s quantity; remove if it hits zero
    function decrementItem(productId) {
        if (cart[productId]) {
            cart[productId].quantity--;
            if (cart[productId].quantity <= 0) {
                delete cart[productId];
            }
            updateCartDisplay();
        }
    }

    // Remove an item from the cart entirely
    function removeItem(productId) {
        if (cart[productId]) {
            delete cart[productId];
            updateCartDisplay();
        }
    }

    // Listen for clicks on “Add to Cart” buttons
    $("body").on("click", ".add-to-cart-btn", function (e) {
        e.preventDefault();

        // Find the closest .product-single-item to gather data
        const $product = $(this).closest(".product-single-item");
        const productId = $product.data("product-id");

        const productName = $product.find("h2 a").text().trim();
        const productPrice = parseFloat(
            $product.find(".present-price").text().replace("$", "")
        );
        const productImage = $product.find("img").attr("src");

        addToCart(productId, {
            name: productName,
            price: productPrice,
            image: productImage,
        });
    });

    // Listen for increment, decrement, and remove actions in the mini-cart
    $("body").on("click", ".increment-btn", function (e) {
        e.preventDefault();
        const productId = $(this).data("id");
        incrementItem(productId);
    });

    $("body").on("click", ".decrement-btn", function (e) {
        e.preventDefault();
        const productId = $(this).data("id");
        decrementItem(productId);
    });

    $("body").on("click", ".remove-item", function (e) {
        e.preventDefault();
        const productId = $(this).data("id");
        removeItem(productId);
    });
});
