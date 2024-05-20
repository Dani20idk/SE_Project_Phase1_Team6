<?php
class Contact{
        private $contact_id;
        private $name;
        private $email;
        private $phone_number;
        private $message;
        

        public function __construct($contact_id, $name, $email,$phone_number,$message){
            $this->contact_id = $contact_id;
            $this->name = $name;
            $this->phone_number = $phone_number;
            $this->email=$email;
            $this->message=$message;
        }

        public function setContact_id($contact_id) {
            $this->contact_id = $contact_id;
        }
    
        
        public function getContact_id() {
            return $this->contact_id;
        }

        public function setName($name) {
            $this->name = $name;
        }
        public function getName() {
            return $this->name;}

        public function getEmail() {
            return $this->email;}

            public function setEmail($email) {
                $this->email = $email;
            }

            public function setPhone_Number($phone_number) {
                $this->phone_number = $phone_number;
            }
            
            public function getPhone_Number() {
                return $this->phone_number;}
              
                public function setMessage($message) {
                    $this->$message = $message;
                }
                
                public function getMessage() {
                    return $this->message;}
    }
    ?>
