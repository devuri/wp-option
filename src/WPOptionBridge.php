<?php

namespace Urisoft;

/**
 * WPOptionBridge Class
 *
 * Serves as a comprehensive interface for managing WordPress options,
 * providing object-oriented access to get, add, update, and delete operations.
 */
class WPOptionBridge {

    protected $optionGetter;

    /**
     * Constructor
     * Allows for dependency injection to facilitate testing and flexibility.
     *
     * @param callable $optionGetter Function to retrieve an option. Defaults to WordPress's get_option.
     */
    public function __construct(callable $optionGetter = 'get_option') {
        $this->optionGetter = $optionGetter;
    }

    /**
     * Retrieves an option value from the WordPress database.
     *
     * @param string $option_name The name of the option to retrieve.
     * @param mixed $default Optional. Default value to return if the option does not exist.
     * @return mixed The value of the option, or default if the option does not exist.
     */
    public function get_option($option_name, $default = false) {
        if (!is_string($option_name)) {
            error_log("WPOptionBridge: Option name must be a string. Given: " . gettype($option_name));
            return $default;
        }

        return call_user_func($this->optionGetter, $option_name, $default);
    }

    /**
     * Adds a new option to the WordPress database.
     *
     * @param string $option_name Name of the option to add.
     * @param mixed $value The value for the option.
     * @return bool True if option was added, false otherwise.
     */
    public function add_option($option_name, $value) {
        if (!is_string($option_name)) {
            error_log("WPOptionBridge: Option name must be a string for adding. Given: " . gettype($option_name));
            return false;
        }

        return add_option($option_name, $value);
    }

    /**
     * Updates an existing option in the WordPress database.
     *
     * @param string $option_name Name of the option to update.
     * @param mixed $value The new value for the option.
     * @return bool True if option was updated, false otherwise.
     */
    public function update_option($option_name, $value) {
        if (!is_string($option_name)) {
            error_log("WPOptionBridge: Option name must be a string for updating. Given: " . gettype($option_name));
            return false;
        }

        return update_option($option_name, $value);
    }

    /**
     * Deletes an option from the WordPress database.
     *
     * @param string $option_name Name of the option to delete.
     * @return bool True if the option was deleted, false otherwise.
     */
    public function delete_option($option_name) {
        if (!is_string($option_name)) {
            error_log("WPOptionBridge: Option name must be a string for deletion. Given: " . gettype($option_name));
            return false;
        }

        return delete_option($option_name);
    }
}
