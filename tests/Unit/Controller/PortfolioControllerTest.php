<?php
namespace OCA\Portfolio\Tests\Unit\Controller;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

use OCA\Portfolio\Service\PortfolioNotFound;
use OCA\Portfolio\Service\PortfolioService;
use OCA\Portfolio\Controller\PortfolioController;


class PortfolioControllerTest extends PHPUnit_Framework_TestCase {

    protected $controller;
    protected $service;
    protected $userId = 'john';
    protected $request;

    public function setUp() {
        $this->request = $this->getMockBuilder(IRequest::class)->getMock();
        $this->service = $this->getMockBuilder(PortfolioService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->controller = new PortfolioController(
            'portfolio', $this->request, $this->service, $this->userId
        );
    }

    public function testUpdate() {
        $portfolio = 'just check if this value is returned correctly';
        $this->service->expects($this->once())
            ->method('update')
            ->with($this->equalTo(3),
                    $this->equalTo('title'),
                    $this->equalTo('content'),
                   $this->equalTo($this->userId))
            ->will($this->returnValue($portfolio));

        $result = $this->controller->update(3, 'title', 'content');

        $this->assertEquals($portfolio, $result->getData());
    }


    public function testUpdateNotFound() {
        // test the correct status code if no portfolio is found
//        $this->service->expects($this->once())
//            ->method('update')
//            ->will($this->throwException(new PortfolioNotFound()));
//
//        $result = $this->controller->update(3, 'title', 'content');
//
//        $this->assertEquals(Http::STATUS_NOT_FOUND, $result->getStatus());
    }

}
