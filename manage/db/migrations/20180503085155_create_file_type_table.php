<?php


use Phinx\Migration\AbstractMigration;

class CreateFileTypeTable extends AbstractMigration
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
        $table = $this->table('strack_file_type', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '文件类型ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '文件类型名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '文件类型编码'])
            ->addColumn('type', 'string', ['default' => '', 'limit' => 128, 'comment' => '类型'])
            ->addColumn('ext', 'string', ['default' => '', 'limit' => 128, 'comment' => '文件后缀名'])
            ->addColumn('project_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '项目ID'])
            ->addColumn('step_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '工序ID'])
            ->addColumn('dir_template_code', 'string', ['default' => '', 'limit' => 255, 'comment' => '发布文件夹路径'])
            ->addColumn('uuid', 'char', ['default' => '', 'limit' => 36, 'comment' => '全局唯一标识符']);

        //执行创建
        $table->create();
    }
}
