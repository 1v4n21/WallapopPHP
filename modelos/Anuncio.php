<?php
class Anuncio
{
        private $id;
        private $idUsuario;
        private $titulo;
        private $descripcion;
        private $foto_principal;
        private $foto2;
        private $foto3;
        private $foto4;
        private $precio;
        private $fecha_creacion;
        private $vendido;
        private $idComprador;



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
         * Get the value of idUsuario
         */
        public function getIdUsuario()
        {
                return $this->idUsuario;
        }

        /**
         * Set the value of idUsuario
         */
        public function setIdUsuario($idUsuario): self
        {
                $this->idUsuario = $idUsuario;

                return $this;
        }

        /**
         * Get the value of titulo
         */
        public function getTitulo()
        {
                return $this->titulo;
        }

        /**
         * Set the value of titulo
         */
        public function setTitulo($titulo): self
        {
                $this->titulo = $titulo;

                return $this;
        }

        /**
         * Get the value of descripcion
         */
        public function getDescripcion()
        {
                return $this->descripcion;
        }

        /**
         * Set the value of descripcion
         */
        public function setDescripcion($descripcion): self
        {
                $this->descripcion = $descripcion;

                return $this;
        }

        /**
         * Get the value of foto_principal
         */
        public function getFotoPrincipal()
        {
                return $this->foto_principal;
        }

        /**
         * Set the value of foto_principal
         */
        public function setFotoPrincipal($foto_principal): self
        {
                $this->foto_principal = $foto_principal;

                return $this;
        }

        /**
         * Get the value of foto2
         */
        public function getFoto2()
        {
                return $this->foto2;
        }

        /**
         * Set the value of foto2
         */
        public function setFoto2($foto2): self
        {
                $this->foto2 = $foto2;

                return $this;
        }

        /**
         * Get the value of foto3
         */
        public function getFoto3()
        {
                return $this->foto3;
        }

        /**
         * Set the value of foto3
         */
        public function setFoto3($foto3): self
        {
                $this->foto3 = $foto3;

                return $this;
        }

        /**
         * Get the value of foto4
         */
        public function getFoto4()
        {
                return $this->foto4;
        }

        /**
         * Set the value of foto4
         */
        public function setFoto4($foto4): self
        {
                $this->foto4 = $foto4;

                return $this;
        }

        /**
         * Get the value of precio
         */
        public function getPrecio()
        {
                return $this->precio;
        }

        /**
         * Set the value of precio
         */
        public function setPrecio($precio): self
        {
                $this->precio = $precio;

                return $this;
        }

        /**
         * Get the value of fecha_creacion
         */
        public function getFechaCreacion()
        {
                return $this->fecha_creacion;
        }

        /**
         * Set the value of fecha_creacion
         */
        public function setFechaCreacion($fecha_creacion): self
        {
                $this->fecha_creacion = $fecha_creacion;

                return $this;
        }

        /**
         * Get the value of vendido
         */
        public function getVendido()
        {
                return $this->vendido;
        }

        /**
         * Set the value of vendido
         */
        public function setVendido($vendido): self
        {
                $this->vendido = $vendido;

                return $this;
        }

        public function getIdComprador()
        {
                return $this->idComprador;
        }

        public function setIdComprador($idComprador)
        {
                $this->idComprador = $idComprador;
        }

        //Obtiene los dias que lleva publicado el anuncio
        public function diasDesdeCreacion(): string
        {
                $fechaCreacion = new DateTime($this->getFechaCreacion());
                $fechaActual = new DateTime();
                $diferencia = $fechaActual->diff($fechaCreacion);

                $dias = $diferencia->days;

                if ($dias == 0) {
                        return "Hoy";
                } elseif ($dias == 1) {
                        return "Hace 1 día";
                } else {
                        return "Hace " . $dias . " días";
                }
        }
}
