<?php

// User class 
// for getting and setting DB values 

class Pixel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    ///////////////////////////////////////////////
	// Create user with given sanitized data 
	// @return Boolean 
	public function create($data)
	{
	    // DB uzklausos paruosimas (prepare DB statement)
	    $this->db->query("INSERT INTO pixels (`user_id`,  `coordinate_x`, `coordinate_y`, `color`, `size`) VALUES (:user_id, :coordinate_x, :coordinate_y, :color, :size)");

	    // add values (istatymas su bind)
	    $this->db->bind(':user_id', $data['user_id']);
	    $this->db->bind(':coordinate_x', $data['coordinate_x']);
	    $this->db->bind(':coordinate_y', $data['coordinate_y']);
	    $this->db->bind(':color', $data['color']);
	    $this->db->bind(':size', $data['size']);

	    // make query / execute - ivykdo sql uzklausa
	    if ($this->db->execute()) {
	        return true;
	    } else {
	        return false;
	    }
	}

	///////////////////////////////////////////////
	// kuriamas models metodas get_user_pixels, kuris gaus pikselius is DB
	public function get_user_pixels($user_id)
	{
		// DB metodas query - uzklausos sukurimas
		// istraukimas is pixels lenteles user_id stulpelis
	    $this->db->query("SELECT * FROM pixels WHERE `user_id` = :user_id");
	    // istatymas su bind
	    $this->db->bind(':user_id', $user_id);
	    // metodas resultSet() - grazina uzklausos rezultatus kaip masyva
	    $row = $this->db->resultSet();
        // check if we got some results
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
	}

	///////////////////////////////////////////////
	// kuriamas models metodas get_all_pixels, kuris gaus visu vartotoju pikselius is DB
	public function get_all_pixels()
	{
		// DB metodas query - uzklausos sukurimas
	    $this->db->query("SELECT * FROM pixels");
	    // metodas resultSet() - grazzina uzklausos rezultatus kaip masyva
	    $row = $this->db->resultSet();
        // check if we got some results
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
	}

	///////////////////////////////////////////////
	// kuriamas models metodas delete_pixel, kuris istrins viena pikseli
	public function delete_pixel($pixel_id) { 
		$this->db->query("DELETE FROM pixels WHERE `pixel_id` = :pixel_id");
		// istatymas su bind
	    $this->db->bind(':pixel_id', $pixel_id);
	    // execute - ivykdo sql uzklausa
	    if ($this->db->execute()) {
	        return true;
	    } else {
	        return false;
	    }
	}

	///////////////////////////////////////////////
	// kuriamas models metodas get_pixel, kuris istrauks viena pikseli
	public function get_pixel($pixel_id) { 
		$this->db->query("SELECT * FROM pixels WHERE `pixel_id` = :pixel_id");
		// istatymas su bind
	    $this->db->bind(':pixel_id', $pixel_id);
	    // resultSet() - grazina uzklausos rezultatus kaip masyva
	    $row = $this->db->resultSet();
        // patikrina ar uzklausa grazina rezultata
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    ///////////////////////////////////////////////
	// kuriamas models metodas update, kuris istrauks viena pikseli
	// cia $data yra masyvas(omenyje)
	// UPDATE - pakeicia egzistuojancia eilute pikseliu lenteleje
	public function update($data) {
		$this->db->query("UPDATE pixels SET coordinate_x = :coordinate_x, coordinate_y = :coordinate_y, color = :color, size = :size WHERE `pixel_id` = :pixel_id");
		// istatymas su bind
	    $this->db->bind(':coordinate_x', $data['coordinate_x']);
	    $this->db->bind(':coordinate_y', $data['coordinate_y']);
	    $this->db->bind(':color', $data['color']);
	    $this->db->bind(':size', $data['size']);
	    $this->db->bind(':pixel_id', $data['pixel_id']);
	    // execute - ivykdo sql uzklausa
	    if ($this->db->execute()) {
	        return true;
	    } else {
	        return false;
	    }
	}
}