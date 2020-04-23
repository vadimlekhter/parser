<?php

class AddNoContactsColumnHhAnketsTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $this->add_column("hh_ankets", "no_contacts", "boolean", array('default' => false,
            'null' => false));
    }//up()

    public function down()
    {
        $this->remove_column("hh_ankets", "no_contacts");
    }//down()
}
