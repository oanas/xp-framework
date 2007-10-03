<?php
/* This class is part of the XP framework
 *
 * $Id: RuntimeClassDefinitionTest.class.php 10296 2007-05-08 19:22:33Z friebe $ 
 */

  namespace net::xp_framework::unittest::reflection;

  ::uses('unittest.TestCase', 'util.log.Traceable', 'lang.reflect.Proxy');

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class RuntimeClassDefinitionTest extends unittest::TestCase {

    /**
     * Helper method
     *
     * @param   string name
     * @param   lang.XPClass class
     * @throws  unittest.AssertionFailedError
     */
    protected function assertXPClass($name, $class) {
      $this->assertClass($class, 'lang.XPClass');
      $this->assertEquals($name, $class->getName());
    }

    /**
     * Helper method
     *
     * @param   string name
     * @param   lang.XPClass class
     * @throws  unittest.AssertionFailedError
     */
    protected function defineClass($name, $parent, $interfaces, $bytes) {
      if (class_exists(::xp::reflect($name))) {
        $this->fail('Class "'.$name.'" may not exist!');
      }
      return lang::ClassLoader::defineClass($name, $parent, $interfaces, $bytes);
    }

    /**
     * Test defineClass() method
     *
     */
    #[@test]
    public function defineClassWithInitializer() {
      $name= 'net.xp_framework.unittest.reflection.RuntimeDefinedClass';
      $class= $this->defineClass($name, 'lang.Object', NULL, '{
        public static $initializerCalled= FALSE;
        
        static function __static() { 
          self::$initializerCalled= TRUE; 
        }
      }');
      $this->assertXPClass($name, $class);
      $this->assertTrue(RuntimeDefinedClass::$initializerCalled);
      $this->assertClass($class->getClassLoader(), 'lang.DynamicClassLoader');
    }
    
    /**
     * Tests defineClass() with a given interface
     *
     */
    #[@test]
    public function defineTraceableClass() {
      $name= 'net.xp_framework.unittest.reflection.RuntimeDefinedClassWithInterface';
      $class= $this->defineClass($name, 'lang.Object', array('util.log.Traceable'), '{
        public function setTrace($cat) { } 
      }');

      $this->assertTrue($class->isSubclassOf('util.log.Traceable'));
      $this->assertClass($class->getClassLoader(), 'lang.DynamicClassLoader');
    }

    /**
     * Tests newinstance()
     *
     */
    #[@test]
    public function newInstance() {
      $i= ::newinstance('lang.Object', array(), '{ public function bar() { return TRUE; }}');
      $this->assertClass($i->getClass()->getClassLoader(), 'lang.DynamicClassLoader');
    }

    /**
     * Tests Proxy
     *
     */
    #[@test]
    public function proxyInstance() {
      $c= lang::reflect::Proxy::getProxyClass(
        lang::ClassLoader::getDefault(), 
        array(lang::XPClass::forName('util.log.Traceable'))
      );
      $this->assertClass($c->getClassLoader(), 'lang.DynamicClassLoader');
    }
  }
?>