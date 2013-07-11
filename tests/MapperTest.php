<?php

/**
 * Description of MapperTest
 *
 * @author canals
 */
class MapperTest extends PHPUnit_Framework_TestCase {
    protected $mapper;
    
    public function setUp() {
        $dsn='mysql:host=localhost;port=8889;dbname=tmap';
        $user='tmap';$pass='tmap';
        $this->mapper= new ArticleMapper(new MockPDO($dsn, $user, $pass));
    }
    
    /**
     * @test
     */
    public function testInsert() {
        $a=new Article($this->mapper);
        $a->setAttr('nom','velo');
        $a->setAttr('descr','beau velo');
        $a->setAttr('tarif',75.55);
        $a->setAttr('id_categ',1);
        $this->mapper->_insert($a);
        $this->assertEquals("insert into article (id,nom,descr,tarif,id_categ) values ( ? , ? , ? , ? , ? )", 
                $this->mapper->get_last_query());
        $this->assertEquals(array('null','velo','beau velo',75.55,1), $this->mapper->get_last_query_params());
        $this->assertEquals(1001, $a->getOid());
    }
    /**
     * @test
     */
    public function testDelete() {
        $a=new Article($this->mapper);
        $a->setAttr('id',1);
        $a->setAttr('nom','velo');
        $a->setAttr('descr','beau velo');
        $a->setAttr('tarif',75.55);
        $a->setAttr('id_categ',1);
        $this->mapper->_delete($a);
        $this->assertEquals("delete from article where id= ?" , 
                            $this->mapper->get_last_query());
        $this->assertEquals(array(1), $this->mapper->get_last_query_params());
        //$this->assertEquals(1001, $a->getOid());
    }
    /**
     * @test
     * @expectedException dice\mapper\MapperException
     */
    public function testDeleteException() {
        $a=new Article($this->mapper);
        $a->setAttr('nom','velo');
        $a->setAttr('descr','beau velo');
        $a->setAttr('tarif',75.55);
        $a->setAttr('id_categ',1);
        $this->mapper->_delete($a);
    }
    /**
     * @test
     */
    public function testUpdate() {
        $a=new Article($this->mapper);
        $a->setAttr('id',1);
        $a->setAttr('nom','velo');
        $a->setAttr('descr','beau velo');
        $a->setAttr('tarif',75.55);
        $a->setAttr('id_categ',1);
        $this->mapper->_update($a);
        $this->assertEquals("update article set id = ? ,nom = ? ,descr = ? ,tarif = ? ,id_categ = ?  where id = 1" , 
                            $this->mapper->get_last_query());
        $this->assertEquals(array(1,'velo','beau velo',75.55,1), $this->mapper->get_last_query_params());
        //$this->assertEquals(1001, $a->getOid());
    }
    /**
     * @test
     * @expectedException dice\mapper\MapperException
     */
    public function testUpdateException() {
        $a=new Article($this->mapper);
        $a->setAttr('nom','velo');
        $a->setAttr('descr','beau velo');
        $a->setAttr('tarif',75.55);
        $a->setAttr('id_categ',1);
        $this->mapper->_update($a);
    }
    /**
     * @test
     */
    public function testFindId() {
        $a=$this->mapper->_find(1);
        $this->assertEquals("select * from article where id = ?", 
                            $this->mapper->get_last_query());
        $this->assertEquals(array(1), $this->mapper->get_last_query_params());
    }
    /**
     * @test
     */
    public function testFindAll() {
        $a=$this->mapper->_find();
        $this->assertEquals("select * from article", 
                            $this->mapper->get_last_query());
    }
    /**
     * @test
     */
    public function testFindCond1() {
        $a=$this->mapper->_find(array('conditions'=>array('nom'=> 'velo')));
        $this->assertEquals("select * from article where nom LIKE ?", 
                            $this->mapper->get_last_query());
        $this->assertEquals(array('velo'), $this->mapper->get_last_query_params());
    }
    /**
     * @test
     */
    public function testFindCond2() {
        $a=$this->mapper->_find(array('conditions'=>array('nom'=> 'velo','id_categ'=>1,'tarif'=>49.95)));
        $this->assertEquals("select * from article where nom LIKE ? AND id_categ = ? AND tarif = ?", 
                            $this->mapper->get_last_query());
        $this->assertEquals(array('velo',1,49.95), $this->mapper->get_last_query_params());
    }
    /**
     * @test
     */
    public function testFindOrder1() {
        $a=$this->mapper->_find(array('orders'=>array('orderby'=>'nom')));//=> 'velo','id_categ'=>1,'tarif'=>49.95)));
        $this->assertEquals("select * from article ORDER BY nom ASC", 
                            $this->mapper->get_last_query());
        
    }
    /**
     * @test
     */
    public function testFindOrder2() {
        $a=$this->mapper->_find(array('orders'=>array('orderby'=>'nom, descr','ord'=> dice\mapper\SQLMapper::ORDER_DESC)));
        $this->assertEquals("select * from article ORDER BY nom, descr DESC", 
                            $this->mapper->get_last_query());
        //$this->assertEquals(array('velo',1,49.95), $this->mapper->get_last_query_params());
    }
    /**
     * @test
     */
    public function testFindOrderAnCond() {
        $a=$this->mapper->_find(array('conditions'=>array('id_categ'=>1,'tarif'=>49.95),
                                      'orders'=>array('orderby'=>'nom, descr','ord'=> dice\mapper\SQLMapper::ORDER_DESC)));
        $this->assertEquals("select * from article where id_categ = ? AND tarif = ? ORDER BY nom, descr DESC", 
                            $this->mapper->get_last_query());
        $this->assertEquals(array(1,49.95), $this->mapper->get_last_query_params());
    }
    
    
    
    
    
    
    
}

?>
