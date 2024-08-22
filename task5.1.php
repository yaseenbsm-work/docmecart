<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_email']) || isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
    header("Location: task7.php"); // Redirect to login if not logged in or is an admin
    exit();
}

// Database connection
$servername = "localhost";
$username = "yaseen";
$password = "Yaseen@123";
$dbname = "own_cart";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information
$email = $_SESSION['user_email'];
$stmt = $conn->prepare("SELECT full_name FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($fullName);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Own Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #e0f2f1; /* Light green background */
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-color: #004d40;
            padding: 10px;
            border-radius: 10px; /* Rounded corners */
        }

        .header-container img {
            margin-right: 20px;
        }

        .header-container h1 {
            margin: 0;
            color: #ffffff; /* White text color for header */
            font-size: 24px;
            flex-grow: 1; /* Allows header title to take up space */
            text-align: center;
        }

        .search-container {
            display: flex;
            align-items: center;
            justify-content: center; /* Center search input */
            flex-grow: 1;
        }

        .search-container input {
            border: 2px solid #004d40; /* Dark green border */
            border-radius: 25px; /* More pronounced oval shape */
            padding: 10px;
            margin-right: 70px;
            font-size: 16px;
            width: 200px;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Slightly darker shadow */
        }

        .search-container input:focus {
            border-color: #00796b; /* Lighter dark green border on focus */
        }

        .search-container button {
            background: url('searchy.png') no-repeat center;
            background-size: cover;
            width: 40px;
            height: 40px;
            border: none;
            cursor: pointer;
        }

        .cart-btn {
            background: linear-gradient(to right, #004d40, #00796b); /* Dark green gradient */
            color: #ffffff;
            background-size: cover;
            width: 50px;
            height: 40px;
            border: none;
            cursor: pointer;
            margin-left: 10px;
        }

        .sort-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .sort-container label {
            font-family: Arial, sans-serif;
            font-size: 18px;
            color: #004d40; /* Dark green for label */
            margin-right: 10px;
        }

        #sort {
            border-radius: 25px; /* More pronounced oval shape */
            padding: 10px;
            font-size: 16px;
            border: 2px solid #004d40; /* Dark green border */
            background: #ffffff; /* White background for the select box */
            color: #333; /* Dark text color for readability */
        }

        #sort option {
            background: #ffffff; /* White background for options */
            color: #333; /* Dark text color for options */
        }

        #mobiles-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .mobile {
            border: 1px solid #004d40; /* Dark green border */
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            background: #ffffff; /* White background for mobile items */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Darker shadow for better visibility */
            position: relative; /* Position relative for button positioning */
        }

        .mobile img {
            max-width: 100%;
            height: 150px; /* Adjust height */
            border-radius: 10px;
        }

        .add-to-cart-btn {
            display: inline-flex;
            margin-top: 10px;
            padding: 10px 20px;
            border: none;
            background: linear-gradient(to right, #004d40, #00796b); /* Dark green gradient */
            color: white; /* White text color */
            font-size: 16px;
            border-radius: 25px; /* Rounded corners */
            cursor: pointer;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Slightly darker shadow */
            transition: background 0.3s ease; /* Smooth transition */
        }

        .add-to-cart-btn:hover {
            background: linear-gradient(to right, #00796b, #004d40); /* Reverse gradient on hover */
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination button {
            margin: 0 5px;
            padding: 10px 20px;
            border: none;
            background-image: linear-gradient(to right, #004d40, #00796b); /* Dark green gradient */
            color: white; /* White text color */
            cursor: pointer;
            border-radius: 25px; /* More pronounced oval shape */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Slightly darker shadow */
        }

        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: #d0d0d0; /* Lighter background for disabled buttons */
            color: #666; /* Darker text color for disabled buttons */
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4); /* Black background with opacity */
        }

        .modal-content {
            background-color: #ffffff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Width of the modal */
            max-width: 800px;
            border-radius: 10px; /* Rounded corners */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #004d40;
            color: white;
        }

        .remove-from-cart-btn {
            background: linear-gradient(to right, #e53935, #d32f2f); /* Red gradient */
            color: white; /* White text color */
            border: none;
            border-radius: 25px; /* Rounded corners */
            cursor: pointer;
            padding: 5px 10px;
        }

        .remove-from-cart-btn:hover {
            background: linear-gradient(to right, #d32f2f, #e53935); /* Reverse gradient on hover */
        }
        /* Sell Button Styles */
/* Sell Container Styles */
.sell-container {
    display: flex;
    justify-content: center; /* Center the button horizontally */
    border: 1px solid #004d40; /* Dark green border */
    border-radius: 10px;
    padding: 10px; /* Adjust padding to fit the centered button */
    background: #ffffff; /* White background for sell container */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Darker shadow for better visibility */
    position: relative; /* Position relative for button positioning */
}

/* Sell Button Styles */
.sell-btn {
    background: linear-gradient(to right, #004d40, #00796b); /* Dark green gradient */
    color: #ffffff;
    border: none;
    padding: 10px 60px;
    border-radius: 15px; /* Rounded corners */
    cursor: pointer;
    font-size: 16px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Slightly darker shadow */
    transition: background 0.3s ease; /* Smooth transition */
    white-space: nowrap; /* Prevent text wrapping */
}

.sell-btn:hover {
    background: linear-gradient(to right, #00796b, #004d40); /* Reverse gradient on hover */
}

/* Modal Styles */
#sell-modal .modal-content {
    width: 90%;
    max-width: 500px;
    padding: 40px;
}

#sell-modal form div {
    margin-bottom: 15px;
}

#sell-modal form label {
    display: block;
    margin-bottom: 5px;
}

#sell-modal form input {
    width: 100%;
    padding: 8px;
    border: 2px solid #004d40;
    border-radius: 25px; /* More pronounced oval shape */
}

#sell-modal form button {
    background: linear-gradient(to right, #004d40, #00796b); /* Dark green gradient */
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 25px; /* Rounded corners */
    cursor: pointer;
    font-size: 16px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Slightly darker shadow */
    transition: background 0.3s ease; /* Smooth transition */
}

#sell-modal form button:hover {
    background: linear-gradient(to right, #00796b, #004d40); /* Reverse gradient on hover */
}
footer {
    padding: 10px;
    display: flex;
    justify-content: center; 
    background: linear-gradient(to right, #00796b, #004d40); /* Reverse gradient on hover */
    color:white; 
    padding: 2px;
    text-align: center;
    border-radius: 10px; /* Rounded corners */
    margin-top: 20px;
}

footer a {
    color:white; 
    text-decoration: none;
    font-weight: bold;
}

footer a:hover {
    text-decoration: underline;
}
/* Cart Footer Styles */
.cart-footer {
    margin-top: 20px;
    text-align: right;
}

#proceed-to-pay-btn {
    background: linear-gradient(to right, #004d40, #00796b); /* Dark green gradient */
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 25px; /* Rounded corners */
    cursor: pointer;
    font-size: 16px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Slightly darker shadow */
    transition: background 0.3s ease; /* Smooth transition */
}

#proceed-to-pay-btn:hover {
    background: linear-gradient(to right, #00796b, #004d40); /* Reverse gradient on hover */
}

#total-price {
    font-size: 18px;
    font-weight: bold;
    color: #004d40; /* Dark green color */
}

        
    </style>

</head>
<body>
    <div class="container">
        <div class="header-container">
            <img src="docme.png" alt="Logo" width="200px">
            <div class="search-container">
                <input type="text" id="search" placeholder="Search by name">
            </div>
            <button class="cart-btn" id="cart-btn"><img src="cart.png" width="40px" alt=""></button>
        </div>

        <div class="sort-container">
            <label for="sort">SORT BY:</label>
            <select id="sort">
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="rating-asc">Rating: Low to High</option>
                <option value="rating-desc">Rating: High to Low</option>
            </select>
        </div>

        <div id="mobiles-list"></div>
        <footer>
    <a href="logout.php">LOGOUT</a>
</footer>

        <div class="pagination">
            <button id="prev-btn" disabled>Previous</button>
            <button class="page-btn" data-page="1">1</button>
            <button class="page-btn" data-page="2">2</button>
            <button class="page-btn" data-page="3">3</button>
            <button id="next-btn">Next</button>
        </div>

    </div>
    <div id="sell-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Sell a Mobile</h2>
        <form id="sell-form">
            <div>
                <label for="photo">Photo URL:</label>
                <input type="text" id="photo" name="photo" placeholder="Enter image URL">
            </div>
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter mobile name">
            </div>
            <div>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" placeholder="Enter price">
            </div>
            <div>
                <label for="rating">Rating:</label>
                <input type="number" id="rating" name="rating" step="0.1" placeholder="Enter rating">
            </div>
            <button type="submit">Add to List</button>
        </form>
    </div>
</div>
    <!-- Cart Modal -->
<!-- Cart Modal -->
<div id="cart-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Your Cart</h2>
        <table id="cart-table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Cart items will be appended here -->
            </tbody>
        </table>
        <div class="cart-footer">
            <button id="proceed-to-pay-btn">Proceed to Pay</button>
            <p id="total-price">Total Price: ₹0</p>
        </div>
    </div>
</div>
<?php include 'popup.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const itemsPerPage = 7;
    let currentPage = 1;
    let sortOrder = 'price-asc';
    let searchQuery = '';
    let cart = [];
    $('#welcome-popup').show();
    $('.close-popup').on('click', function() {
            $('#welcome-popup').hide();
        });
        $(window).on('click', function(event) {
            if ($(event.target).is('#welcome-popup')) {
                $('#welcome-popup').hide();
            }
        });
        
function fetchMobiles(page = 1) {
    $.ajax({
        url: 'fetch_mobiles.php',
        method: 'GET',
        data: {
            page: page,
            sort: sortOrder,
            search: searchQuery
        },
        success: function(data) {
            $('#mobiles-list').empty();
            
            if (data.length > 0) {
                data.forEach(mobile => {
                    $('#mobiles-list').append(`
                        <div class="mobile" data-id="${mobile.id}">
                            <img src="${mobile.photo}" alt="${mobile.name}">
                            <h3>${mobile.name}</h3>
                                                        <p>${mobile.rating}</p>

                            <p>₹${mobile.price}</p>
                            <button class="add-to-cart-btn" data-name="${mobile.name}" data-price="${mobile.price}">Add to Cart</button>
                        </div>
                    `);
                });
            } else {
                $('#mobiles-list').append('<p>No mobiles found.</p>');
            }
            
            $('#mobiles-list').append(`
                <div class="mobile sell-container">
                    <button class="sell-btn">Sell a Mobile</button>
                </div>
            `);

            updatePaginationButtons();
        },
        error: function() {
            alert('Error fetching mobiles.');
        }
    });
}
    function openSellModal() {
        $('#sell-modal').show();
    }

    function closeSellModal() {
        $('#sell-modal').hide();
    }

    $('#mobiles-list').on('click', '.sell-btn', openSellModal);

    $('#sell-modal .close').on('click', closeSellModal);

    $('#sell-form').on('submit', function(event) {
        event.preventDefault();

        const photo = $('#photo').val();
        const name = $('#name').val();
        const price = parseFloat($('#price').val());
        const rating = parseFloat($('#rating').val());

        if (photo && name && !isNaN(price) && !isNaN(rating)) {
            $.ajax({
                url: 'add_mobile.php', // PHP script to handle adding a new mobile to the database
                method: 'POST',
                data: { photo, name, price, rating },
                success: function() {
                    closeSellModal();
                    fetchMobiles(currentPage);
                    alert(`${name} has been added to the list.`);
                },
                error: function() {
                    alert('Error adding mobile.');
                }
            });
        } else {
            alert('Please fill in all fields correctly.');
        }
    });

// Function to update the cart table and display the cart items
function updateCartTable() {
    $('#cart-table tbody').empty();
    cart.forEach((item, index) => {
        $('#cart-table tbody').append(`
            <tr>
                <td><input type="checkbox" class="cart-item-checkbox" data-index="${index}"></td>
                <td>${item.name}</td>
                <td>₹${item.price.toFixed(2)}</td> <!-- Ensure price is formatted to two decimal places -->
                <td><button class="remove-from-cart-btn" data-index="${index}">Remove</button></td>
            </tr>
        `);
    });
    updateTotalPrice(); // Ensure total price is updated when table is refreshed
}

// Function to calculate and display the total price of selected items
function updateTotalPrice() {
    let totalPrice = 0;
    $('.cart-item-checkbox:checked').each(function() {
        const index = $(this).data('index');
        if (index !== undefined && index < cart.length) {
            // Ensure the price is treated as a number
            const price = parseFloat(cart[index].price);
            totalPrice += isNaN(price) ? 0 : price; // Add price if it's a valid number
        }
    });
    $('#total-price').text(`Total Price: ₹${totalPrice.toFixed(2)}`); // Display the total price formatted to two decimal places
}

// Function to show the cart modal
function openCartModal() {
    $('#cart-modal').show();
    updateCartTable(); // Update the table when the modal is opened
}

// Function to hide the cart modal
function closeCartModal() {
    $('#cart-modal').hide();
}

// Event listener to open the cart modal
$('#cart-btn').on('click', openCartModal);

// Event listener to close the cart modal
$('.modal .close').on('click', closeCartModal);

// Event listener to add an item to the cart
$(document).on('click', '.add-to-cart-btn', function() {
    const name = $(this).data('name');
    const price = parseFloat($(this).data('price')); // Convert to float for consistent numerical operations
    if (!isNaN(price)) {
        cart.push({ name, price });
        alert(`${name} has been added to your cart.`);
        updateCartTable(); // Refresh the cart table to reflect changes
    } else {
        console.error('Invalid price value'); // Handle invalid price value
    }
});

// Event listener to remove an item from the cart
$('#cart-table').on('click', '.remove-from-cart-btn', function() {
    const index = $(this).data('index');
    if (index !== undefined && index < cart.length) {
        cart.splice(index, 1); // Remove item from the cart array
        updateCartTable(); // Refresh the cart table to reflect changes
    }
});

// Event listener to update the total price when a checkbox is changed
$('#cart-table').on('change', '.cart-item-checkbox', updateTotalPrice);

// Event listener to proceed to payment
$('#proceed-to-pay-btn').on('click', function() {
    const selectedItems = [];
    $('.cart-item-checkbox:checked').each(function() {
        const index = $(this).data('index');
        if (index !== undefined && index < cart.length) {
            selectedItems.push(cart[index]); // Collect selected items
        }
    });

    if (selectedItems.length > 0) {
        let totalAmount = selectedItems.reduce((sum, item) => sum + item.price, 0);
        const upiId = "8547196822@paytm"; // Replace with your UPI ID
        const payeeName = "DocmeCart"; // Replace with the payee name

        // Construct the UPI payment URL
        const upiUrl = `upi://pay?pa=${upiId}&pn=${payeeName}&mc=0000&tid=1234567890&tt=123456&am=${totalAmount.toFixed(2)}&cu=INR&url=`;

        // Redirect to UPI payment page
        window.location.href = upiUrl;
    } else {
        alert('Please select items to proceed to payment.');
    }
});

    $('#prev-btn').on('click', function() {
        if (currentPage > 1) {
            currentPage--;
            fetchMobiles(currentPage);
        }
    });

    $('#next-btn').on('click', function() {
        currentPage++;
        fetchMobiles(currentPage);
    });

    $('.page-btn').on('click', function() {
        currentPage = $(this).data('page');
        fetchMobiles(currentPage);
    });

    function updatePaginationButtons() {
        $('#prev-btn').prop('disabled', currentPage === 1);
        $('#next-btn').prop('disabled', currentPage === Math.ceil(mobiles.length / itemsPerPage));
        $('.page-btn').removeClass('active');
        $(`.page-btn[data-page="${currentPage}"]`).addClass('active');
    }

    $('#sort').on('change', function() {
        sortOrder = $(this).val();
        fetchMobiles(currentPage);
    });

    $('#search').on('input', function() {
        searchQuery = $(this).val().toLowerCase();
        fetchMobiles(currentPage);
    });

    fetchMobiles(currentPage);
});
</script>
</body>
</html>
