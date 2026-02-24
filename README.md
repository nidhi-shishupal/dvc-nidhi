# DVC PROJECT – Nidhi Shishupal

This repository contains solutions for all 3 assessment questions.
Each question is implemented in an isolated folder to keep the code clean and independently runnable.

---

## 📁 Project Structure

```
dvc-project-nidhi/
│
├── question1/  → Product Card (HTML/CSS/JS UI task)
├── question2/  → WordPress Testimonials Plugin
├── question3/  → Weather Dashboard (API + Accessibility + UX task)
│
└── README.md
```

---

## 🚀 Question 1 — Product Card UI

A responsive product card with cart interaction and feedback state.

### Features

* Accessible button labels
* Add-to-cart loading state feedback
* Keyboard focus styles
* Clean responsive layout
* Vanilla JavaScript (no libraries)

### How to Run

Open the file directly in browser:

```
question1/product-card.html
```

---

## 🌐 Question 2 — WordPress Testimonials Plugin

A fully functional custom WordPress plugin that registers a testimonial system.

### Implemented

* Custom Post Type (Testimonials)
* Custom Meta Fields (Client name, position, company, rating)
* Secure Save (nonce + permissions + autosave protection)
* Sanitization of all inputs
* Escaped frontend output
* Gutenberg compatible (`show_in_rest`)
* Shortcode `[testimonials]`
* Custom archive template
* Clean single testimonial template
* Responsive slider

### Security Measures

* Nonce verification
* Input sanitization
* Output escaping
* Whitelisted shortcode parameters
* Capability checks

### Installation

1. Copy `question2/testimonials-manager` folder
2. Paste inside:

```
wp-content/plugins/
```

3. Activate plugin in WordPress Admin
4. Add shortcode:

```
[testimonials]
```

---

## ⛅ Question 3 — Weather Dashboard

Weather search dashboard using OpenWeather API with UX and accessibility improvements.

### Features

* Search suggestions
* API debounce / spam prevention
* Error handling
* Loading states
* Keyboard navigation for forecast cards
* ARIA accessibility labels
* LocalStorage fallback handling
* Missing API key detection

### Setup

Open the file:

```
question3/weather-dashboard.html
```

Add your API key inside the script:

```js
const API_KEY = "YOUR_API_KEY_HERE";
```

Note: API key is intentionally not included for security reasons.

---

## 🧠 Tech Used

* HTML5
* CSS3
* JavaScript (Vanilla)
* WordPress (PHP)
* REST APIs
* Accessibility (ARIA)

---

## 👩‍💻 Author

**Nidhi Shishupal**

This project was completed demonstrating frontend UI skills, JavaScript logic, accessibility practices, and WordPress plugin development.

---
