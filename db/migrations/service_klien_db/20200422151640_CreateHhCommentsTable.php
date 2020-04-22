<?php

class CreateHhCommentsTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $table = $this->create_table('hh_comments', array('options' => 'ENGINE=InnoDB DEFAULT CHARSET=utf8'));

        $table->column('id_ank', 'integer', array('unsigned' => true));
        $table->column('text', 'text');
        $table->column('comm_author', 'string', array('limit' => '64'));
        $table->column('comm_date', 'string', array('limit' => '64'));

        $table->finish();

        $this->execute("ALTER TABLE hh_comments ADD CONSTRAINT fk_hh_comments_hh_ankets FOREIGN KEY(id_ank)"
                       ." REFERENCES hh_ankets(id) ON DELETE CASCADE ON UPDATE CASCADE");
    }//up()

    public function down()
    {
        $this->drop_table('hh_comments');
    }//down()
}
