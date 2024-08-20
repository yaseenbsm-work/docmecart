
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
        .save-edit-btn{
            background: linear-gradient(to right, #004d40, #00796b); /* Dark green gradient */
            color: #ffffff;
            background-size: cover;
            width: 50px;
            margin-top:1px;
            height: 20px;
            border: none;
            cursor: pointer;

        }
        .cancel-edit-btn{
            background: linear-gradient(to right, #004d40, #00796b); /* Dark green gradient */
            color: #ffffff;
            background-size: cover;
            width: 50px;
            margin-top:1px;
            height: 20px;
            border: none;
            cursor: pointer;

        }
        .edit-input{
            border: 2px solid #004d40; /* Dark green border */
            border-radius: 25px; /* More pronounced oval shape */
            padding: 10px;
            margin-left: 45px;
            margin-right: 50px;
            justify-content: center;
            font-size: 16px;
            width: 100px;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Slightly darker shadow */

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
        .edit-btn{
            background-image: linear-gradient(to right, #e53935,#ff6f68); /* Vibrant gradient */
            color: #ffffff;
            background-size: cover;
            width: 40px;
            height: 20px;
            border: none;
            cursor: pointer;
            margin-left: 10px;


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
    display: flex;
    justify-content: center; 
    background: linear-gradient(to right, #00796b, #004d40); /* Reverse gradient on hover */
    color:white; 
    padding: 10px;
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
/* General Modal Styles */
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

/* Modal Content Styles */
.modal-content {
    background-color: #ffffff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Width of the modal */
    max-width: 800px;
    border-radius: 10px; /* Rounded corners */
}

/* Close Button Styles */
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


/* Delete Button Styles */
#delete-btn {
    background: linear-gradient(to right, #e53935, #d32f2f); /* Red gradient */
    color: white; /* White text color */
    border: none;
    padding: 10px 20px;
    border-radius: 25px; /* Rounded corners */
    cursor: pointer;
    font-size: 16px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); /* Slightly darker shadow */
    transition: background 0.3s ease; /* Smooth transition */
}

#delete-btn:hover {
    background: linear-gradient(to right, #d32f2f, #e53935); /* Reverse gradient on hover */
}
.remove-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(to right, #e53935, #d32f2f); /* Red gradient */
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 25px;
    cursor: pointer;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    transition: background 0.3s ease;
}

.remove-btn:hover {
    background: linear-gradient(to right, #d32f2f, #e53935); /* Reverse gradient on hover */
}

.mobile {
    position: relative; /* Ensure that the remove button is positioned relative to the mobile item */
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
        <div id="message"></div>
        <footer>
<a href="task7.php">LOGOUT</a>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    const itemsPerPage = 7;
    let currentPage = 1;
    let sortOrder = 'price-asc';
    let searchQuery = '';
    let cart = [];

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
<h3 class="mobile-details">
    <span class="mobile-name">${mobile.name}</span>
    <button class="edit-btn" data-field="name">Edit</button>
</h3>
<p class="mobile-details">
    <span class="mobile-rating">${mobile.rating}</span>
    <button class="edit-btn" data-field="rating">Edit</button>
</p>
<p class="mobile-details">
    ₹<span class="mobile-price">${mobile.price}</span>
    <button class="edit-btn" data-field="price">Edit</button>
</p>                         <button class="add-to-cart-btn" data-name="${mobile.name}" data-price="${mobile.price}">Add to Cart</button>
                            <button class="remove-btn" data-id="${mobile.id}">DELETE</button>
                        </div>
                    `);
                });
                updatePaginationButtons(data.total); // Pass totalItems
            } else {
                $('#mobiles-list').append('<p>No mobiles found.</p>');
            }
            
            $('#mobiles-list').append(`
                <div class="mobile sell-container">
                    <button class="sell-btn">Sell a Mobile</button>
                </div>
            `);
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

    // Function to handle delete button click
    $('#mobiles-list').on('click', '.remove-btn', function() {
    const mobileId = $(this).data('id');
    if (confirm('Are you sure you want to delete this mobile?')) {
        $.ajax({
            url: 'delete_mobile.php',
            method: 'GET',
            data: { id: mobileId },
            success: function(response) {
                if (response.success) {
                    fetchMobiles(currentPage); // Refresh the list
                    alert('Mobile has been deleted.');
                } else {
                    alert('Error deleting mobile.');
                }
            },
            error: function() {
                alert('Error deleting mobile.');
            }
        });
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
        const upiId = "payee@upi"; // Replace with your UPI ID
        const payeeName = "Merchant"; // Replace with the payee name

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
    const page = $(this).data('page');
    currentPage = page;
    fetchMobiles(page);
});

function updatePaginationButtons(totalItems) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    $('#prev-btn').prop('disabled', currentPage === 1);
    $('#next-btn').prop('disabled', currentPage === totalPages);
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
    $('#mobiles-list').on('click', '.edit-btn', function() {
        const field = $(this).data('field'); // Get the field name
        const mobileDiv = $(this).closest('.mobile'); // Find the closest mobile container
        const mobileId = mobileDiv.data('id'); // Get the mobile ID
        const currentValue = mobileDiv.find(`.mobile-${field}`).text().trim(); // Get the current value

        // Create the edit interface
        $(this).hide(); // Hide the edit button
        const inputHtml = `
            <input type="${field === 'price' ? 'number' : 'text'}" class="edit-input" value="${currentValue}" />
            <button class="save-edit-btn" data-id="${mobileId}" data-field="${field}">Save</button>
            <button class="cancel-edit-btn">Cancel</button>
        `;
        mobileDiv.find(`.mobile-${field}`).html(inputHtml); // Replace text with input field
    });

    // Handle save button click
    $('#mobiles-list').on('click', '.save-edit-btn', function() {
        const mobileDiv = $(this).closest('.mobile'); // Find the closest mobile container
        const mobileId = $(this).data('id'); // Get the mobile ID
        const field = $(this).data('field'); // Get the field to update
        const newValue = mobileDiv.find('.edit-input').val().trim(); // Get the new value

        // Perform numeric validation for price and rating
        if (field === 'price' && isNaN(parseFloat(newValue))) {
            alert('Invalid price value.');
            return;
        }
        if (field === 'rating' && (isNaN(parseFloat(newValue)) || parseFloat(newValue) < 0 || parseFloat(newValue) > 5)) {
            alert('Invalid rating value. Rating must be between 0 and 5.');
            return;
        }

        if (newValue) {
            $.ajax({
                url: 'update_mobile.php', // PHP script to handle update
                method: 'POST',
                data: {
                    id: mobileId,
                    field: field,
                    value: newValue
                },
            success: function(response) {
                // Always refresh the mobile list
                fetchMobiles(currentPage);
            },
            error: function() {
                // Refresh the mobile list in case of error as well
                fetchMobiles(currentPage);
            }
        });        } else {
            alert('Field cannot be empty.');
        }
    });

    // Handle cancel button click
    $('#mobiles-list').on('click', '.cancel-edit-btn', function() {
        const mobileDiv = $(this).closest('.mobile'); // Find the closest mobile container
        const field = $(this).siblings('.edit-input').data('field'); // Get the field name
        const originalValue = mobileDiv.find(`.mobile-${field}`).text().trim(); // Get the original value

        mobileDiv.find('.edit-btn').show(); // Show the edit button again
        mobileDiv.find('.edit-input').remove(); // Remove input field
        mobileDiv.find('.save-edit-btn').remove(); // Remove save button
        mobileDiv.find('.cancel-edit-btn').remove(); // Remove cancel button
        mobileDiv.find(`.mobile-${field}`).text(originalValue); // Restore original value
    });
});

</script>
</body>
</html>
