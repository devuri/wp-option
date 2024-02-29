# WP Option Bridge

`WP Option` is designed to provide an object-oriented interface for managing WordPress options, simplifying the process of getting, adding, updating, and deleting options within WordPress. It acts as a `bridge` to the WordPress options API, enhancing code readability and maintainability.

## Features

- **Object-Oriented Approach**: Encapsulates WordPress option management in a single, cohesive class.
- **Dependency Injection**: Facilitates testing and flexibility by allowing custom functions for getting options.
- **Comprehensive Option Management**: Supports get, add, update, and delete operations for WordPress options.
- **Error Logging**: Basic error logging for input validation, aiding in debugging and issue resolution.

## Requirements

- PHP 7.2 or higher
- WordPress 4.7 or higher

## Installation

Install the package via Composer:

```bash
composer require devuri/wp-option
```

## Usage

### Initialization

First, import the `WPOptionBridge` class and instantiate it:

```php
use Urisoft\WPOptionBridge;

$optionBridge = new WPOptionBridge();
```

### Getting an Option

Retrieve an option value using the `get_option` method:

```php
$siteName = $optionBridge->get_option('blogname', 'Default Site Name');
```

### Adding an Option

Add a new option using the `add_option` method:

```php
$optionBridge->add_option('my_custom_option', 'My Custom Value');
```

### Updating an Option

Update an existing option using the `update_option` method:

```php
$optionBridge->update_option('my_custom_option', 'Updated Custom Value');
```

### Deleting an Option

Delete an option using the `delete_option` method:

```php
$optionBridge->delete_option('my_custom_option');
```

## Advanced Usage

### Customizing Option Retrieval

The `WPOptionBridge` class is designed with flexibility in mind, allowing developers to inject a custom function for retrieving option values. This is particularly useful for unit testing, where you might want to isolate the class from the WordPress database, or for integrating with a custom caching layer or option storage mechanism.

#### Using a Custom Callable

The set_option_getter of `WPOptionBridge` accepts a `callable` parameter that replaces the default WordPress `get_option` function. A `callable` in PHP is something that can be called as a function. This includes actual functions, static class methods, and object methods, among others.

Here's how you can utilize this feature:

```php
use Urisoft\WPOptionBridge;

// Define a custom function for getting options.
// This is a simple example that mimics the get_option behavior.
$customOptionGetter = function($option_name, $default = false) {
    // Custom logic to retrieve an option value
    // For example, you might want to check a local cache first
    $value = /* your custom retrieval logic */;

    return $value !== null ? $value : $default;
};


$optionBridge = new Urisoft\WPOptionBridge();

// Set a custom option getter
$optionBridge->set_option_getter($customOptionGetter);

```

In this example, `$customOptionGetter` is a custom function defined to retrieve option values. When creating a new instance of `WPOptionBridge`, you pass this function as an argument. The class will then use this function instead of the default `get_option` WordPress function whenever `get_option` is called.

### Use Cases for a Custom Callable

- **Unit Testing**: By injecting a custom function that returns predefined values, you can test the behavior of your code that uses `WPOptionBridge` without relying on a WordPress environment or database.
- **Caching**: If your application has a custom caching layer for options, you can inject a function that first checks the cache before falling back to the database.
- **Custom Storage**: For applications that store options outside of the WordPress database (like in a different database or a file), you can use this feature to integrate `WPOptionBridge` with your storage mechanism.

### Best Practices

- Ensure your custom callable matches the expected signature: it should accept an option name and an optional default value, returning the option value if found, or the default if not.
- When using this feature for caching, make sure to handle cache invalidation appropriately to avoid stale data issues.

## Customizing Option Management

The class offers full flexibility in managing WordPress options by allowing you to define custom functions for option operations. This is particularly useful for scenarios like unit testing, integrating with caching systems, or using a custom storage mechanism for WordPress options.

### Setting Custom Functions

You can set custom functions for each operation using the following methods:

- `set_option_getter(callable $function)`: Customize how options are retrieved.
- `set_option_adder(callable $function)`: Customize how options are added.
- `set_option_updater(callable $function)`: Customize how options are updated.
- `set_option_deleter(callable $function)`: Customize how options are deleted.

Each method accepts a `callable` argument, which should be a function that matches the expected signature of the corresponding WordPress function.

### Example

```php
use Urisoft\WPOptionBridge;

$optionBridge = new WPOptionBridge();

// Custom function for retrieving options
$optionBridge->set_option_getter(function($name, $default = false) {
    // Custom logic to retrieve an option
});

// Custom function for adding options
$optionBridge->set_option_adder(function($name, $value) {
    // Custom logic to add an option
});

// Custom function for updating options
$optionBridge->set_option_updater(function($name, $value) {
    // Custom logic to update an option
});

// Custom function for deleting options
$optionBridge->set_option_deleter(function($name) {
    // Custom logic to delete an option
});
```

### Use Cases

- **Unit Testing**: Mock the option functions to test your application logic without interacting with the database.
- **Caching**: Implement custom getters and setters that work with a caching layer to reduce database load.
- **Custom Storage**: Integrate with a custom storage system for WordPress options, such as an external database or a file-based storage system.

> leveraging these customization capabilities, `WPOptionBridge` becomes an adaptable tool that can fit into various architectures and testing environments, enhancing the modularity and testability of your WordPress projects.


## Contributing

Contributions are welcome! Please read our [contributing guide](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## License

The `WP Option Bridge` is open-sourced software licensed under the [MIT license](LICENSE).

