<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# About This Project

This project exists as a demonstration to show my ability to work with both Laravel and Vue


## The brief for this project is as follows:

Using Vue.js and Laravel, create a simple application that meets the following acceptance criteria:

* Users can register for a new account.
* Users can login to their account.
* Logged in users are sent to a page that allows them to edit their profile with the following acceptance criteria
* Users can update their first and last names
* Users can add a phone number to their profile
* Users can add, edit or delete multiple addresses on their profile.
* Each address is comprised of 2 street lines, suburb, state, postcode and country.
 
BONUS: Which address attributes should be required/validated?

## Bonus question answer:
The address fields that should be required are the second street line, suburb, state, postcode, and country.
Whilst the country field can be inferred as being within the same country as the service it is entered into, I feel it is best to make this a hard requirement to avoid ambiguity.

Validation of the country field can be performed easily enough by either providing a list of valid countries to select from, and/or matching against a list of potential countries on the backend.

After that however, it becomes more and more dificult to validate the address components as their granularity increases, ie. there are an order of magnitude more street names than country names.

A potential workaround for this would be to embed a google maps style interface to allow the user to confirm their location visually, and I have seen this approach used to good effect on several popular apps, ie. Uber, Deliveroo, etc.

# Enviroment configuration
This project only requires authentication information for a mysql database within its `.env` file.

Once `php artisan migrate` has been executed, the project will be ready to use.