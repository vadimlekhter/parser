<?php

class CreateHhAnketsTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $table = $this->create_table('hh_ankets', array('options' => 'ENGINE=InnoDB DEFAULT CHARSET=utf8'));

        $table->column('fio', 'string', array('limit' => '128'));
        $table->column('gender', 'string', array('limit' => '15'));
        $table->column('age', 'integer', array('limit' => '5'));
        $table->column('birth', 'string', array('limit' => '24'));
        $table->column('city', 'string', array('limit' => '32'));
        $table->column('phone', 'string', array('limit' => '24'));
        $table->column('email', 'string', array('limit' => '48'));
        $table->column('pref_conn', 'string', array('limit' => '48'));
        $table->column('skype', 'string', array('limit' => '48'));
        $table->column('site', 'string', array('limit' => '48'));
        $table->column('position', 'string', array('limit' => '128'));
        $table->column('activity_field', 'string', array('limit' => '128'));
        $table->column('specialization', 'string', array('limit' => '256'));
        $table->column('cost', 'string', array('limit' => '48'));
        $table->column('occupation', 'string', array('limit' => '128'));
        $table->column('shedule', 'string', array('limit' => '128'));
        $table->column('opit_all', 'string', array('limit' => '48'));
        $table->column('pereezd', 'string', array('limit' => '48'));
        $table->column('comand', 'string', array('limit' => '128'));
        $table->column('dat_update', 'string', array('limit' => '128'));
        $table->column('about', 'text');
        $table->column('skills', 'text');
        $table->column('driving', 'string', array('limit' => '128'));
        $table->column('citizen', 'string', array('limit' => '48'));
        $table->column('work_perm', 'string', array('limit' => '48'));
        $table->column('time_to_work', 'string', array('limit' => '48'));

        $table->finish();

    }//up()

    public function down()
    {
        $this->drop_table('hh_ankets');
    }//down()
}
