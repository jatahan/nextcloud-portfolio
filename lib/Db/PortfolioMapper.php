<?php
namespace OCA\Portfolio\Db;

use OCP\IDBConnection;
use OCP\AppFramework\Db\Mapper;

class PortfolioMapper extends Mapper {

    public function __construct(IDBConnection $db) {
        parent::__construct($db, 'portfolio', '\OCA\Portfolio\Db\Portfolio');
    }

    public function find(int $id, string $userId): Portfolio {
        $sql = 'SELECT * FROM *PREFIX*portfolios WHERE id = ? AND user_id = ?';
        return $this->findEntity($sql, [$id, $userId]);
    }

    public function findAll(string $userId): array {
        $sql = 'SELECT * FROM *PREFIX*portfolios WHERE user_id = ?';
        return $this->findEntities($sql, [$userId]);
    }

}
