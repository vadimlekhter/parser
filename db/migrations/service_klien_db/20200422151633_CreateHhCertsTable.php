<?php

class CreateHhCertsTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $table = $this->create_table('hh_certs', array('options' => 'ENGINE=InnoDB DEFAULT CHARSET=utf8'));

        $table->column('id_ank', 'integer', array('unsigned' => true));
        $table->column('link', 'string', array('limit' => '128'));
        $table->column('name', 'string', array('limit' => '128'));

        $table->finish();

        $this->execute("ALTER TABLE hh_certs ADD CONSTRAINT fk_hh_certs_hh_ankets FOREIGN KEY(id_ank)"
                       ." REFERENCES hh_ankets(id) ON DELETE CASCADE ON UPDATE CASCADE");
    }//up()

    public function down()
    {
        $this->drop_table('hh_certs');
    }//down()
}