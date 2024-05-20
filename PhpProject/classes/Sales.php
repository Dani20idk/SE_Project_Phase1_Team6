<?php
    class Sales{
        private $sale_id;
        private $sale_date;
        private $book_id;
        private $client_id;
        private $quantity;
        private $subtotal;
        private $total;
    

        public function __construct($sale_id, $sale_date, $book_id, $client_id, $quantity,$subtotal,$total){
            $this->sale_id = $sale_id;
            $this->sale_date = $sale_date;
            $this->book_id = $book_id;
            $this->client_id = $client_id;
            $this->quantity = $quantity;
            $this->subtotal = $subtotal;
            $this->total = $total;
            
        }

        public function setSale_id($sale_id) {
            $this->sale_id = $sale_id;
        }
    
        
        public function getSale_id() {
            return $this->sale_id;
        }

        public function setSale_date($sale_date) {
            $this->sale_date = $sale_date;
        }
    
        public function getSale_date(){
            return $this->sale_date;
        }
        
        public function getBook_id() {
            return $this->book_id;
        }

        public function setBook_id($book_id) {
            $this->book_id = $book_id;
        }
    
        
        public function getClient_id() {
            return $this->book_id;
        }

        public function setClient_id($client_id) {
            $this->client_id = $client_id;
        }

        public function setQuantity ($quantity){
            $this->quantity = $quantity;
        }

        public function getQuantity (){
            return $this->quantity;
        }
    
        public function setSubtotal($subtotal){
            $this->subtotal = $subtotal;
        }

        public function getSubtotal(){
            return $this->subtotal;
        }
        public function setTotal($total){
            $this->total = $total;
        }

        public function getTotal (){
            return $this->total;
        }
    }
    ?>