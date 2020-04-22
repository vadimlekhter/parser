<?php

class CreateHhPortfolioTable extends Ruckusing_Migration_Base
{
    public function up()
    {
        $table = $this->create_table('hh_portfolio', array('options' => 'ENGINE=InnoDB DEFAULT CHARSET=utf8'));

        $table->column('id_ank', 'integer', array('unsigned' => true));
        $table->column('name', 'string', array('limit' => '48'));

        $table->finish();

        $this->execute("ALTER TABLE hh_portfolio ADD CONSTRAINT fk_hh_portfolio_hh_ankets FOREIGN KEY(id_ank)"
                       ." REFERENCES hh_ankets(id) ON DELETE CASCADE ON UPDATE CASCADE");
    }//up()

    public function down()
    {
        $this->drop_table('hh_portfolio');
    }//down()
}
