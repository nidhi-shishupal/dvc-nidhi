# DVC – Nidhi Shishupal

This repository contains solutions for the Web Development Technical Assessment.
Each question is implemented separately so it can run independently.

---

## Project Structure

dvc-project-nidhi/

* question1/

  * product-card.html
* question2/

  * testimonials-manager/ (WordPress Plugin)
* question3/

  * weather-dashboard.html
* README.md

---

## Candidate Information

- **Name:** Nidhi Shishupal  
- **Email:** nidhipshishupal9@gmail.com  
- **Role Applied:** Web Development Intern  
- **Tech Stack:** HTML, CSS, JavaScript, WordPress, PHP

---

## Question 1 — Responsive Product Card

A fully responsive and accessible product card component with interactive cart functionality.

Features:

* Semantic HTML structure
* Mobile-first responsive layout
* Quantity selector (1–10 limits)
* Disabled increment/decrement at boundaries
* Add-to-cart feedback state
* Success notification message
* Console cart log (name, quantity, total price)
* Keyboard accessibility
* Cross-browser compatible

Run:
Open directly in browser:
question1/product-card.html

---

## Question 2 — WordPress Testimonials Plugin

A custom WordPress plugin that allows administrators to manage and display client testimonials.

Backend:

* Custom Post Type: Testimonials
* Featured image support (client photo)
* Gutenberg editor support
* Custom admin menu icon

Custom Fields:

* Client Name (required)
* Position/Title
* Company Name
* Rating (1–5 stars)

All data is sanitized, validated and securely saved.

Frontend:

* [testimonials] shortcode
* Responsive layout
* Star rating display
* Client details
* Previous/Next navigation slider
* Archive and single testimonial templates

Security:

* Nonce verification
* Capability checks
* Input sanitization
* Output escaping
* Safe shortcode parameters

Installation:

1. Copy folder question2/testimonials-manager
2. Paste into wp-content/plugins/
3. Activate plugin in WordPress
4. Use shortcode [testimonials]

---

## Question 3 — Weather Dashboard

A weather dashboard using OpenWeatherMap API with accessibility, state handling, and error management.

Core Features:

* City search + Enter key support
* Current weather details
* 5-day forecast
* Weather icons & description

State Handling:

* Loading indicator
* API error handling
* City not found handling
* Offline fallback (localStorage)

UX & Accessibility:

* ARIA labels
* Keyboard navigation (forecast cards)
* Search suggestions with debounce
* API spam prevention
* LocalStorage fallback handling
* Missing API key detection
* Responsive design

Setup:
Open question3/weather-dashboard.html

Add your API key inside the script:
const API_KEY = "YOUR_API_KEY_HERE";

(API key intentionally excluded for security)

---

## Assumptions Made

* Internet connection available for API features
* WordPress supports Gutenberg editor
* Modern browsers used (Chrome, Edge, Firefox, Safari)
* OpenWeather free tier API limits respected

---

## Estimated Time Spent

* **Product Card:** 3 hours
* **WordPress Plugin:** 5 hours
* **Weather Dashboard:** 6 hours

---

## Technologies Used

* **HTML5**
* **CSS3**
* **Vanilla JavaScript**
* **WordPress (PHP)**
* **REST API Integration**
* **Accessibility (ARIA)**

---

## Notes

* No API keys are committed for security
* Each task runs independently
* Code follows best practices and formatting standards

This project demonstrates frontend UI development, JavaScript logic handling, accessibility implementation, and WordPress plugin development.
