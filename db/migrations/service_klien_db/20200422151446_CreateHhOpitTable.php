<?php

class CreateHhOpitTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $table = $this->create_table('hh_opit', array('options' => 'ENGINE=InnoDB DEFAULT CHARSET=utf8'));

        $table->column('id_ank', 'integer', array('unsigned' => true));
        $table->column('last', 'string', array('limit' => '64'));
        $table->column('period', 'string', array('limit' => '48'));
        $table->column('nam', 'string', array('limit' => '128'));
        $table->column('ind', 'string', array('limit' => '128'));
        $table->column('pod_ind', 'string', array('limit' => '256'));
        $table->column('adres', 'string', array('limit' => '48'));
        $table->column('position', 'string', array('limit' => '128'));
        $table->column('descr', 'text');

        $table->finish();

        $this->execute("ALTER TABLE hh_opit ADD CONSTRAINT fk_hh_opit_hh_ankets FOREIGN KEY(id_ank)"
                       ." REFERENCES hh_ankets(id) ON DELETE CASCADE ON UPDATE CASCADE");

    }//up()

    public function down()
    {
        $this->drop_table('hh_opit');
    }//down()
}

