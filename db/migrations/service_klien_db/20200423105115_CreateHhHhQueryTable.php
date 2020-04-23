<?php

class CreateHhHhQueryTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $table = $this->create_table('hh_query', array('options' => 'ENGINE=InnoDB DEFAULT CHARSET=utf8'));

        $table->column('text', 'text');
        $table->column('url', 'string', array('limit' => '256'));
        $table->column('date', 'datetime');

        $table->finish();

    }//up()

    public function down()
    {
        $this->drop_table('hh_query');
    }//down()
}
