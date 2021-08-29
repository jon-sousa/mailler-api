<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
   use HasFactory;

   protected string $nome;
    
   protected string $email;
   
   protected \DateTimeInterface $ultimoContato;
   
   protected \DateInterval $frequencia;
   
   protected $desejaReceberContato = true;

   protected $attributes = [];


   /**
    * Get the value of nome
    */ 
   public function getNome()
   {
      return $this->nome;
   }

   /**
    * Set the value of nome
    *
    * @return  self
    */ 
   public function setNome($nome)
   {
      $this->nome = $nome;
      $this->attributes['nome'] = $nome;
      return $this;
   }

   /**
    * Get the value of email
    */ 
   public function getEmail()
   {
      return $this->email;
   }

   /**
    * Set the value of email
    *
    * @return  self
    */ 
   public function setEmail($email)
   {
      $this->email = $email;
      $this->attributes['email'] = $email;
      return $this;
   }

   /**
    * Get the value of frequencia
    */ 
   public function getFrequencia()
   {
      return $this->frequencia;
   }

   /**
    * Set the value of frequencia
    *
    * @return  self
    */ 
   public function setFrequencia(int $frequencia)
   {
      $this->frequencia = new \DateInterval('P'.$frequencia.'D');
      $this->attributes['frequencia'] = $frequencia;

      return $this;
   }

   /**
    * Get the value of ultimoContato
    */ 
   public function getUltimoContato()
   {
      return $this->ultimoContato;
   }

   /**
    * Set the value of ultimoContato
    *
    * @return  self
    */ 
   public function setUltimoContato(string $ultimoContato)
   {
      $data = new \DateTime($ultimoContato);
      $this->ultimoContato = $data;
      $this->attributes['ultimoContato'] = $ultimoContato   ;

      return $this;
   }

   /**
    * Get the value of desejaReceberContato
    */ 
   public function getDesejaReceberContato()
   {
      return $this->desejaReceberContato;
   }

   /**
    * Set the value of desejaReceberContato
    *
    * @return  self
    */ 
   public function setDesejaReceberContato($desejaReceberContato)
   {
      $this->desejaReceberContato = $desejaReceberContato;
      $this->attributes['desejaReceberContato'] = $desejaReceberContato;
      return $this;
   }

   public function setFromArray(array $dadosCliente){
      foreach($dadosCliente as $chave => $dado){
         $method = 'set' . $chave;
         
         if(method_exists($this, $method)){
            $this->$method($dado);
         }
     }
   }

   public function disponivelParaEmail(){
      if($this->attributes['desejaReceberContato'] === false){
         return false;
      }
      
      $hoje = new \DateTimeImmutable();
      $ultimoContato = new \DateTimeImmutable($this->attributes['ultimoContato']);
      $diasSemContato = (int)($hoje->diff($ultimoContato))->days;

      //var_dum($diasSemContato);

      if($diasSemContato >= $this->attributes['frequencia']){
          return true;
      }

      return false;
   }
}
