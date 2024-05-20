<?php
class Clients{
        private $admin_id;
        private $admin_username;
        private $admin_password;
        private $sale_date;
        private $book_id;
        

        public function __construct($admin_id, $admin_username, $admin_password,$sale_date,$book_id){
            $this->client_id = $admin_id;
            $this->admin_username=$admin_username;
            $this->admin_password=$admin_password;
            $this->sale_date = $sale_date;
            $this->book_id = $book_id;
        }

        public function setAdmin_id($admin_id) {
            $this->client_id = $admin_id;
        }
    
        
        public function getAdmin_id() {
            return $this->admin_id;
        }

        public function setAdmin_username($admin_username) {
            $this->client_username = $admin_username;
        }
    
        
        public function getClient_username() {
            return $this->admin_username;
        }

        public function setAdmin_password($admin_password) {
            $this->client_password = $admin_password;
        }
    
        
        public function getAdmin_password() {
            return $this->admin_password;
        }

      
    
    }
    
