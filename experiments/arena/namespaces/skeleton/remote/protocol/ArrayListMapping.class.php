<?php
/* This class is part of the XP framework
 *
 * $Id: ArrayListMapping.class.php 10594 2007-06-11 10:04:54Z friebe $ 
 */

  namespace remote::protocol;

  uses('lang.types.ArrayList', 'remote.protocol.SerializerMapping');

  /**
   * Mapping for strictly numeric arrays
   *
   * @see      xp://remote.protocol.Serializer
   * @purpose  Mapping
   */
  class ArrayListMapping extends lang::Object implements SerializerMapping {

    /**
     * Returns a value for the given serialized string
     *
     * @param   server.protocol.Serializer serializer
     * @param   remote.protocol.SerializedData serialized
     * @param   array<string, mixed> context default array()
     * @return  mixed
     */
    public function valueOf($serializer, $serialized, $context= array()) {
      $a= lang::types::ArrayList::newInstance($serialized->consumeSize());
      
      $serialized->offset++;  // Opening "{"
      for ($i= 0; $i < $a->length; $i++) {
        $a->values[$i]= $serializer->valueOf($serialized, $context);
      }
      $serialized->offset++;  // Closing "}"
      return $a;
    }

    /**
     * Returns an on-the-wire representation of the given value
     *
     * @param   server.protocol.Serializer serializer
     * @param   lang.Object value
     * @param   array<string, mixed> context default array()
     * @return  string
     */
    public function representationOf($serializer, $value, $context= array()) {
      $s= 'A:'.sizeof($value->values).':{';
      foreach (array_keys($value->values) as $key) {
        $s.= $serializer->representationOf($value->values[$key], $context);
      }
      return $s.'}';
    }
    
    /**
     * Return XPClass object of class supported by this mapping
     *
     * @return  lang.XPClass
     */
    public function handledClass() {
      return lang::XPClass::forName('lang.types.ArrayList');
    }
  } 
?>