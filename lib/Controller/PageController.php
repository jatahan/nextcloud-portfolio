<?php
 namespace OCA\Portfolio\Controller;

 use OCP\IRequest;
 use OCP\AppFramework\Http\TemplateResponse;
 use OCP\AppFramework\Controller;
 use OCA\Portfolio\Service\Portfolio;

 class PageController extends Controller {

     public function __construct($appName, IRequest $request){
         parent::__construct($appName, $request);
     }

     /**
      * @NoAdminRequired
      * @NoCSRFRequired
      */
     public function index() {
         return new TemplateResponse('portfolio', 'index');
     }

 }
