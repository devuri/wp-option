<?php

namespace Urisoft;

/**
 * WPOptionBridge Class
 *
 * Provides an object-oriented interface for managing WordPress options,
 * facilitating get, add, update, and delete operations with enhanced flexibility.
 */
class WPOptionBridge {

    protected $optionGetter;
    protected $optionAdder;
    protected $optionUpdater;
    protected $optionDeleter;

    /**
     * Sets the function used to retrieve options.
     *
     * @param callable $optionGetter Function to retrieve an option.
     */
    public function set_option_getter(callable $optionGetter) {
        $this->optionGetter = $optionGetter;
    }

    /**
     * Sets the function used to add options.
     *
     * @param callable $optionAdder Function to add an option.
     */
    public function set_option_adder(callable $optionAdder) {
        $this->optionAdder = $optionAdder;
    }

    /**
     * Sets the function used to update options.
     *
     * @param callable $optionUpdater Function to update an option.
     */
    public function set_option_updater(callable $optionUpdater) {
        $this->optionUpdater = $optionUpdater;
    }

    /**
     * Sets the function used to delete options.
     *
     * @param callable $optionDeleter Function to delete an option.
     */
    public function set_option_deleter(callable $optionDeleter) {
        $this->optionDeleter = $optionDeleter;
    }

    /**
     * Validates the option name.
     *
     * @param mixed $option_name The option name to validate.
     * @return bool True if valid, false otherwise.
     */
    protected function validate_option_name($option_name) {
        if (!is_string($option_name)) {
            error_log("WPOptionBridge: Option name must be a string. Given: " . gettype($option_name));
            return false;
        }

        return true;
    }

    /**
     * Retrieves an option value from the WordPress database.
     *
     * @param string $option_name The name of the option to retrieve.
     * @param mixed $default Optional. Default value to return if the option does not exist.
     * @return mixed The value of the option, or default if the option does not exist.
     */
    public function get_option($option_name, $default = false) {
        $getter = $this->optionGetter ?? 'get_option';
        if (!$this->validate_option_name($option_name)) {
            return $default;
        }

        return call_user_func($getter, $option_name, $default);
    }

    /**
     * Adds a new option to the WordPress database.
     *
     * @param string $option_name Name of the option to add.
     * @param mixed $value The value for the option.
     * @return bool True if option was added, false otherwise.
     */
    public function add_option($option_name, $value) {
        $adder = $this->optionAdder ?? 'add_option';
        if (!$this->validate_option_name($option_name)) {
            return false;
        }

        return call_user_func($adder, $option_name, $value);
    }

    /**
     * Updates an existing option in the WordPress database.
     *
     * @param string $option_name Name of the option to update.
     * @param mixed $value The new value for the option.
     * @return bool True if option was updated, false otherwise.
     */
    public function update_option($option_name, $value) {
        $updater = $this->optionUpdater ?? 'update_option';
        if (!$this->validate_option_name($option_name)) {
            return false;
        }

        return call_user_func($updater, $option_name, $value);
    }

    /**
     * Deletes an option from the WordPress database.
     *
     * @param string $option_name Name of the option to delete.
     * @return bool True if the option was deleted, false otherwise.
     */
    public function delete_option($option_name) {
        $deleter = $this->optionDeleter ?? 'delete_option';
        if (!$this->validate_option_name($option_name)) {
            return false;
        }

        return call_user_func($deleter, $option_name);
    }
}
