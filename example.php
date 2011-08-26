<?php
/**
 * All blocks must be children of the BasicBlock class and implement the iBlock interface
**/
sys::import('xaraya.structures.containers.blocks.basicblock');
class ExampleBlock extends BasicBlock implements iBlock
{
/**
 * Here we supply data to the blocks subsystem about this block type
 * Since the values supplied here don't change these properties
 * have protected visibility to prevent them being overwritten
**/
    protected $type = 'example';
    protected $text_type = 'Example';
    protected $text_type_long = 'SoloBlocks Example Block';
    protected $xarversion = '2.3.0';
    protected $author = 'Chris Powis';
    protected $contact = 'crisp@xaraya.com';
    
    // there may be times where preview doesn't make sense (eg,themes meta block) 
    protected $show_preview = true; // set false to disable previewing
    // let the subsystem know if our block has a help display
    protected $show_help = false;   // set true if a help method and help-type.xt template are supplied

/**
 * Here we declare our public properties.
 * The values of these are stored in the database.
 * NOTE: you should take care not to re-use properties already
 * declared by the BasicBlock class here
**/    
    public $example_text = 'Hello World!';
/**
 * We could also declare protected properties...
 * The values of these aren't stored in the database.
**/
    //protected $not_persistent = 'forget me';

/**
 * Subsystem methods
 * These are optional methods which you may supply. If supplied
 * the methods must be declared in the parent class (ie this one)
**/
/**
 * Init
 *
 * This method is called by the blocks subsystem every time a block of this
 * type is instantiated. 
 * NOTE: the __construct() method cannot be overloaded, you should declare 
 * this method instead which will be called at the end of the constructor
 *
 * @params none
 * @return void
 * @throws none
**/
    /*
    public function init()
    {
    
    }
    */

/**
 * Upgrade
 *
 * The blocks subsystem determines if a block is in upgrade state and,
 * if so, calls this method automatically when the block is instantiated
 * You should use this method to sync content coming from the db with any
 * changes to your block type.
 *
 * @param string $oldversion the version we're upgrading from
 * @return bool true on success
 * @throws none
**/
    /*
    public function upgrade($oldversion)
    {
        switch ($oldversion) {
            case '0.0.1':
                // fall through to next version
            case '0.0.2':
                // etc..
            //current version
            default:
        break;
        return true;
    }
    */

/**
 * Delete
 *
 * The blocks subsystem calls this method immediately before a block
 * instance is removed from the database. 
 * Use it if you need to perform housekeeping tasks on removal.
 *
 * @params none
 * @return bool true on success
 * @throws none
**/
    /*
    public function delete()
    {
        return true;
    }
    */

/**
 * If our block has methods shared by different interfaces, 
 * we can declare them here and our subclasses will inherit them...
**/
    /*
    public function commonmethod()
    {
    
    }
    */

/**
 * We could also declare any or all of our other methods here if we wanted to,
 * however for performance we're declaring them in their own files
 * See:
 * ./example_display.php
 * ./example_config.php
**/


}
?>