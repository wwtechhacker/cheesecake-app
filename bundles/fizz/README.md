FIZZ
====
Fizz is a connector between Laravel's Form and Validator classes, providing 2 core pieces of functionality: form field value population, and error highlighting. Its goals are to bridge the gap between these two related libraries, and yet stay flexible enough to stay out of the developer's way when needed.

Goals
-----
Fizz intends to help with the form creation process, whilst not imposing any of its own ideologies or patterns, other than extending Laravel's native form methods. The intent is to create a Form library that performs the very mundane (highlighting form fields, and automatic form element value population) automatically and still allow developers the freedom to do what they need, when they need it. Nothing irritates me more than using a library only to find that I have to write pseudo-code to get around its own design flaws when I have unique use cases.

Fizz lets you get the job done with minimal effort. If you need more functionality, or wish to tailor it specifically for a project - I would advise that you setup your own Form macros, or extend the library directly. Additionally, if you have some suggestions as to how the library could be better, be sure to let me know :)

Installation
------------
Install Fizz using artisan:

    php artisan bundle:install fizz

, then in application/bundles.php, add the following:

    return array(
        'fizz' => array('auto' => true)
    );

This will load the Fizz library upon every request.

Usage
-----
Fizz currently wraps around Laravel's form library and adds some functionality. Form field population gets handled automagically, you don't need to worry about that. However, in the current implementation of Form, there is a disconnect between it and Validator. Some would see this as a bad thing, I actually think it's a strength. Nothing worse than a framework that tries to do everything for you.

It is recommended that you replace the Laravel Form library calls, so that this bundle is truly plug 'n' play, by replacing the following in your application/config/application.php file:

    'Form' => 'Laravel\\Form',

With:

    'Form' => 'Fizz\\Form',

What this does, is basically make all Form requests in your markup, directed to Fizz\Form. (Otherwise you need to call Fizz\Form::.etc. everywhere in your HTML!)

One thing to note is that this does NOT remove the original Laravel Form calls. In fact, all it's doing is wrapping your call with some functionality to check for errors, field values.etc, then sending the call along to the Laravel\Form library.

There are two ways to handle form creation using Fizz. One, is by handling all the functionality on the request that renders a form. Let's say we have the following controller action:
    
    public function action_new() {
        $post = Input::all();

        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );
        
        $validation = Validator::make($post, $rules);
        Form::set_data($validation->errors->messages);
    }

What this does is assign the generated errors to Fizz\Form class, which can then do it's checks when generating form elements. If any errors are found for a given form element, it will attach a "form-error" class to that field. This is the default class however, and can be changed by setting your own configuration setting in a custom fizz config file, like so:

    'fizz_error_class_name' => 'form-error'

The method above assumes that you're also posting to the same method, which is not always the best approach. The example below shows a better way:

    public function get_new() {
        // We look to see if any errors have been pulled back
        Form::set_data(Session::get('errors'));

        return View::make('new'); // render the form for the "new" action
    }

We'll assume that the form that is rendered on the "new" view, is posting to the action below:

    public function post_new() {
        $rules = array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email'
        );

        $validation = Validator::make(Input::get(), $rules);

        if ($validation->fails()) {
            return Redirect::to('new')->with('errors', $validation->errors->messages)->with_input();
        }
    }

As you can see, when validation fails, we redirect back to the get_new method, and also pass along the errors generated, as well as any input that was part of that request. Fizz\Form will automatically try and find input values, either with Input::old() or Input::get(). Or, the developer can manually assign the values after the errors have been assigned, by doing the following:

    Form::set_data($errors, $values);

The values array should always be an associative array.

Changelog
---------
v1.2
* Removed dependency on Laravel's Validator class
* Checks for errors and data population can now be done on Redirects (using with_input())
* Error checks are now more dynamic, allowing for different ways to provide errors generated
* Removed/fixed gotchas

v1.1
* Fixed bugs reported, including an odd issue found in PHP 5.3.2 with call_user_func_array and namespaces

v1.0
* Initial release