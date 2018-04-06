<?php
namespace tests\AppBundle\Context;
 
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Exception;
use AppBundle\Command\ImportCSVCommand;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
 
class CommandContext implements KernelAwareContext
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
     * @Given a shell console
     */
    public function aShellConsole()
    {
        //throw new PendingException();
    }

    /**
     * @When I execute the :commandName command
     */
    public function iExecuteTheCommand($commandName)
    {
    	$this->setApplication();
        $this->addCommand(new ImportCSVCommand());
        $this->setCommand( $commandName );
 
        try {
            $this->getTester($this->command)->execute([]);
        } catch (Exception $exception) {
            $path = explode('\\', get_class($exception));
            $this->commandException = array_pop($path);
        }
    }
 
    /**
     * @param string $expectedOutput
     *
     * @Then /^the command output should be "([^"]*)"$/
     */
    public function theCommandOutputShouldBe($expectedOutput)
    {
        $output = trim($this->commandTester->getDisplay());
        if ($output != $expectedOutput) {
            throw new LogicException(sprintf('Current output is: [%s]', $output));
        }
    }
 
    /**
     * @param string $expectedException
     *
     * @Then /^the command exception should be "([^"]*)"$/
     */
    public function theCommandExceptionShouldBe($expectedException)
    {
        if ($this->commandException != $expectedException) {
            throw new LogicException(sprintf('Current exception is: [%s]', $this->commandException));
        }
    }
 
    private function setApplication()
    {
        $this->application = new Application($this->kernel);
    }
 
    private function addCommand(Command $command)
    {
        $this->application->add($command);
    }
 
    private function setCommand($commandName)
    {
        $this->command = $this->application->find($commandName);
    }
 
    private function setOptions(TableNode $tableNode)
    {
        $options = [];
        foreach ($tableNode->getRowsHash() as $key => $value) {
            $options[$key] = $value;
        }
 
        $this->options = $options;
    }
 
    private function getTester(Command $command)
    {
        $this->commandTester = new CommandTester($command);
 
        return $this->commandTester;
    }
}