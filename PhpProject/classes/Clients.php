<?php
class Clients{
        private $client_id;
        private $client_username;
        private $client_password;
        private $sale_date;
        private $book_id;
        

        public function __construct($client_id, $client_username, $client_password,$sale_date,$book_id){
            $this->client_id = $client_id;
            $this->sale_date = $sale_date;
            $this->book_id = $book_id;
        }

        public function setClient_id($client_id) {
            $this->client_id = $client_id;
        }
    
        
        public function getClient_id() {
            return $this->client_id;
        }

        public function setClient_username($client_username) {
            $this->client_username = $client_username;
        }
    
        
        public function getClient_username() {
            return $this->client_username;
        }

        public function setClient_password($client_password) {
            $this->client_password = $client_password;
        }
    
        
        public function getClient_password() {
            return $this->client_password;
        }

      
    
    }
    ?>
