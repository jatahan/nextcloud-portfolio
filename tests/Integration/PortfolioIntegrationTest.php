<?php
namespace OCA\Portfolio\Tests\Integration\Controller;

use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\App;
use OCP\IRequest;
use PHPUnit_Framework_TestCase;


use OCA\Portfolio\Db\Portfolio;
use OCA\Portfolio\Db\PortfolioMapper;
use OCA\Portfolio\Controller\PortfolioController;
use OCP\IDBConnection;

class PortfolioIntegrationTest extends PHPUnit_Framework_TestCase {

    private $controller;
    private $mapper;
    private $userId = 'john';

    public function setUp() {
        $app = new App('portfolio');
        $container = $app->getContainer();

        // only replace the user id
        $container->registerService('userId', function() {
            return $this->userId;
        });

        // we do not care about the request but the controller needs it
        $container->registerService(IRequest::class, function() {
            return $this->createMock(IRequest::class);
        });

        $this->controller = $container->query(PortfolioController::class);
        $this->mapper = $container->query(PortfolioMapper::class);
    }

    public function testUpdate() {
        // create a new portfolio that should be updated
        $portfolio = new Portfolio();
        $portfolio->setTitle('old_title');
        $portfolio->setContent('old_content');
        $portfolio->setUserId($this->userId);

        $id = $this->mapper->insert($portfolio)->getId();

        // fromRow does not set the fields as updated
        $updatedPortfolio = Portfolio::fromRow([
            'id' => $id,
            'user_id' => $this->userId
        ]);
        $updatedPortfolio->setContent('content');
        $updatedPortfolio->setTitle('title');

        $result = $this->controller->update($id, 'title', 'content');

        $this->assertEquals($updatedPortfolio, $result->getData());

        // clean up
        $this->mapper->delete($result->getData());
    }

}
