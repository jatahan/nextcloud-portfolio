<?php
namespace OCA\Portfolio\Tests\Unit\Service;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Db\DoesNotExistException;

use OCA\Portfolio\Db\Portfolio;
use OCA\Portfolio\Service\PortfolioService;
use OCA\Portfolio\Db\PortfolioMapper;

class PortfolioServiceTest extends PHPUnit_Framework_TestCase {

    private $service;
    private $mapper;
    private $userId = 'john';

    public function setUp() {
        $this->mapper = $this->getMockBuilder(PortfolioMapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->service = new PortfolioService($this->mapper);
    }

    public function testUpdate() {
        // the existing portfolio
        $portfolio = Portfolio::fromRow([
            'id' => 3,
            'title' => 'yo',
            'content' => 'nope'
        ]);
        $this->mapper->expects($this->once())
            ->method('find')
            ->with($this->equalTo(3))
            ->will($this->returnValue($portfolio));

        // the portfolio when updated
        $updatedPortfolio = Portfolio::fromRow(['id' => 3]);
        $updatedPortfolio->setTitle('title');
        $updatedPortfolio->setContent('content');
        $this->mapper->expects($this->once())
            ->method('update')
            ->with($this->equalTo($updatedPortfolio))
            ->will($this->returnValue($updatedPortfolio));

        $result = $this->service->update(3, 'title', 'content', $this->userId);

        $this->assertEquals($updatedPortfolio, $result);
    }


    /**
     * @expectedException OCA\Portfolio\Service\PortfolioNotFound
     */
    public function testUpdateNotFound() {
        // test the correct status code if no portfolio is found
        $this->mapper->expects($this->once())
            ->method('find')
            ->with($this->equalTo(3))
            ->will($this->throwException(new DoesNotExistException('')));

        $this->service->update(3, 'title', 'content', $this->userId);
    }

}
