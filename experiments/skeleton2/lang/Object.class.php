<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  /**
   * Class Object is the root of the class hierarchy. Every class has 
   * Object as a superclass. 
   *
   * @purpose  Base class for all others
   */
  class Object implements Generic {
    protected $__id = NULL;
    
    /**
     * Returns a hashcode for this object
     *
     * @access  public
     * @return  string
     */
    public function hashCode() {
      if (!$this->__id) $this->__id= microtime();
      return $this->__id;
    }
    
    /**
     * Indicates whether some other object is "equal to" this one.
     *
     * @access  public
     * @param   &lang.Generic cmp
     * @return  bool TRUE if the compared object is equal to this object
     */
    public function equals(Generic $cmp) {
      return $this === $cmp;
    }

    /**
     * Destructor
     *
     * @access  public
     */
    function __destruct() {
      unset($this);
    }

    /** 
     * Returns the fully qualified class name for this class 
     * (e.g. "io.File")
     *
     * This is a shorthand for the following:
     * <code>
     *   $name= $instance->getClass()->getName();
     * </code>
     * 
     * @model   final
     * @access  public
     * @return  string fully qualified class name
     */
    public final function getClassName() {
      return xp::nameOf(get_class($this));
    }

    /**
     * Returns the runtime class of an object.
     *
     * @model   final
     * @access  public
     * @return  &lang.XPClass runtime class
     * @see     xp://lang.XPClass
     */
    public final function getClass() {
      return XPClass::forInstance($this);
    }

    /**
     * Creates a string representation of this object. In general, the toString 
     * method returns a string that "textually represents" this object. The result 
     * should be a concise but informative representation that is easy for a 
     * person to read. It is recommended that all subclasses override this method.
     * 
     * Per default, this method returns:
     * <xmp>
     *   [fully-qualified-class-name]@[serialized-object]
     * </xmp>
     * 
     * Example:
     * <xmp>
     * lang.Object@class object {
     *   var $__id = '0.06823200 1062749651';
     * }
     * </xmp>
     *
     * @access  public
     * @return  string
     */
    public function toString() {
      return self::getClassName().'@'.var_export($this, 1);
    }

    /**
     * Wrapper for PHP's builtin cast mechanism
     *
     * @see     xp://lang.Object#toString
     * @access  public
     * @return  string
     */
    public function __toString() {
      return $this->toString();
    }
  }
?>
