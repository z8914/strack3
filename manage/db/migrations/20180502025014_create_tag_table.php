<?php


use Phinx\Migration\AbstractMigration;

class CreateTagTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('strack_tag', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '标签ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '标签名称'])
            ->addColumn('type', 'enum', ['values' => 'system,review,approve,publish,custom', 'default' => 'system', 'comment' => '标签类型'])
            ->addColumn('color', 'char', ['default' => '000000', 'limit' => 6, 'comment' => '标签颜色'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //添加索引
        $table->addIndex(['name'], ['type' => 'normal', 'name' => 'idx_tag_name']);

        //执行创建
        $table->create();
    }
}
