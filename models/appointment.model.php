<?php 

require_once __DIR__ . "/../database/db.php";

class AppointmentModel {
    private $db;
    public function __construct(){
        $this->db = new Database();
        $this->db = $this->db->getPDO();
    }
    public function createAppointment($owner_name, $owner_email, $pet_name, $pet_species, $pet_breed, $pet_age, $pet_weight, $appointment_date, $problem_description, $pet_photo){
        try {
            $stmt = $this->db->prepare("INSERT INTO appointments (owner_name, owner_email, pet_name, pet_species, pet_breed, pet_age, pet_weight, appointment_date, problem_description, pet_photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$owner_name, $owner_email, $pet_name, $pet_species, $pet_breed, $pet_age, $pet_weight, $appointment_date, $problem_description, $pet_photo]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function getAppointments(){
        $stmt = $this->db->prepare("SELECT * FROM appointments ORDER BY appointment_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAppointmentById($id){
        try {
            $stmt = $this->db->prepare("SELECT * FROM appointments WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function updateAppointment($id, $owner_name, $owner_email, $pet_name, $pet_species, $pet_breed, $pet_age, $pet_weight, $appointment_date, $problem_description, $pet_photo){
        try {
            if($pet_photo) {
                $stmt = $this->db->prepare("UPDATE appointments SET owner_name = ?, owner_email = ?, pet_name = ?, pet_species = ?, pet_breed = ?, pet_age = ?, pet_weight = ?, appointment_date = ?, problem_description = ?, pet_photo = ? WHERE id = ?");
                $stmt->execute([$owner_name, $owner_email, $pet_name, $pet_species, $pet_breed, $pet_age, $pet_weight, $appointment_date, $problem_description, $pet_photo, $id]);
            } else {
                $stmt = $this->db->prepare("UPDATE appointments SET owner_name = ?, owner_email = ?, pet_name = ?, pet_species = ?, pet_breed = ?, pet_age = ?, pet_weight = ?, appointment_date = ?, problem_description = ? WHERE id = ?");
                $stmt->execute([$owner_name, $owner_email, $pet_name, $pet_species, $pet_breed, $pet_age, $pet_weight, $appointment_date, $problem_description, $id]);
            }
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function deleteAppointment($id){
        try {
            $stmt = $this->db->prepare("DELETE FROM appointments WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}


