<?php 
    class Venta{
        private $id;
        private $idComprador;
        private $idAnuncio;
        

        /**
         * Get the value of id
         */
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         */
        public function setId($id): self
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of idComprador
         */
        public function getIdComprador()
        {
                return $this->idComprador;
        }

        /**
         * Set the value of idComprador
         */
        public function setIdComprador($idComprador): self
        {
                $this->idComprador = $idComprador;

                return $this;
        }

        /**
         * Get the value of idAnuncio
         */
        public function getIdAnuncio()
        {
                return $this->idAnuncio;
        }

        /**
         * Set the value of idAnuncio
         */
        public function setIdAnuncio($idAnuncio): self
        {
                $this->idAnuncio = $idAnuncio;

                return $this;
        }
    }
?>