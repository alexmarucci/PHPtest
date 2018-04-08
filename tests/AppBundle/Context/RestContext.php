<?php
namespace tests\AppBundle\Context;
 
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behatch\Context\RestContext as BehatchRest;
 
class RestContext extends BehatchRest implements KernelAwareContext
{

    /** @var KernelInterface */
    private $kernel;
    /** @var Application */
    private $application;
    /** @var Command */
    private $command;
    /** @var CommandTester */
    private $commandTester;
    /** @var string */
    private $commandException;
    /** @var array */
    private $options;
 
    /**
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function iSendARequestTo($method, $url, PyStringNode $body = null, $files = [])
    {
        if(null !== $body){
            $body = $body->getRaw();
            $body = trim(preg_replace('/\s+/', ' ', $body));
        }

        return $this->request->send(
            $method,
            $this->locatePath($url),
            [],
            $files,
            $body !== null ? $body : null,
            ['Content-Type: application/json']
        );
    }

    /**
     * @Then the :key property should be equals to :expected
     */
    public function thePropertyShouldBeEqualsTo($key, $expected)
    {
    	/**
    	$expected = str_replace('\\"', '"', $expected);
        $actual   = $this->request->getContent();
        $message = "Actual response is '$actual', but expected '$expected'";
        $this->assertEquals($expected, $actual, $message);
    	$response = $this->request->getContent();
    	*/
    }
}