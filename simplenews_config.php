<?php
/**
 * SimpleNews Block
 *
 * @package blocks
 * @subpackage simplenews block
 * @category Third Party Xaraya Block
 * @version 1.0.0
 * @copyright (C) 2012 Netspan AG
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Marc Lutolf <mfl@netspan.ch>
 */

sys::import('blocks.simplenews.simplenews');

class SimplenewsBlockConfig extends SimplenewsBlock implements iBlock
{
    protected $invalid = array();
/**
 * Validation helpers
 *
 * These methods are called by this class during modify, check and update phases
**/
/**
 * setInvalid
 * @param string $key an identifier for the invalid message 
 * @param string $msg the error message to display (a null msg deletes the key if present)
 * @return bool true on success
 * @throws none
**/
    protected function setInvalid($key, $msg=null) 
    {
        if ($msg == null) {
            if (isset($this->invalid[$key]))
                unset($this->invalid[$key]);
            return true;
        }
        $this->invalid[$key] = $msg;
        return true;
    }
/**
 * getInvalid
 * @param string $key an identifier for the invalid message (a null key returns all messages)
 * @return mixed array of messages, or if $key supplied string message, false if not found
 * @throws none
**/    
    public function getInvalid($key=null) 
    {
        if ($key != null) {
            if (isset($this->invalid[$key]))
                return $this->invalid[$key];
            return false;
        }
        return $this->invalid;
    }
/**
 * isValid
 * @param string $key an identifier to check if message is present (a null key evaluates all messages)
 * @return bool true if no message(s) found
 * @throws none
**/    
    public function isValid($key=null)
    {
        return (bool) $this->getInvalid($key) ? false : true;
    }
/**
 * clearInvalid
 * @param none
 * @return void
 * @throws none
**/    
    protected function clearInvalid()
    {
        $this->invalid = array();
    }

    public function configmodify()
    {
        $data = $this->getContent();
    
        $data['fields'] = array('id', 'name');

        if (!is_array($this->pubstate)) {
            $statearray = array($this->pubstate);
        } else {
            $statearray = $this->pubstate;
        }
    
        if(!empty($this->catfilter)) {
            $cidsarray = array($this->catfilter);
        } else {
            $cidsarray = array();
        }

        // Create array based on modifications
        $article_args = array();

        // Only include pubtype if a specific pubtype is selected
        if (!empty($this->pubtype_id)) {
            $article_args['ptid'] = $this->pubtype_id;
        }

        // If itemlimit is set to 0, then don't pass to getall
        if ($this->itemlimit != 0 ) {
            $article_args['numitems'] = $this->itemlimit;
        }
    
        // Add the rest of the arguments
        $article_args['cids'] = $cidsarray;
        $article_args['enddate'] = time();
        $article_args['state'] = $statearray;
        $article_args['fields'] = $data['fields'];
        $article_args['sort'] = 'name';

        $data['filtereditems'] = $this->getItems($article_args);

        //new filter array to get the publications with parent_id = 0
        $data['newfiltereditems'] = array();
        foreach ($data['filtereditems'] as $key => $filtereditem) {
            if ($filtereditem['parent_id'] == 0) {
                $data['newfiltereditems'][] = array('id' => $filtereditem['id'],
                                         'name' => $filtereditem['name'],
                                         'title' => $filtereditem['title'],
                                         'parent_id' => $filtereditem['parent_id']);
            }
        }

        // create grouping of array with base and translations items.
        //add the entries with parent_id != 0 behind each parent entry
        sys::import('xaraya.structures.query');
        $tables =& xarDB::getTables();
        $items1 = array();
        foreach ($data['newfiltereditems'] as $k => $value) {
            //array for item which have parent_id=0
            $value1[] = $value;

            $q = new Query('SELECT', $tables['publications']);
            $q->addfield('id');
            $q->addfield('name');
            $q->addfield('title');
            $q->addfield('parent_id');
            $q->eq('parent_id',$value['id']);
            $q->eq('state',3);
            $q->eq('pubtype_id',$article_args['ptid']);
            $q->run();

            //getting items for each parent id
            $items = $q->output();
            if(!empty($items)) {
                foreach ($items as $item) {
                    //items1 array to display the translation in multiselect box with leading hypens ( - - translation1)
                    $items1[] = array('id' => $item['id'],
                             'name' => ' - - '.$item['name'],
                             'title' => $item['title'],
                             'parent_id' => $item['parent_id']);
                }
                //creating new array with parent and translations
                $newitems[] = array_merge($value1, $items1);
                unset($value1);
                unset($items1);
            } else {
                //if items with parent_is=0 not having translations
                if (!in_array($value1, $newitems)) {
                    $newitems[] = $value1;
                }
                unset($value1);
            }
        }
        // formatting final array for display purpose.
        foreach ($newitems as $k1 => $val) {
            foreach ($val as $k2 => $v) {
                $a[] = array('id' => $v['id'],
                             'name' => $v['name'],
                             'title' => $v['title'],
                             'parent_id' => $v['parent_id']);
            }
        }
        $data['filtereditems_new'] = $a;

// Check for exceptions
//    if (!isset($vars['filtereditems']) && xarCurrentErrorType() != XAR_NO_EXCEPTION)
//        return; // throw back

        // Try to keep the additional headlines select list width less than 50 characters
        for ($idx = 0; $idx < count($data['filtereditems']); $idx++) {
            if (strlen($data['filtereditems'][$idx]['title']) > 50) {
                $data['filtereditems'][$idx]['title'] = substr($data['filtereditems'][$idx]['title'], 0, 47) . '...';
            }
        }

        $data['pubtypes'] = xarModAPIFunc('publications', 'user', 'get_pubtypes');
        $data['categorylist'] = xarModAPIFunc('categories', 'user', 'getcat');

        $data['sortoptions'] = array(
            array('id' => 'author', 'name' => xarML('Author')),
            array('id' => 'date', 'name' => xarML('Date')),
            array('id' => 'hits', 'name' => xarML('Hit Count')),
            array('id' => 'rating', 'name' => xarML('Rating')),
            array('id' => 'name', 'name' => xarML('Name')),
            array('id' => 'title', 'name' => xarML('Title'))
        );
    
        //Put together the additional featured publications list
        for($idx=0; $idx < count($data['filtereditems']); ++$idx) {
            $data['filtereditems'][$idx]['selected'] = '';
            for($mx=0; $mx < count($data['moreitems']); ++$mx) {
                if (($data['moreitems'][$mx]) == ($data['filtereditems'][$idx]['id'])) {
                    $data['filtereditems'][$idx]['selected'] = 'selected';
                }
            }
        }
        $data['morepublications'] = $data['filtereditems'];
        $data['catfilter'] = $this->catfilter;
        $data['numitems'] = $this->numitems;
        $data['alttitle'] = $this->alttitle;

        return $data;
    }

    public function configUpdate(Array $data=array())
    {
        // Get the simple values
        xarVarFetch('pubtype_id',       'int',       $args['pubtype_id'],      $this->pubtype_id, XARVAR_NOT_REQUIRED);
        xarVarFetch('catfilter',        'id',        $args['catfilter'],       $this->catfilter, XARVAR_NOT_REQUIRED);
        xarVarFetch('nocatlimit',       'checkbox',  $args['nocatlimit'],      $this->nocatlimit, XARVAR_NOT_REQUIRED);
        xarVarFetch('pubstate',         'str',       $args['pubstate'],        $this->pubstate, XARVAR_NOT_REQUIRED);
        xarVarFetch('locale',           'str',       $args['locale'],          $this->locale, XARVAR_NOT_REQUIRED);
        xarVarFetch('itemlimit',        'int:1',     $args['itemlimit'],       $this->itemlimit, XARVAR_NOT_REQUIRED);
        xarVarFetch('toptype',  'enum:author:date:hits:rating:title', $args['toptype'], $this->toptype, XARVAR_NOT_REQUIRED);
        xarVarFetch('showsummary',      'checkbox',  $args['showsummary'],     0, XARVAR_NOT_REQUIRED);
        xarVarFetch('showvalue',        'checkbox',  $args['showvalue'],       0, XARVAR_NOT_REQUIRED);
        xarVarFetch('linkpubtype',      'checkbox',  $args['linkpubtype'],     0, XARVAR_NOT_REQUIRED);
        xarVarFetch('linkcat',          'checkbox',  $args['linkcat'],         0, XARVAR_NOT_REQUIRED);
/*
        xarVarFetch('alttitle',         'str',       $args['alttitle'],        $this->alttitle, XARVAR_NOT_REQUIRED);
        xarVarFetch('showfeaturedbod',  'checkbox',  $args['showfeaturedbod'], 0, XARVAR_NOT_REQUIRED);
        xarVarFetch('showfeaturedsum',  'checkbox',  $args['showfeaturedsum'], 0, XARVAR_NOT_REQUIRED);
        xarVarFetch('altsummary',       'str',       $args['altsummary'],      $this->altsummary, XARVAR_NOT_REQUIRED);
        xarVarFetch('moreitems',        'list:id',   $args['moreitems'],       $this->moreitems, XARVAR_NOT_REQUIRED);
*/        
        // Get the array of featured IDs
        $multiselect = DataPropertyMaster::getProperty(array('name' => 'multiselect'));
        $multiselect->options = $this->getItems();
        $valid = $multiselect->checkInput('featuredids');
        if ($valid) $args['featuredids'] = $multiselect->value;
        
        $this->setContent($args);
        return true;        
    }

    private function getItems(Array $data=array())
    {
        $items = xarModAPIFunc('publications', 'user', 'getall', $data );
        return $items;
    }
}
?>