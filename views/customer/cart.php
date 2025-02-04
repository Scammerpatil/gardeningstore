<?php
$page_title = "Your Cart";
ob_start();
?>

<section class="container mx-auto py-10">
    <h1 class="text-4xl font-bold text-center">Your Cart</h1>

    <!-- Cart Items Container -->
    <div id="cart-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <!-- Cart items will be loaded here dynamically -->
    </div>

    <!-- Total & Checkout Section -->
    <div class="mt-8 text-center">
        <h2 class="text-2xl font-bold">Total Amount: ₹<span id="total-amount">0.00</span></h2>
        <div class="flex justify-center gap-4 mt-4">
            <button onclick="clearCart()" class="btn btn-error">Clear Cart</button>
            <button onclick="placeOrder()" class="btn btn-primary">Checkout</button>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const cartContainer = document.getElementById("cart-container");
        const totalAmountElement = document.getElementById("total-amount");

        function updateCartDisplay() {
            cartContainer.innerHTML = "";
            let totalAmount = 0;

            if (cart.length === 0) {
                cartContainer.innerHTML = "<p class='text-center text-lg'>Your cart is empty.</p>";
                totalAmountElement.textContent = "0.00";
                return;
            }

            cart.forEach((item, index) => {
                totalAmount += item.price * item.quantity;

                const cartItem = document.createElement("div");
                cartItem.classList.add("card", "bg-base-100", "shadow-xl", "p-5");

                cartItem.innerHTML = `
                    <figure><img src="${item.image}" class="h-48 w-full object-contain"></figure>
                    <div class="card-body text-center">
                        <h3 class="card-title">${item.name}</h3>
                        <p class="text-lg font-semibold">₹${item.price.toFixed(2)}</p>
                        <p>Quantity: <span id="qty-${index}">${item.quantity}</span></p>
                        <div class="card-actions justify-center">
                            <button class="btn btn-sm btn-primary" onclick="updateQuantity(${index}, 1)">+</button>
                            <button class="btn btn-sm btn-secondary" onclick="updateQuantity(${index}, -1)">-</button>
                            <button class="btn btn-sm btn-error" onclick="removeFromCart(${index})">Remove</button>
                        </div>
                    </div>
                `;
                cartContainer.appendChild(cartItem);
            });

            totalAmountElement.textContent = totalAmount.toFixed(2);
            localStorage.setItem("cart", JSON.stringify(cart));
        }

        function updateQuantity(index, change) {
            cart[index].quantity += change;
            if (cart[index].quantity <= 0) cart.splice(index, 1);
            updateCartDisplay();
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartDisplay();
        }

        function clearCart() {
            localStorage.removeItem("cart");
            updateCartDisplay();
        }

        function placeOrder() {
            if (cart.length === 0) {
                alert("Your cart is empty!");
                return;
            }

            fetch("place_order.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(cart)
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    localStorage.removeItem("cart");
                    window.location.href = "orders.php";
                });
        }

        updateCartDisplay();
    });
</script>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>