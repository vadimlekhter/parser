<?php

class CreateHhResumeParsingTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $table = $this->create_table('resume_parsings', array('options' => 'ENGINE=InnoDB DEFAULT CHARSET=utf8'));

        $table->column('url', 'string', array('limit' => '256'));
        $table->column('login', 'string', array('limit' => '64'));
        $table->column('password', 'string', array('limit' => '64'));
        $table->column('date', 'datetime');

        $table->finish();
    }//up()

    public function down()
    {
        $this->drop_table('resume_parsings');
    }//down()
}
