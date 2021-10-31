<?php

// User class 
// for getting and setting database values 

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    //////////////////////////////////////////
    // finds user by given email
    // @return Boolean
    public function findUserByEmail($email)
    {
        // check if the given email is in data base
        // prepare statement
        $this->db->query("SELECT * FROM users WHERE `e-mail` = :email");

        // add values to statment
        $this->db->bind(':email', $email);

        // save result in $row
        $row = $this->db->singleRow();

        // check if we got some results
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    //////////////////////////////////////////
    // Register user with given sanitized data 
    // @return Boolean (true / false)
    public function register($data)
    {
        // DB uzklausos paruosimas (prepare DB statement)
        $this->db->query("INSERT INTO users (`firstname`,  `lastname`, `e-mail`, `password`) VALUES (:firstname, :lastname, :email, :password)");

        // add values
        $this->db->bind(':firstname', $data['firstname']);
        $this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':email', $data['email']);

        // hasshed
        $this->db->bind(':password', $data['password']);

        // make query / execute - ivykdo sql uzklausa
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    //////////////////////////////////////////
    // Checks in the database for the email and password
    // tries to verify password
    // return row or false 
    public function login($email, $notHashedPass)
    {
        // get the row whith given email 
        $this->db->query("SELECT * FROM users WHERE `e-mail` = :email");
        // nurodoma reiksme pries tai paruostam sql sakiniui
        // bind - reiksmes 5statymas ($email)
        $this->db->bind(':email', $email);
        // randa DB eilute pgl email
        $row = $this->db->singleRow();
        // jei randa
        if ($row) {
            // istraukiant DB password stulpeli - sukuriamas kintamasis 
            $hashedPassword = $row->password;
        } else {
            return false;
        }

        // check password
        if (password_verify($notHashedPass, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

}
