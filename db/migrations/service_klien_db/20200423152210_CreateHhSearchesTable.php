<?php

class CreateHhSearchesTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $table = $this->create_table('hh_searches', array('options' => 'ENGINE=InnoDB DEFAULT CHARSET=utf8'));

        $table->column('id_query', 'integer', array('unsigned' => true));
        $table->column('date', 'datetime');
        $table->column('anketa', 'string', array('limit' => '128'));
        $table->column('pos', 'integer', array('limit' => '10'));

        $table->finish();

        $this->execute("ALTER TABLE hh_searches ADD CONSTRAINT fk_hh_searches_hh_query FOREIGN KEY(id_query)"
                       ." REFERENCES hh_query(id) ON DELETE CASCADE ON UPDATE CASCADE");
    }//up()

    public function down()
    {
        $this->drop_table('hh_searches');
    }//down()
}
