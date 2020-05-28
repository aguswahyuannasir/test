<?php
class Migration_First_Migrations extends CI_Migration {

  public function up()
  {
    $fields = array(
      'id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
      'username VARCHAR(10) DEFAULT NULL',
      'password VARCHAR(50) DEFAULT NULL'
    );

    $this->dbforge->add_field($fields);
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->create_table('users');
  }

  public function down()
  {
    $this->dbforge->drop_table('users');
  }
}