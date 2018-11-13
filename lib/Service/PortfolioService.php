<?php
namespace OCA\Portfolio\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\Portfolio\Db\Portfolio;
use OCA\Portfolio\Db\PortfolioMapper;


class PortfolioService {

    /** @var PortfolioMapper */
    private $mapper;

    public function __construct(PortfolioMapper $mapper){
        $this->mapper = $mapper;
    }

    public function findAll(string $userId): array {
        return $this->mapper->findAll($userId);
    }

    private function handleException (Exception $e): void {
        if ($e instanceof DoesNotExistException ||
            $e instanceof MultipleObjectsReturnedException) {
            throw new PortfolioNotFound($e->getMessage());
        } else {
            throw $e;
        }
    }

    public function find($id, $userId) {
        try {
            return $this->mapper->find($id, $userId);

        // in order to be able to plug in different storage backends like files
        // for instance it is a good idea to turn storage related exceptions
        // into service related exceptions so controllers and service users
        // have to deal with only one type of exception
        } catch(Exception $e) {
            $this->handleException($e);
        }
    }

    public function create($title, $content, $userId) {
        $portfolio = new Portfolio();
        $portfolio->setTitle($title);
        $portfolio->setContent($content);
        $portfolio->setUserId($userId);
        return $this->mapper->insert($portfolio);
    }

    public function update($id, $title, $content, $userId) {
        try {
            $portfolio = $this->mapper->find($id, $userId);
            $portfolio->setTitle($title);
            $portfolio->setContent($content);
            return $this->mapper->update($portfolio);
        } catch(Exception $e) {
            $this->handleException($e);
        }
    }

    public function delete($id, $userId) {
        try {
            $portfolio = $this->mapper->find($id, $userId);
            $this->mapper->delete($portfolio);
            return $portfolio;
        } catch(Exception $e) {
            $this->handleException($e);
        }
    }

}
