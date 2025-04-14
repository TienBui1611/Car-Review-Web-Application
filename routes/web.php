<?php

use Illuminate\Support\Facades\Route;

// Route to show the home page with sorting options
Route::get('/', function () {
    // Get sorting preferences from query parameters (default to 'review_count' and 'asc')
    $sortBy = request('sort_by', 'review_count');
    $sortOrder = request('sort_order', 'asc');

    // Define valid sorting columns and orders
    $validSortColumns = ['review_count' => 'review_count', 'average_rating' => 'average_rating'];
    $validSortOrders = ['asc', 'desc'];

    // Ensure the provided sorting column and order are valid
    $sortColumn = $validSortColumns[$sortBy] ?? 'review_count';
    $sortOrder = in_array($sortOrder, $validSortOrders) ? $sortOrder : 'asc';

    // Fetch the cars sorted by the specified column and order
    $cars = fetch_sorted_cars($sortColumn, $sortOrder);

    // Pass the sorted cars and sorting options to the view
    return view('items.home')
        ->with('cars', $cars)
        ->with('sortBy', $sortBy)
        ->with('sortOrder', $sortOrder);
});

// Route to show car details and reviews
Route::get('/car/{id}', function ($id) {
    // Fetch the car details by ID
    $car = get_car($id);

    // Fetch the reviews for the car
    $reviews = get_reviews($id);

    // Retrieve any validation errors from the session
    $errors = session('errors', []);

    // Get the reviewer's name from the session (if available)
    $reviewer_name = session('reviewer_name', '');

    // Pass the car details, reviews, errors, and reviewer's name to the view
    return view('items.car_details')
        ->with('car', $car)
        ->with('reviews', $reviews)
        ->with('errors', $errors)
        ->with('reviewer_name', $reviewer_name);
});

// Route to show the form to add a new car
Route::get('/add-car', function () {
    // Retrieve any validation errors from the session
    $errors = session('errors', []);
    return view('items.add_car')->with('errors', $errors);
});

// Route to handle car addition form submission
Route::post('/add-car', function () {
    // Get form input values for car details
    $name = request('name');
    $manufacturer_name = request('manufacturer_name');
    $model = request('model');
    $year = request('year');
    $type = request('type');

    // Validate car input and store error messages (if any)
    $error_messages = validate_car_input($name, $manufacturer_name, $model, $year);

    // If validation fails, redirect back to the add car form with errors
    if (!empty($error_messages)) {
        session()->flash('errors', $error_messages);
        return redirect('/add-car');
    }

    // Get or create the manufacturer, and add the car to the database
    $manufacturer_id = get_or_create_manufacturer($manufacturer_name);
    $car_id = add_car($name, $manufacturer_id, $model, $year, $type);

    // Redirect to the home page after successful addition
    return redirect('/');
});

// Route to handle the form submission for adding a review
Route::post('/add-review', function () {
    // Get form input values for review details
    $car_id = request('car_id');
    $reviewer_name = request('reviewer_name');
    $rating = request('rating');
    $review_text = request('review_text');

    // Validate review input and store error messages (if any)
    $error_messages = validate_review_input($reviewer_name, $rating, $car_id);
    if (!empty($error_messages)) {
        // If validation fails, redirect back to the car details page with errors
        session()->flash('errors', $error_messages);
        return redirect('/car/' . $car_id);
    }

    // Remove numbers from the reviewer's name for security/cleanliness
    $cleaned_name = remove_numbers_from_name($reviewer_name);

    // If the name was modified, inform the user through a session flash message
    if ($cleaned_name !== $reviewer_name) {
        session()->flash('name_changed_message', "The name you entered has been modified to: $cleaned_name");
    }

    // Store the cleaned reviewer name in the session for future use
    session(['reviewer_name' => $cleaned_name]);

    // Add the review to the database
    add_review($car_id, $cleaned_name, $rating, $review_text);

    // Redirect back to the car details page
    return redirect('/car/' . $car_id);
});

// Route to show the form for editing a review
Route::get('/edit-review/{id}', function ($id) {
    // Fetch the review by its ID
    $review = get_review($id);

    // Fetch the car associated with the review
    $car = get_car($review->car_id);

    // Retrieve any validation errors from the session
    $errors = session('errors', []);

    // Pass the review, car details, and errors to the view
    return view('items.edit_review')
        ->with('review', $review)
        ->with('car', $car)
        ->with('errors', $errors);
});

// Route to handle the form submission for updating a review
Route::post('/update-review', function () {
    // Get form input values for the updated review
    $review_id = request('review_id');
    $reviewer_name = request('reviewer_name');
    $rating = request('rating');
    $review_text = request('review_text');

    // Validate review input and store error messages (if any)
    $error_messages = validate_review_input($reviewer_name, $rating, $review_text);

    // If validation fails, reload the edit review page with errors
    if (!empty($error_messages)) {
        $review = get_review($review_id);
        $car = get_car($review->car_id);
        return view('items.edit_review')
            ->with('errors', $error_messages)
            ->with('review', $review)
            ->with('car', $car);
    }

    // Update the review in the database
    update_review($review_id, $reviewer_name, $rating, $review_text);

    // Get the car ID associated with the review and redirect to its details page
    $car_id = get_car_id_by_review_id($review_id);

    return redirect('/car/' . $car_id);
});

// Route to handle car deletion
Route::post('/delete-car/{id}', function ($id) {
    delete_car_and_reviews($id);
    return redirect('/');
});

// Route to list manufacturers with their average car ratings
Route::get('/manufacturers', function () {
    // Fetch the list of manufacturers with their average ratings
    $manufacturers = fetch_manufacturers();
    return view('items.manufacturers')->with('manufacturers', $manufacturers);
});

// Route to list cars by manufacturer
Route::get('/manufacturer/{id}', function ($id) {
    // Fetch the cars by the manufacturer ID
    $cars = fetch_cars_by_manufacturer($id);

    // Fetch the manufacturer details
    $manufacturer = get_manufacturer($id);

    // Pass the cars and manufacturer details to the view
    return view('items.manufacturer_cars')
        ->with('cars', $cars)
        ->with('manufacturer', $manufacturer);
});


// HELPER FUNCTIONS: each function interacts with the database using raw SQL queries and ensures the correct data flow


// Fetch sorted car data from the database, along with their associated manufacturer and review details
// The cars are grouped by their ID and sorted based on the specified column and order
function fetch_sorted_cars($sortColumn, $sortOrder) {
    $sql = "SELECT cars.id, cars.name, cars.model, cars.year, cars.type, manufacturers.name AS manufacturer,
                   COUNT(reviews.id) AS review_count, AVG(reviews.rating) AS average_rating
            FROM cars
            LEFT JOIN manufacturers ON cars.manufacturer_id = manufacturers.id
            LEFT JOIN reviews ON cars.id = reviews.car_id
            GROUP BY cars.id, cars.name, cars.model, cars.year, cars.type, manufacturers.name
            ORDER BY $sortColumn $sortOrder";
    return DB::select($sql);
}

// Retrieve detailed information about a specific car by its ID, including the manufacturer name
function get_car($id) {
    $sql = "SELECT cars.*, manufacturers.name AS manufacturer_name 
            FROM cars 
            JOIN manufacturers ON cars.manufacturer_id = manufacturers.id 
            WHERE cars.id = ?";
    return DB::selectOne($sql, [$id]);
}

// Fetch all reviews associated with a specific car, identified by its car ID
function get_reviews($car_id) {
    return DB::select("SELECT * FROM reviews WHERE car_id = ?", [$car_id]);
}

// Validate user input for car creation, ensuring no invalid characters and correct input length
// Returns an array of error messages if validation fails
function validate_car_input($name, $manufacturer_name, $model, $year) {
    $error_messages = [];
    $invalid_symbols = ['-', '_', '+', '"'];

    // Check car name length and invalid symbols
    if (strlen($name) <= 2 || strpbrk($name, implode('', $invalid_symbols))) {
        $error_messages[] = "The car name must be more than 2 characters and cannot contain the symbols: - _ + \"";
    }

    // Check manufacturer name length and invalid symbols
    if (strlen($manufacturer_name) <= 2 || strpbrk($manufacturer_name, implode('', $invalid_symbols))) {
        $error_messages[] = "The manufacturer name must be more than 2 characters and cannot contain the symbols: - _ + \"";
    }

    // Validate the year (must be between 1886 and the current year)
    if (!is_numeric($year) || $year < 1886 || $year > date('Y')) {
        $error_messages[] = "The year must be a valid number between 1886 and the current year.";
    }

    return $error_messages;
}

// Retrieve or create a manufacturer by name
// If the manufacturer already exists, its ID is returned, otherwise a new manufacturer is added
function get_or_create_manufacturer($name) {
    $manufacturer = DB::selectOne("SELECT id FROM manufacturers WHERE name = ?", [$name]);

    if ($manufacturer) {
        return $manufacturer->id;
    }

    // Insert a new manufacturer if none exists
    DB::insert("INSERT INTO manufacturers (name) VALUES (?)", [$name]);
    return DB::getPdo()->lastInsertId();
}

// Insert a new car record into the database, linked to a manufacturer by ID
// The function returns the ID of the newly created car
function add_car($name, $manufacturer_id, $model, $year, $type) {
    DB::insert("INSERT INTO cars (name, manufacturer_id, model, year, type) VALUES (?, ?, ?, ?, ?)", [$name, $manufacturer_id, $model, $year, $type]);
    return DB::getPdo()->lastInsertId();
}

// Validate user input for review submission, ensuring valid reviewer name and rating
// Also checks if the user has already submitted a review for the same car
function validate_review_input($reviewer_name, $rating, $car_id) {
    $error_messages = [];
    $invalid_symbols = ['-', '_', '+', '"'];

    // Check reviewer name length and invalid symbols
    if (strlen($reviewer_name) <= 2 || strpbrk($reviewer_name, implode('', $invalid_symbols))) {
        $error_messages[] = "The reviewer name must be more than 2 characters and cannot contain the symbols: - _ + \"";
    }

    // Validate the rating (must be between 1 and 5)
    if ($rating < 1 || $rating > 5) {
        $error_messages[] = "Rating must be between 1 and 5.";
    }

    // Check if the user has already submitted a review for the same car
    $existingReview = DB::selectOne("SELECT * FROM reviews WHERE car_id = ? AND reviewer_name = ?", [$car_id, $reviewer_name]);
    if ($existingReview) {
        $error_messages[] = "You have already reviewed this car.";
    }

    return $error_messages;
}

// Insert a new review for a car, linked by the car ID
// The review includes the reviewer's name, rating, and review text
function add_review($car_id, $reviewer_name, $rating, $review_text) {
    DB::insert("INSERT INTO reviews (car_id, reviewer_name, rating, review_text) VALUES (?, ?, ?, ?)", [$car_id, $reviewer_name, $rating, $review_text]);
}

// Retrieve a specific review by its ID
function get_review($id) {
    return DB::selectOne("SELECT * FROM reviews WHERE id = ?", [$id]);
}

// Update an existing review with new details (reviewer name, rating, and review text)
function update_review($id, $reviewer_name, $rating, $review_text) {
    DB::update("UPDATE reviews SET reviewer_name = ?, rating = ?, review_text = ? WHERE id = ?", [$reviewer_name, $rating, $review_text, $id]);
}

// Fetch all manufacturers along with their average car ratings
// The result includes only manufacturers that have associated cars and reviews
function fetch_manufacturers() {
    return DB::select("
        SELECT manufacturers.id, manufacturers.name, AVG(reviews.rating) AS average_rating
        FROM manufacturers
        JOIN cars ON manufacturers.id = cars.manufacturer_id
        LEFT JOIN reviews ON cars.id = reviews.car_id
        GROUP BY manufacturers.id, manufacturers.name;    
    ");
}

// Retrieve all cars by a specific manufacturer, including the average rating for each car
function fetch_cars_by_manufacturer($id) {
    return DB::select("
        SELECT cars.id, cars.name, cars.model, cars.year, cars.type, AVG(reviews.rating) AS avg_rating
        FROM cars
        LEFT JOIN reviews ON cars.id = reviews.car_id
        WHERE cars.manufacturer_id = ?
        GROUP BY cars.id, cars.name, cars.model, cars.year, cars.type
    ", [$id]);
}

// Retrieve details of a specific manufacturer by its ID
function get_manufacturer($id) {
    return DB::selectOne("SELECT * FROM manufacturers WHERE id = ?", [$id]);
}

// Delete a car and all its associated reviews from the database
function delete_car_and_reviews($id) {
    DB::delete("DELETE FROM reviews WHERE car_id = ?", [$id]);
    DB::delete("DELETE FROM cars WHERE id = ?", [$id]);
}

// Retrieve the car ID associated with a specific review by its review ID
function get_car_id_by_review_id($review_id) {
    $review = DB::selectOne("SELECT car_id FROM reviews WHERE id = ?", [$review_id]);
    return $review->car_id ?? null;
}

// Clean a name by removing all numeric characters from the string
function remove_numbers_from_name($name) {
    return preg_replace('/\d+/', '', $name);
}
