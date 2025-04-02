# 📚 halal-book
Audiobook &amp; PDF Bookstore Management System
A Laravel-based platform for managing the purchase and distribution of audiobooks and PDF books

> **Note**: Due to an NDA agreement, only the parts of the project related to my contribution are shared here. This repository is for educational and demonstration purposes only, and it does not represent the full project.


## Middleware

### 🔹 **CheckSubscription**

This middleware checks if the user has an active subscription. It verifies the subscription status and expiration date, ensuring that only active subscriptions are considered valid. If the user has an active subscription, the middleware adds a `has_subscription` flag to the request, indicating the user's subscription status.

### 🔹 **CheckPurchasedBooks**

This middleware retrieves a list of book IDs that the user has purchased. It queries the payment records of the user and extracts the unique IDs of books that have been successfully purchased. These IDs are then added to the request as `purchased_books`, which can be used to filter or restrict access to content based on the user's purchase history.


## API Endpoints

### 🔹 **Books**
| Method | Endpoint               | Description                           |
|--------|------------------------|---------------------------------------|
| **GET**   | `/api/my-books`         | Retrieve the list of books owned by the user. |

---

### 🔹 **Book Cases**
| Method  | Endpoint                | Description                           |
|---------|-------------------------|---------------------------------------|
| **POST**   | `/api/book-cases/store`  | Create a new book case.              |
| **GET**    | `/api/book-cases`        | Get the list of book cases for a specific user. |
| **DELETE** | `/api/book-cases/{id}`   | Delete a specific book case by ID.   |

---

### 🔹 **Books of Book Cases**
| Method  | Endpoint                                 | Description                           |
|---------|------------------------------------------|---------------------------------------|
| **POST**   | `/api/book-cases/{book_case}/books/{book}` | Add a book to a specific book case.   |
| **GET**    | `/api/book-cases/{book_case}/books`       | Get all books from a specific book case. |
| **DELETE** | `/api/book-cases/{book_case}/books/{book}` | Remove a specific book from a book case. |

---

### 🔹 **Cart**
| Method  | Endpoint              | Description                             |
|---------|-----------------------|-----------------------------------------|
| **GET**    | `/api/carts`          | Retrieve the list of items in the cart. |
| **POST**   | `/api/carts/store`    | Add a book to the cart.                |
| **DELETE** | `/api/carts/{id}`     | Remove a specific book from the cart.  |

---

### 🔹 **Plans**
| Method  | Endpoint              | Description                             |
|---------|-----------------------|-----------------------------------------|
| **GET**    | `/api/plan`          | Retrieve the list of plans. |

---

### 🔹 **Payment**
| Method  | Endpoint              | Description                             |
|---------|-----------------------|-----------------------------------------|
| **GET**    | `/api/pay`          | Retrieve the link of payment. |
| **POST**   | `/callback`    | Handle the payment callback response.                |

#### **📌 Endpoint:**  
`POST /api/pay`

#### **📌 Request Body:**  
```json
{
    "amount": 200000,
    "gateway_name": "zarinpal",
    "book_ids": [3, 1],
    "mobile": "09122222222",
    "plan_id": 1,
    "type": "subscription"
}

 - type => one of: "gift_card", "wallet", "book", "subscription"
 - book_ids => is nullable (only required for book purchases)
 - mobile => is nullable (only required for wallet transactions)

```
#### **📌 Example Response:** 

```json
{
    "status": 200,
    "message": "اطلاعات درگاه پرداخت",
    "data": {
        "redirect_url": "https://sandbox.zarinpal.com/pg/StartPay/S00000000000000000000000000000008mn5",
        "paid_amount": 100000,
        "expire_time": 6
    },
    "code": 200
}

``` 
---

### 🔹 **Track payment**
| Method  | Endpoint              | Description                             |
|---------|-----------------------|-----------------------------------------|
| **GET**    | `/api/payment-history`          | Retrieve the user's payment history. |
| **POST**   | `/api/payment-tracking`    | Retrieve detailed information about a specific payment transaction.                |


---

### 🔹 **Purchases**
| Method  | Endpoint              | Description                             |
|---------|-----------------------|-----------------------------------------|
| **GET**    | `/api/my-purchases`          | Retrieve the list of purchases. |
 
---

### 🔹 **Books (by filters)**
| Method  | Endpoint              | Description                             |
|---------|-----------------------|-----------------------------------------|
| **GET**    | `/api/books`          | Retrieve the list of books by filters. |

---

### 🔹 **Book meta data**
| Method  | Endpoint              | Description                             |
|---------|-----------------------|-----------------------------------------|
| **GET**    | `/api/authors`          | Retrieve the list of authors. |
| **GET**    | `/api/publishers`          | Retrieve the list of publishers. |
| **GET**   | `/api/speakers`    | Retrieve the list of speakers.   |
| **GET** | `/api/translators`     | Retrieve the list of translators.  |

---

### 🔹 **Book excerpt**
| Method  | Endpoint              | Description                             |
|---------|-----------------------|-----------------------------------------|
| **POST**    | `/api/book-excerpts/store`          | Create a book excerpt. |
| **GET**    | `/api/book-excerpts`          | Retrieve the list of book excerpts. |
| **GET**   | `/api/speakers`    | Retrieve the list of speakers.   |

---

### 🔹 **Podcasts**
| Method  | Endpoint              | Description                             |
|---------|-----------------------|-----------------------------------------|
| **GET**    | `/api/podcasts`          | Retrieve the list of podcasts. |

---

### 🔹 **Profiles**
| Method  | Endpoint            | Description                            |
|---------|---------------------|----------------------------------------|
| **POST**   | `/api/profiles`    | Create a user's profile.     |
| **GET**    | `/api/profiles`    | Get information about the user's profile. |


