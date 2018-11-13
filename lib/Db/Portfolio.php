<?php
namespace OCA\Portfolio\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Portfolio extends Entity implements JsonSerializable {

    protected $title;
    protected $content;
    protected $userId;

    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content
        ];
    }
}
