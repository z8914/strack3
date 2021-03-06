<?php


use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class fillAppendEntitySideBarOnsetRules extends AbstractMigration
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

    /**
     * 保存权限组
     * @param $data
     * @param int $parentId
     */
    protected function savePageAuth($data, $parentId = 0)
    {
        $pageAuthTable = $this->table('strack_page_auth');
        $pageLinkAuthTable = $this->table('strack_page_link_auth');

        $data["page"]["parent_id"] = $parentId;

        $pageAuthTable->insert($data["page"])->save();
        $query = $this->fetchRow('SELECT max(`id`) as id FROM strack_page_auth');

        if (!empty($data["auth_group"])) {
            foreach ($data["auth_group"] as $authGroup) {
                $authGroup["page_auth_id"] = $query["id"];
                $pageLinkAuthTable->insert($authGroup)->save();
            }
        }

        if (!empty($data["list"])) {
            foreach ($data["list"] as $children) {
                $this->savePageAuth($children, $query["id"]);
            }
        }
    }

    /**
     * @throws Exception
     */
    public function up()
    {
        $queryList = $this->fetchAll('SELECT id,page,param FROM strack_page_auth WHERE page in ("home_project_entity") and code="onset"');

        foreach ($queryList as $item) {
            $pageRows = [
                'page' => [
                    'name' => '提交',
                    'code' => 'submit',
                    'lang' => 'Submit',
                    'page' => $item["page"],
                    'param' => $item['param'],
                    'type' => 'belong',
                    'parent_id' => 0,
                    'uuid' => Webpatser\Uuid\Uuid::generate()->string
                ],
                'auth_group' => [
                    [
                        'page_auth_id' => 0,
                        'auth_group_id' => 448,
                        'uuid' => Webpatser\Uuid\Uuid::generate()->string
                    ]
                ]
            ];
            $this->savePageAuth($pageRows, $item["id"]);
        }
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM strack_page_auth');
        $this->execute('DELETE FROM strack_page_link_auth');
    }
}
