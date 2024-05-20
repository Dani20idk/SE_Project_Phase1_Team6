<?php
class Books{
        private $book_id;
        private $book_title;
        private $book_image;
        private $book_description;
        private $book_price;
       
        private $Category;
    

        public function __construct($book_id, $book_title,$book_image, $book_description, $book_price,$Category){
            $this->book_id = $book_id;
            $this->book_title = $book_title;
            $this->book_image = $book_image;
            $this->book_description = $book_description;
           $this->book_price = $book_price;
            $this->Category = $Category;
        }

        public function setBook_id($book_id) {
            $this->book_id = $book_id;
        }
    
        
        public function getBook_id() {
            return $this->book_id;
        }

        public function setBook_title($book_title) {
            $this->book_title = $book_title;
        }
    
        
        public function getBook_title() {
            return $this->book_title;
        }

        public function setBook_image($book_image) {
            $this->book_image = $book_image;
        }
    
        
        public function getBook_image() {
            return $this->book_image;
        }

        public function setBook_description($book_description) {
            $this->book_description = $book_description;
        }
    
        
        public function getBook_description() {
            return $this->book_description;
        }

        public function setBook_price($book_price) {
            $this->book_price = $book_price;
            // $this->myProperty = $value;
        }
    
        
        public function getBook_price() {
            return $this->book_price;
        }

       
    
        
        
        public function setCategory($Category) {
            $this->Category = $Category;
        }
    
        
        public function getCategory() {
            return $this->Category;
        }
    }

?>
    

    