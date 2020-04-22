<?php

class CreateHhHistoryTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $table = $this->create_table('hh_history', array('options' => 'ENGINE=InnoDB DEFAULT CHARSET=utf8'));

        $table->column('id_ank', 'integer', array('unsigned' => true));
        $table->column('text', 'text');
        $table->column('href', 'string', array('limit' => '128'));
        $table->column('hist_type', 'string', array('limit' => '32'));
        $table->column('hist_date', 'string', array('limit' => '32'));

        $table->finish();

        $this->execute("ALTER TABLE hh_history ADD CONSTRAINT fk_hh_history_hh_ankets FOREIGN KEY(id_ank)"
                       ." REFERENCES hh_ankets(id) ON DELETE CASCADE ON UPDATE CASCADE");
    }//up()

    public function down()
    {
        $this->drop_table('hh_history');
    }//down()
}
