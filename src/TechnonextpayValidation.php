<?php

namespace TechnonextPlugin;

/**
 *
 * PHP Plug-in service to provide Technonextpay get way services.
 *
 * @author 
 * @since 
 */
class TechnonextpayValidation
{

    /**
     * Prepare a method for checking internet connection from client-side
     *
     * @return bool $is_conn
     */
    function checkInternetConnection()
    {
        $connected = @fsockopen('www.google.com', 80);

        if ($connected) {
            $is_conn = true; //action when connected
            fclose($connected);
        } else {
            $is_conn = false; //action in connection failure
        }
        return $is_conn;
    }

    /**
     * Validate payload required data with detailed error reporting
     *
     * @param mixed $payload_data
     * @return array Returns array with 'valid' boolean and 'errors' array
     */
    function ValidationWithDetails($payload_data)
    {
        $payload_data = json_decode($payload_data);
        $errors = [];

        // Check each field and collect errors
        if (!$this->emptyCheck('Username', $payload_data->security->username ?? null)) {
            $errors[] = 'Username is required and cannot be empty';
        }
        if (!$this->emptyCheck('Password', $payload_data->security->password ?? null)) {
            $errors[] = 'Password is required and cannot be empty';
        }
        if (!$this->emptyCheck('Order ID', $payload_data->order_id ?? null)) {
            $errors[] = 'Order ID is required and cannot be empty';
        }
        if (!$this->emptyCheck('Amount', $payload_data->order_information->payable_amount ?? null)) {
            $errors[] = 'Amount is required and cannot be empty';
        }
        if (!$this->emptyCheck('Currency', $payload_data->order_information->currency_code ?? null)) {
            $errors[] = 'Currency is required and cannot be empty';
        }
        if (!$this->emptyCheck('IPN Url', $payload_data->ipn_url ?? null)) {
            $errors[] = 'IPN URL is required and cannot be empty';
        }
        if (!$this->emptyCheck('Success Url', $payload_data->success_url ?? null)) {
            $errors[] = 'Success URL is required and cannot be empty';
        }
        if (!$this->emptyCheck('Cancel Url', $payload_data->cancel_url ?? null)) {
            $errors[] = 'Cancel URL is required and cannot be empty';
        }
        if (!$this->emptyCheck('Failure Url', $payload_data->failure_url ?? null)) {
            $errors[] = 'Failure URL is required and cannot be empty';
        }
        if (!$this->emptyCheck('Customer Name', $payload_data->customer_information->name ?? null)) {
            $errors[] = 'Customer Name is required and cannot be empty';
        }
        if (!$this->phoneCheck($payload_data->customer_information->contact_number ?? null)) {
            $errors[] = 'Phone number must be exactly 11 digits and contain only numbers';
        }
        if (!$this->emailCheck($payload_data->customer_information->email ?? null)) {
            $errors[] = 'Email address is invalid';
        }
        if (!$this->emptyCheck('Customer Primary Address', $payload_data->customer_information->primaryAddress ?? null)) {
            $errors[] = 'Customer Primary Address is required and cannot be empty';
        }
        if (!$this->emptyCheck('Customer City', $payload_data->customer_information->city ?? null)) {
            $errors[] = 'Customer City is required and cannot be empty';
        }
        if (!$this->emptyCheck('Customer State', $payload_data->customer_information->state ?? null)) {
            $errors[] = 'Customer State is required and cannot be empty';
        }
        if (!$this->emptyCheck('Customer Postcode', $payload_data->customer_information->postcode ?? null)) {
            $errors[] = 'Customer Postcode is required and cannot be empty';
        }
        if (!$this->emptyCheck('Customer Country', $payload_data->customer_information->country ?? null)) {
            $errors[] = 'Customer Country is required and cannot be empty';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Validate  payload required data (legacy method for backward compatibility)
     *
     * @param mixed $payload_data
     * This is a validation method whitch has all of payload data and it sends data for null & formate validation.
     */
    function Validation($payload_data)
    {
        $result = $this->ValidationWithDetails($payload_data);
        return $result['valid'];
    }


    /**
     * Checks whether a data item is null or empty.
     *
     * @param mixed $attr
     * @param mixed $data
     * @return bool
     */
    function emptyCheck($attr, $data)
    {
        if (!isset($data) || empty($data)) {
            if ($data == 0) return true;
            error_log("$attr is null or empty");
            return false;
        }
        return true;
    }

    /**
     * Checks for valid email format.
     * @param mixed $email
     * @return bool
     */
    function emailCheck($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            error_log("Email format is invalid");
            return false;
        } else {
            return true;
        }
    }

    /**
     * This method is for checking phone number format.
     * @param mixed $phone
     * @return bool
     */
    function phoneCheck($phone)
    {
        if (preg_match("/^([0-9]{11})$/", $phone)) {
            return true;
        } else {
            error_log("Phone number is not valid");
            return false;
        }
    }
}
