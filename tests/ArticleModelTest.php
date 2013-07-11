<?php


/**
 * Description of ArticleModelTest
 *
 * @author canals
 */
class ArticleModelTest extends PHPUnit_Framework_TestCase{

    protected $article ;
    
    protected function setUp() {
      $this->article= new Article( new MockMapper() );
    }
    
    /**
     * @test
     */
    public function testgetAttributes() {
        
        $this->assertEquals($this->article->getAttributes(),
                             array('id'=>'number','nom'=>'string', 
                                   'descr'=>'string', 'tarif'=>'number',
                                   'id_categ'=>'number'));
    }
    /**
     * @test
     */
    public function testgetModelName() {
        
        $this->assertEquals($this->article->getModelName(),'Article');
                             
    }
    /**
     * @test
     * @depends testgetAttributes
     */
    public function testSetAttr() {
        $this->article->setAttr('id', 1);
        $this->article->setAttr('nom', 'velo');
        $this->article->setAttr('tarif', 5.55);
        $this->assertEquals($this->article->_v['id'],1);
        $this->assertEquals($this->article->_v['nom'],'velo');
        $this->assertEquals($this->article->_v['tarif'],5.55);
    }
    /**
     * @test
     * @depends testgetAttributes
     * @expectedException \dice\model\ModelException
     */
    public function testSetAttrException() {
        $this->article->setAttr('id', 1);
        $this->article->setAttr('nom', 'velo');
        $this->article->setAttr('tarif', 5.55);
        $this->article->setAttr('toto',42);
    }
    
    /**
     * @test
     * @depends testSetAttr
     */
    public function testgetAttr() {
        $this->article->setAttr('id', 1);
        $this->article->setAttr('nom', 'velo');
        $this->article->setAttr('tarif', 5.55);
        $this->assertEquals($this->article->getAttr('id'),1);
        $this->assertEquals($this->article->getAttr('nom'),'velo');
        $this->assertEquals($this->article->getAttr('tarif'),5.55);
        
    }
    /**
     * @test
     * @depends testSetAttr
     */
    public function testgetOid() {
        $this->article->setAttr('id', 1);
        $this->article->setAttr('nom', 'velo');
        $this->article->setAttr('tarif', 5.55);
        $this->assertEquals(1,$this->article->getOid());
    }
    /**
     * @test
     * @depends testgetOid
     */
    public function testsetOid() {
        $this->article->setOid( 1);
        $this->article->setAttr('nom', 'velo');
        $this->article->setAttr('tarif', 5.55);
        $this->assertEquals(1, $this->article->getOid());
    }
    /**
     * @test
     * @depends testSetAttr()
     */
    public function testDelete() {
        $this->article->setAttr('id', 1);
        $this->article->setAttr('nom', 'velo');
        $this->article->setAttr('tarif', 5.55);
        $this->assertEquals($this->article, $this->article->delete());
    }
    /**
     * @test
     * @depends testSetAttr()
     * @expectedException \dice\model\ModelException
     */
    public function testDeleteException() {
        //$this->article->setAttr('id', 1);
        $this->article->setAttr('nom', 'velo');
        $this->article->setAttr('tarif', 5.55);
        $this->assertEquals($this->article, $this->article->delete());
    }
    /**
     * @test
     * @depends testSetAttr()
     */
    public function testInsert() {
        //$this->article->setAttr('id', 1);
        $this->article->setAttr('nom', 'velo');
        $this->article->setAttr('tarif', 5.55);
        $this->assertEquals($this->article, $this->article->insert());
    }
    /**
     * @test
     * @depends testSetAttr()
     */
    public function testUpdate() {
        $this->article->setAttr('id', 1);
        $this->article->setAttr('nom', 'velo');
        $this->article->setAttr('tarif', 5.55);
        $this->assertEquals($this->article, $this->article->update());
    }
    /**
     * @test
     * @depends testSetAttr()
     * @expectedException \dice\model\ModelException
     */
    public function testUpdateException() {
        //$this->article->setAttr('id', 1);
        $this->article->setAttr('nom', 'velo');
        $this->article->setAttr('tarif', 5.55);
        $this->assertEquals($this->article, $this->article->update());
    }
    
    /**
     * @test
     */
    public function testgetMapperClass() {
        $this->assertEquals('ArticleMapper', Article::getDefaultMapperClass());
    }
    /**
     * @test
     * @depends testgetMapperClass
     */
    public function testsetMapperClass() {
        Article::setDefaultMapperClass('MockMapper');
        $this->assertEquals('MockMapper', Article::getDefaultMapperClass());
    }
    /**
     * @test
     * @depends testsetMapperClass
     */
    public function testfind_one() {
        Article::setDefaultMapperClass('MockMapper');
        $this->assertNull( Article::find_one());
        $this->assertEquals('a', Article::find_one(1));
    }
    /**
     * @test
     * @depends testsetMapperClass
     */
    public function testfind_many() {
        Article::setDefaultMapperClass('MockMapper');
        $this->assertNull( Article::find_many());
        $this->assertEquals(array('a', 'b','c'), Article::find_many(1));
    }
    
}

?>
