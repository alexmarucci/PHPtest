<?php
namespace tests\AppBundle\Context;
 
use AppBundle\Entity\Transaction;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behatch\Context\RestContext as BehatchRest;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

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
    /**
     * @BeforeScenario
     */
     public function prepare(BeforeScenarioScope $scope)
     {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();

        $stmt = $em->getConnection()->prepare('INSERT INTO Transaction(id, total_amount, currency) VALUES(1, "1", "GBP")');
        $stmt->execute();
     }

    public function iSendARequestTo($method, $url, PyStringNode $body = null, $files = [])
    {
        if(null !== $body){
            $body = $body->getRaw();
            $body = trim(preg_replace('/\s+/', ' ', $body));
            $body = json_decode($body, true);
        }

        return $this->request->send(
            $method,
            $this->locatePath($url),
            is_array($body) ? $body : [],
            $files,
            $body !== null ? $body : null,
            ['content_type' => 'application/json']
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

    /** @AfterScenario */
    public function cleanDB(AfterScenarioScope $event)
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $query = $em->createQuery('DELETE FROM AppBundle:Refund');
        $query = $em->createQuery('DELETE FROM AppBundle:Transaction');
        $query->execute(); 
    }
}