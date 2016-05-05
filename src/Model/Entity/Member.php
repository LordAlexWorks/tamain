<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Member Entity.
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property \Cake\I18n\Time $birthdate
 * @property string $email
 * @property string $job
 * @property string $company
 * @property string $twitter
 * @property bool $active
 * @property \App\Model\Entity\Membership[] $membership
 */
class Member extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Virtual fields
     */
    protected $_virtual = ['full_name'];
    
    /**
     * Return first and last name concatenated
     * @return string
     */
    protected function _getFullName() {
        return $this->_properties['firstname'] . '  ' .
                $this->_properties['lastname'];
    }

    public function import($filename) {
        // set the filename to read CSV from
        $filename = TMP . 'uploads' . DS . 'Members' . DS . $filename;

        echo $filename;
        
        // create a message container
        $return = array(
            'messages' => array(),
            'errors' => array(),
        );

        // open the file
        $handle = fopen($filename, "r");
        
        // read the 1st row as headings
        $length = 0;
        $delimiter = ";";
        $header = fgetcsv($handle,$length,$delimiter);
        $numHeaderCols = count($header);

        // read each data row in the file
        $col = 0;
        $i = 0;
        while (($csv_row = fgetcsv($handle)) !== FALSE) {
            $i++;
            $data = array();

            foreach ($csv_row as $csv_column) {
                $col++;

                $value = $csv_column;

                // New row/column begins
                if ($col > $numHeaderCols) {
                    $col = 0;
                }

                echo "<strong>COLUMN ".((isset($header[$col])) ? $header[$col] : '')."</strong>";
                echo " is: $value";
                echo "<br />";
            }

            // // for each header field 
            // foreach ($header as $k=>$head) {
            //     echo "<br /><br />";
            //     echo (isset($row[$k])) ? $row[$k] : '';

            //     // parse column
            // }

            // // see if we have an id             
            // $id = isset($data['Post']['id']) ? $data['Post']['id'] : 0;

            // // we have an id, so we update
            // if ($id) {
            //     // there is 2 options here, 
                 
            //     // option 1:
            //     // load the current row, and merge it with the new data
            //     //$this->recursive = -1;
            //     //$post = $this->read(null,$id);
            //     //$data['Post'] = array_merge($post['Post'],$data['Post']);
                
            //     // option 2:
            //     // set the model id
            //     $this->id = $id;
            // }
            
            // // or create a new record
            // else {
            //     $this->create();
            // }
            
            // // see what we have
            // // debug($data);
            
            // // validate the row
            // $this->set($data);
            // if (!$this->validates()) {
            //     $this->_flash(,'warning');
            //     $return['errors'][] = __(sprintf('Post for Row %d failed to validate.',$i), true);
            // }

            // // save the row
            // if (!$error && !$this->save($data)) {
            //     $return['errors'][] = __(sprintf('Post for Row %d failed to save.',$i), true);
            // }

            // // success message!
            // if (!$error) {
            //     $return['messages'][] = __(sprintf('Post for Row %d was saved.',$i), true);
            // }
        }
        
        // close the file
        fclose($handle);
        
        // return the messages
        return $return;
        
    }
}
