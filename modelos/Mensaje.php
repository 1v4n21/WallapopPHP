<?php
class Mensaje
{
        private $id;
        private $mensaje;
        private $emailAutor;
        private $idRemitente;


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
         * Get the value of mensaje
         */
        public function getMensaje()
        {
                return $this->mensaje;
        }

        /**
         * Set the value of mensaje
         */
        public function setMensaje($mensaje): self
        {
                $this->mensaje = $mensaje;

                return $this;
        }

        /**
         * Get the value of emailAutor
         */
        public function getEmailAutor()
        {
                return $this->emailAutor;
        }

        /**
         * Set the value of emailAutor
         */
        public function setEmailAutor($emailAutor): self
        {
                $this->emailAutor = $emailAutor;

                return $this;
        }

        /**
         * Get the value of idRemitente
         */
        public function getIdRemitente()
        {
                return $this->idRemitente;
        }

        /**
         * Set the value of idRemitente
         */
        public function setIdRemitente($idRemitente): self
        {
                $this->idRemitente = $idRemitente;

                return $this;
        }
}
?>