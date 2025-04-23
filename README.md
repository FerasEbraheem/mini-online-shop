# PHP Mini Online Shop

A simple PHP-based online shop showcasing products from a JSON data file, allowing users to browse, search, view details, and manage a session-based shopping cart. Features user login simulation, product listing, cart management, and static informational pages.

---

## 🛒 Features

- **User Authentication** (simulated): login/logout with session and cookie.
- **Product Listing**: display products from `products.json`.
- **Product Search**: filter products by name.
- **Product Details**: view full description, image, and add to cart.
- **Shopping Cart**:  
  - Add products to cart  
  - Increase, decrease, and remove items  
  - Clear entire cart  
  - Cart widget shows current items  
- **Static Pages**:  
  - Home (Startseite)  
  - About (Über uns)  
  - Contact (Kontakt)  
  - Footer & Navigation templates  

---

## 💻 Tech Stack

- **Backend**: PHP 7+ using native sessions and JSON data store  
- **Frontend**: HTML5, CSS3 (responsive layout)  
- **Storage**: `products.json` as product database  
- **Session**: PHP `$_SESSION` for cart and login state  

---

## 🚀 Getting Started

### Prerequisites

- PHP 7.x or newer  
- A web server (Apache, Nginx) or PHP built-in server

### Installation

1. **Clone the repository**  
   ```bash
   git clone https://github.com/FerasEbraheem/mini-online-shop.git
   cd mini-online-shop
   ```

2. **Start PHP built-in server**  
   ```bash
   php -S localhost:8000
   ```
   Or configure your Apache/Nginx vhost to point to the project folder.

3. **Browse the app**  
   - Home: `http://localhost:8000/index.php`  
   - Products: `http://localhost:8000/produkte.php`  
   - Product Details: `http://localhost:8000/produkt_detail.php?id=1`  
   - Cart: `http://localhost:8000/warenkorb.php` (visible when logged in)  
   - Login: simulate login on any page via the login form  
   - Static: `ueber-uns.php`, `kontakt.php`

---

## 📂 Project Structure

```
mini-online-shop/
├── cart-widget.php         # displays current cart items
├── index.php               # home page with login & navigation
├── kontakt.php             # contact page
├── login.php               # login/logout logic and form
├── products.json           # product data store
├── produkt_detail.php      # product detail view & add-to-cart handling
├── produkte.php            # product listing & search
├── ueber-uns.php           # about us page
├── warenkorb.php           # cart management page
├── templates/
│   ├── footer.php          # footer template
│   └── navigation.php      # navigation menu template
├── style.css               # site-wide styles
└── README.md               # project documentation
```

---

## 🔧 Usage

1. **Login**: enter username/password (`John`/`beep`) to simulate user session.  
2. **Browse Products**: view, search, and click for details.  
3. **Add to Cart**: on detail or listing pages, add items if logged in.  
4. **Manage Cart**: increase, decrease, remove items, or clear cart.  
5. **Logout**: use the logout button in header.

---

## ✨ Contributing

Feel free to fork and submit improvements via pull requests. Consider adding real user authentication, database integration, or styling enhancements.

---

## ⚖️ License

This project is open-source and available under the MIT License.
