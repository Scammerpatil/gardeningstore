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
            <button class="btn btn-error" id="clear_cart">Clear Cart</button>
            <button id="placeOrder" class="btn btn-primary">Checkout</button>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cartContainer = document.getElementById("cart-container");
        const totalAmountElement = document.getElementById("total-amount");
        const clearCartButton = document.getElementById("clear_cart");
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        const place_order = document.getElementById("placeOrder");

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
                cartItem.setAttribute("data-index", index);

                cartItem.innerHTML = `
                <figure><img src="${item.image}" class="h-48 w-full object-contain"></figure>
                <div class="card-body text-center">
                    <h3 class="card-title">${item.name}</h3>
                    <p class="text-lg font-semibold">₹${item.price.toFixed(2)}</p>
                    <p>Quantity: <span class="qty" data-index="${index}">${item.quantity}</span></p>
                    <div class="card-actions justify-center">
                        <button class="btn btn-sm btn-primary qty-plus" data-index="${index}">+</button>
                        <button class="btn btn-sm btn-secondary qty-minus" data-index="${index}">-</button>
                        <button class="btn btn-sm btn-error remove-item" data-index="${index}">Remove</button>
                    </div>
                </div>
            `;

                cartContainer.appendChild(cartItem);
            });

            totalAmountElement.textContent = totalAmount.toFixed(2);
            localStorage.setItem("cart", JSON.stringify(cart));
        }

        cartContainer.addEventListener("click", function (event) {
            const index = event.target.getAttribute("data-index");
            if (index === null) return;

            if (event.target.classList.contains("qty-plus")) {
                updateQuantity(index, 1);
            } else if (event.target.classList.contains("qty-minus")) {
                updateQuantity(index, -1);
            } else if (event.target.classList.contains("remove-item")) {
                removeFromCart(index);
            }
        });

        function updateQuantity(index, change) {
            index = parseInt(index);
            cart[index].quantity += change;
            if (cart[index].quantity <= 0) cart.splice(index, 1);
            updateCartDisplay();
        }

        function removeFromCart(index) {
            index = parseInt(index);
            cart.splice(index, 1);
            updateCartDisplay();
        }

        clearCartButton.addEventListener("click", function () {
            if (confirm("Are you sure you want to clear your cart?")) {
                localStorage.removeItem("cart");
                cart = [];
                updateCartDisplay();
            }
        });

        place_order.addEventListener("click", function () {
            placeOrder();
        });

        function placeOrder() {
            if (cart.length === 0) {
                alert("Your cart is empty!");
                return;
            }

            fetch("../../server/user/place_order.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(cart)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.success);
                        localStorage.removeItem("cart");
                        window.location.href = "orders.php";
                    } else {
                        alert("Error: " + data.error);
                    }
                })
                .catch(error => console.error("Error:", error));
        }


        updateCartDisplay();
    });

</script>

<?php
$page_content = ob_get_clean();
include './components/layout.php';
?>