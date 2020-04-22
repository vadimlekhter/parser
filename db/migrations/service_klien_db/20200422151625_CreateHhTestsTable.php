<?php

class CreateHhTestsTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $table = $this->create_table('hh_tests', array('options' => 'ENGINE=InnoDB DEFAULT CHARSET=utf8'));

        $table->column('id_ank', 'integer', array('unsigned' => true));
        $table->column('year', 'string', array('limit' => '16'));
        $table->column('name', 'string', array('limit' => '128'));
        $table->column('otdel', 'string', array('limit' => '128'));
        $table->column('spec', 'string', array('limit' => '128'));

        $table->finish();

        $this->execute("ALTER TABLE hh_tests ADD CONSTRAINT fk_hh_tests_hh_ankets FOREIGN KEY(id_ank)"
                       ." REFERENCES hh_ankets(id) ON DELETE CASCADE ON UPDATE CASCADE");
    }//up()

    public function down()
    {
        $this->drop_table('hh_tests');
    }//down()
}
