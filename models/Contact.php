<?php
class Contact
{
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $message;
    public $ip_address;
    public $time;

    // Database stuff
    private $conn;
    private $contact_form = "contact_form";

    // Connecting to Database with Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create the form
    public function create_form()
    {
        $query = 'INSERT INTO ' . $this->contact_form . ' SET
        email = :email,
        name = :name,
        phone = :phone,
        subject = :subject,
        message = :message,
        ip_address = :ip_address';

        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':subject', $this->subject);
        $stmt->bindParam(':message', $this->message);
        $stmt->bindParam(':ip_address', $this->ip_address);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Check Duplicate Entry
    public function check_duplicacy()
    {
        $query = 'SELECT email FROM ' . $this->contact_form . ' WHERE email = :email';

        // Prepared Statement
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $this->email);

        // Execute query
        $stmt->execute();

        return $stmt;
    }
}
